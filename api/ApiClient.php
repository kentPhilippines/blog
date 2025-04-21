<?php
class ApiClient {
    private $baseUrl;
    
    public function __construct($baseUrl = null) {
        $this->baseUrl = $baseUrl ?: API_BASE_URL;
    }
    
    /**
     * 发送GET请求到API
     * 
     * @param string $endpoint API端点
     * @param array $params 请求参数
     * @return array 响应数据
     */
    public function get($endpoint, $params = []) {
        $url = $this->baseUrl . $endpoint;
        
        // 添加查询参数
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        // 打印请求信息到控制台
        error_log("API请求: " . $url);
        error_log("请求参数: " . json_encode($params, JSON_UNESCAPED_UNICODE));
        // 检查缓存
        $cacheKey = md5($url);
        $cachedData = $this->getCache($cacheKey);
        if ($cachedData !== false) {
            error_log("使用缓存数据: " . $cacheKey);
            return $cachedData;
        }
        // 发送请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时时间为30秒
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 不验证SSL证书
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // 处理请求错误
        if ($response === false) {
            error_log("API请求失败: " . $error);
            return [
                'code' => 500,
                'message' => '请求API失败: ' . $error,
                'data' => null
            ];
        }
        
        // 处理HTTP错误
        if ($httpCode != 200) {
            error_log("API HTTP错误: " . $httpCode);
            return [
                'code' => $httpCode,
                'message' => 'API返回HTTP错误: ' . $httpCode,
                'data' => null
            ];
        }
        
        // 解析JSON响应
        $data = json_decode($response, true);
        if ($data === null) {
            error_log("API响应JSON解析失败");
            return [
                'code' => 500,
                'message' => 'API响应格式错误',
                'data' => null
            ];
        }
        
        // 缓存成功的响应
        $this->setCache($cacheKey, $data, 300); // 缓存5分钟
        
        return $data;
    }
    
    /**
     * 获取新闻列表
     * 
     * @param int $pageNum 页码，默认1
     * @param int $pageSize 每页大小，默认10
     * @param string $categoryName 分类名称（可选）
     * @return array 新闻列表数据
     */
    public function getNewsList($pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $categoryName = null) {
        $domainConfig = SITE_DOMAIN;
        $params = [
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
            'domainConfig' => $domainConfig
        ];
        
        if ($categoryName) {
            $params['categoryName'] = $categoryName;
        }
        
        error_log("开始获取新闻列表，参数: " . json_encode($params, JSON_UNESCAPED_UNICODE));
        $response = $this->get('/api/news/list', $params);
        // 处理新闻列表数据，确保每个新闻项都有coverImage字段
        if (isset($response['code']) && $response['code'] == 200 && 
            isset($response['data']['list']) && is_array($response['data']['list'])) {
            
            error_log("获取到新闻列表，共 " . count($response['data']['list']) . " 条");
            
            foreach ($response['data']['list'] as &$news) {
                // 如果没有coverImage字段，尝试从新闻详情中获取
                if (!isset($news['coverImage']) || empty($news['coverImage'])) {
                    // 获取新闻详情
                    $newsDetail = $this->getNewsDetail($news['id']);
                    
                    // 如果成功获取新闻详情，并且有图片
                    if (isset($newsDetail['code']) && $newsDetail['code'] == 200 && 
                        isset($newsDetail['data']['images']) && is_array($newsDetail['data']['images'])) {
                        
                        // 查找封面图
                        foreach ($newsDetail['data']['images'] as $image) {
                            if (isset($image['isCover']) && $image['isCover']) {
                                $news['coverImage'] = $image['url'];
                                break;
                            }
                        }
                        
                        // 如果没有找到封面图，使用第一张图片
                        if (!isset($news['coverImage']) || empty($news['coverImage']) && 
                            !empty($newsDetail['data']['images'])) {
                            $news['coverImage'] = $newsDetail['data']['images'][0]['url'];
                        }
                    }
                }
            }
        } else {
            error_log("获取新闻列表失败或数据格式不正确: " . json_encode($response, JSON_UNESCAPED_UNICODE));
        }
        
        return $response;
    }
    
    /**
     * 获取新闻详情
     * 
     * @param int $id 新闻ID
     * @return array 新闻详情数据
     */
    public function getNewsDetail($id) {
        return $this->get("/api/news/detail/{$id}");
    }
    
    /**
     * 获取热门新闻
     * 
     * @param int $limit 限制数量，默认5
     * @return array 热门新闻数据
     */
    public function getHotNews($limit = 5) {
        $domainConfig = SITE_DOMAIN;
        $response = $this->get('/api/news/hot', ['limit' => $limit, 'domainConfig' => $domainConfig ]);
        error_log("获取热门新闻: " . json_encode($response, JSON_UNESCAPED_UNICODE));
        // 处理热门新闻数据，确保每个新闻项都有coverImage字段
        if (isset($response['code']) && $response['code'] == 200 && 
            isset($response['data']) && is_array($response['data'])) {
            
            foreach ($response['data'] as &$news) {
                // 如果没有coverImage字段，尝试从新闻详情中获取
                if (!isset($news['coverImage']) || empty($news['coverImage'])) {
                    // 获取新闻详情
                    $newsDetail = $this->getNewsDetail($news['id']);
                    
                    // 如果成功获取新闻详情，并且有图片
                    if (isset($newsDetail['code']) && $newsDetail['code'] == 200 && 
                        isset($newsDetail['data']['images']) && is_array($newsDetail['data']['images'])) {
                        
                        // 查找封面图
                        foreach ($newsDetail['data']['images'] as $image) {
                            if (isset($image['isCover']) && $image['isCover']) {
                                $news['coverImage'] = $image['url'];
                                break;
                            }
                        }
                        
                        // 如果没有找到封面图，使用第一张图片
                        if (!isset($news['coverImage']) || empty($news['coverImage'])) {
                            if (!empty($newsDetail['data']['images'])) {
                                $news['coverImage'] = $newsDetail['data']['images'][0]['url'];
                            }
                        }
                    }
                }
            }
        }
        
        return $response;
    }
    
    /**
     * 获取所有新闻（分页）
     * 
     * @param int $page 页码，默认0
     * @param int $size 每页大小，默认10
     * @param string $sortBy 排序字段，默认crawlTime
     * @param string $direction 排序方向，默认desc
     * @return array 所有新闻数据
     */
    public function getAllNews($page = 0, $size = DEFAULT_PAGE_SIZE, $sortBy = 'crawlTime', $direction = 'desc' ) {
        $domainConfig = SITE_DOMAIN;
        $params = [
            'page' => $page,
            'size' => $size,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'domainConfig' => $domainConfig
        ];
        
        return $this->get('/api/news', $params);
    }
    
    /**
     * 搜索新闻
     * 
     * @param string $keyword 搜索关键词
     * @param int $pageNum 页码，默认1
     * @param int $pageSize 每页大小，默认10
     * @return array 搜索结果数据
     */
    public function searchNews($keyword, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE) {
        $domainConfig = SITE_DOMAIN;
        $params = [
            'keyword' => $keyword,
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
            'domainConfig' => $domainConfig
        ];
        
        $response = $this->get('/api/news/search', $params);
        
        // 处理搜索结果数据，确保每个新闻项都有coverImage字段
        if (isset($response['code']) && $response['code'] == 200 && 
            isset($response['data']['list']) && is_array($response['data']['list'])) {
            
            foreach ($response['data']['list'] as &$news) {
                // 如果没有coverImage字段，尝试从新闻详情中获取
                if (!isset($news['coverImage']) || empty($news['coverImage'])) {
                    // 获取新闻详情
                    $newsDetail = $this->getNewsDetail($news['id']);
                    
                    // 如果成功获取新闻详情，并且有图片
                    if (isset($newsDetail['code']) && $newsDetail['code'] == 200 && 
                        isset($newsDetail['data']['images']) && is_array($newsDetail['data']['images'])) {
                        
                        // 查找封面图
                        foreach ($newsDetail['data']['images'] as $image) {
                            if (isset($image['isCover']) && $image['isCover']) {
                                $news['coverImage'] = $image['url'];
                                break;
                            }
                        }
                        
                        // 如果没有找到封面图，使用第一张图片
                        if (!isset($news['coverImage']) || empty($news['coverImage'])) {
                            if (!empty($newsDetail['data']['images'])) {
                                $news['coverImage'] = $newsDetail['data']['images'][0]['url'];
                            }
                        }
                    }
                }
            }
        }
        
        return $response;
    }
    /**
     * 获取标签列表
     * 
     * @param int $limit 限制数量，默认20
     * @return array 标签列表数据
     */
    public function getTagList($limit = 20) {
        $domainConfig = SITE_DOMAIN;
        $response = $this->get('/api/tag/list', ['limit' => $limit, 'domainConfig' => $domainConfig]);
        
        // 处理标签数据，确保格式一致
        if (isset($response['code']) && $response['code'] == 200 && 
            isset($response['data']) && is_array($response['data'])) {
            
            $processedTags = [];
            
            foreach ($response['data'] as $tag) {
                // 如果标签是字符串，转换为标准格式
                if (is_string($tag)) {
                    $processedTags[] = [
                        'name' => $tag,
                        'frequency' => 1 // 默认频率
                    ];
                } 
                // 如果标签是数组且有name字段
                else if (is_array($tag) && isset($tag['name'])) {
                    // 确保有frequency字段
                    if (!isset($tag['frequency'])) {
                        $tag['frequency'] = 1;
                    }
                    $processedTags[] = $tag;
                }
            }
            
            $response['data'] = $processedTags;
        }
        
        return $response;
    }
    
    /**
     * 获取所有标签（分页）
     * 
     * @param int $page 页码，默认0
     * @param int $size 每页大小，默认10
     * @return array 所有标签数据
     */
    public function getAllTags($page = 0, $size = DEFAULT_PAGE_SIZE) {
        $domainConfig = SITE_DOMAIN;
        $params = [
            'page' => $page,
            'size' => $size,
            'domainConfig' => $domainConfig
        ];
        
        return $this->get('/api/tags', $params);
    }
    
    /**
     * 获取分类列表
     * 
     * @return array 分类列表数据
     */
    public function getCategoryList() {
        $domainConfig = SITE_DOMAIN;
        $params = [
            'domainConfig' => $domainConfig
        ];
        error_log("开始获取分类列表");
        $response = $this->get('/api/category/list', $params);
        
        // 处理分类数据，提取category字段和newsCount字段
        if (isset($response['code']) && $response['code'] == 200 && 
            isset($response['data']) && is_array($response['data'])) {
            
            error_log("原始分类数据: " . json_encode(array_slice($response['data'], 0, 3), JSON_UNESCAPED_UNICODE) . "...");
            
            $processedData = [];
            foreach ($response['data'] as $item) {
                if (isset($item['category'])) {
                    $categoryData = [];
                    
                    // 如果category是一个对象，提取name字段
                    if (is_array($item['category']) && isset($item['category']['name'])) {
                        $categoryData['name'] = $item['category']['name'];
                        error_log("处理分类对象: " . $item['category']['name']);
                    } else {
                        $categoryData['name'] = $item['category'];
                        error_log("处理分类字符串: " . $item['category']);
                    }
                    
                    // 添加新闻数量
                    $categoryData['newsCount'] = isset($item['newsCount']) ? $item['newsCount'] : 0;
                    
                    $processedData[] = $categoryData;
                }
            }
            
            error_log("处理后的分类数据: " . json_encode(array_slice($processedData, 0, 3), JSON_UNESCAPED_UNICODE) . "...");
            $response['data'] = $processedData;
        } else {
            error_log("获取分类列表失败或数据格式不正确: " . json_encode($response, JSON_UNESCAPED_UNICODE));
        }
        
        return $response;
    }
    
    /**
     * 获取所有分类
     * 
     * @return array 所有分类数据
     */
    public function getAllCategories() {
        return $this->get('/api/categories');
    }
    
    /**
     * 从缓存获取数据
     * 
     * @param string $key 缓存键
     * @return mixed 缓存数据或false
     */
    private function getCache($key) {
        if (!ENABLE_CACHE) {
            return false;
        }
        
        $cacheFile = __DIR__ . '/../cache/' . $key . '.cache';
        
        if (!file_exists($cacheFile)) {
            return false;
        }
        
        $cacheData = file_get_contents($cacheFile);
        $cache = unserialize($cacheData);
        
        // 检查缓存是否过期
        if (time() - $cache['time'] > CACHE_EXPIRATION) {
            unlink($cacheFile);
            return false;
        }
        
        return $cache['data'];
    }
    
    /**
     * 将数据存入缓存
     * 
     * @param string $key 缓存键
     * @param mixed $data 要缓存的数据
     * @return bool 是否成功
     */
    private function setCache($key, $data) {
        if (!ENABLE_CACHE) {
            return false;
        }
        
        $cacheDir = __DIR__ . '/../cache';
        
        // 确保缓存目录存在
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
        
        $cacheFile = $cacheDir . '/' . $key . '.cache';
        $cacheData = serialize([
            'time' => time(),
            'data' => $data
        ]);
        
        return file_put_contents($cacheFile, $cacheData) !== false;
    }
    public function getConfigByDomain($domain) {
        return $this->get("/api/config/domain/{$domain}");
    }
    
    /**
     * 获取域名配置信息
     * 
     * @param string $domain 域名
     * @return array 域名配置信息
     */
    public function getDomainConfig($domain = 'default') {
        error_log("开始获取域名配置: " . $domain);
        
        // 构建请求参数
        $endpoint = '/api/config/domain/' . urlencode($domain);
        
        // 发送请求
        $response = $this->get($endpoint);
        
        // 检查响应
        if (isset($response['code']) && $response['code'] == 200 && isset($response['data'])) {
            error_log("成功获取域名配置");
            error_log("域名配置为：" . json_encode($response['data'], JSON_UNESCAPED_UNICODE));

            // 记录视图路径
            if (isset($response['data']['views'])) {
                error_log("域名配置中的视图路径: " . $response['data']['views']);
            } else {
                error_log("域名配置中未设置视图路径");
            }
            
            return $response;
        } else {
            error_log("获取域名配置失败: " . (isset($response['message']) ? $response['message'] : '未知错误'));
            return [
                'code' => isset($response['code']) ? $response['code'] : 500,
                'message' => isset($response['message']) ? $response['message'] : '获取域名配置失败',
                'data' => null
            ];
        }
    }

    /**
     * 发送POST请求到API
     * 
     * @param string $endpoint API端点
     * @param array $data POST数据
     * @return array 响应数据
     */
    public function post($endpoint, $data = []) {
        $url = $this->baseUrl . $endpoint;
        
        // 打印请求信息到控制台
        error_log("API POST请求: " . $url);
        error_log("POST数据: " . json_encode($data, JSON_UNESCAPED_UNICODE));
        
        // 发送请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // 处理请求错误
        if ($response === false) {
            error_log("API POST请求失败: " . $error);
            return [
                'code' => 500,
                'message' => '请求API失败: ' . $error,
                'data' => null
            ];
        }
        
        // 处理HTTP错误
        if ($httpCode != 200) {
            error_log("API POST HTTP错误: " . $httpCode);
            return [
                'code' => $httpCode,
                'message' => 'API返回HTTP错误: ' . $httpCode,
                'data' => null
            ];
        }
        // 解析JSON响应
        $data = json_decode($response, true);
        if ($data === null) {
            error_log("API POST响应JSON解析失败");
            return [
                'code' => 500,
                'message' => 'API响应格式错误',
                'data' => null
            ];
        }
        
        return $data;
    }
    /**
     * 提交评论
     * 
     * @param array $commentData 评论数据
     * @return array 响应数据
     */
    public function submitComment($commentData) {
        return $this->post('/admin/comment/save', $commentData);
    }
    /**
     * 点赞评论
     * 
     * @param int $commentId 评论ID
     * @return array 响应数据
     */
    public function likeComment($commentId) {
        return $this->post("/admin/comment/like/{$commentId}", []);
    }
} 