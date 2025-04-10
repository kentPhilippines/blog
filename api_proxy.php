<?php
require_once 'config.php';
require_once 'api/ApiClient.php';

// 设置响应头为JSON
header('Content-Type: application/json');

// 启用错误报告
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 记录请求信息
error_log('API代理请求: ' . $_SERVER['REQUEST_URI']);

// 获取POST数据
$postData = file_get_contents('php://input');
$requestData = json_decode($postData, true);

error_log('请求参数: ' . json_encode(['GET' => $_GET, 'POST' => $requestData], JSON_UNESCAPED_UNICODE));

try {
    // 初始化API客户端
    $apiClient = new ApiClient();
    
    // 如果是POST请求且有path参数，说明是通过代理转发的API请求
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($requestData['path'])) {
        $path = $requestData['path'];
        $method = $requestData['method'] ?? 'POST';
        $data = $requestData['data'] ?? null;
        
        // 构建完整的API URL
        $apiUrl = API_BASE_URL . $path;
        
        // 发起API请求
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($response === false) {
            throw new Exception('请求失败: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        // 设置响应状态码
        http_response_code($httpCode);
        
        // 输出API响应
        echo $response;
        exit;
    }
    
    // 获取请求的操作类型
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    // 根据操作类型执行相应的API调用
    switch ($action) {
        case 'getNewsList':
            // 获取参数
            $pageNum = isset($_GET['pageNum']) ? intval($_GET['pageNum']) : 1;
            $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 5; // 默认获取5条
            $categoryName = isset($_GET['categoryName']) ? $_GET['categoryName'] : null;
            
            error_log("调用getNewsList: pageNum={$pageNum}, pageSize={$pageSize}, categoryName=" . ($categoryName ?: '全部'));
            
            // 调用API获取新闻列表
            $response = $apiClient->getNewsList($pageNum, $pageSize, $categoryName);
            echo json_encode($response);
            break;
            
        case 'getCategoryList':
            error_log("调用getCategoryList");
            
            // 调用API获取分类列表
            $response = $apiClient->getCategoryList();
            echo json_encode($response);
            break;
            
        case 'getNewsDetail':
            // 获取新闻ID
            $newsId = isset($_GET['id']) ? intval($_GET['id']) : 0;
            
            error_log("调用getNewsDetail: id={$newsId}");
            
            if ($newsId > 0) {
                // 调用API获取新闻详情
                $response = $apiClient->getNewsDetail($newsId);
                echo json_encode($response);
            } else {
                // 返回错误信息
                $response = [
                    'code' => 400,
                    'message' => '缺少有效的新闻ID',
                    'data' => null
                ];
                echo json_encode($response);
                error_log("错误: 缺少有效的新闻ID");
            }
            break;
            
        case 'getDomainConfig':
            // 获取域名参数
            $domain = isset($_GET['domain']) ? $_GET['domain'] : 'default';
            
            error_log("调用getDomainConfig: domain={$domain}");
            
            // 调用API获取域名配置
            $response = $apiClient->getDomainConfig($domain);
            echo json_encode($response);
            break;
            
        case 'getHotNews':
            // 获取参数
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
            
            error_log("调用getHotNews: limit={$limit}");
            
            // 调用API获取热门新闻
            $response = $apiClient->getHotNews($limit);
            echo json_encode($response);
            break;
            
        case 'searchNews':
            // 获取参数
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $pageNum = isset($_GET['pageNum']) ? intval($_GET['pageNum']) : 1;
            $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
            
            error_log("调用searchNews: keyword={$keyword}, pageNum={$pageNum}, pageSize={$pageSize}");
            
            if (!empty($keyword)) {
                // 调用API搜索新闻
                $response = $apiClient->searchNews($keyword, $pageNum, $pageSize);
                echo json_encode($response);
            } else {
                // 返回错误信息
                $response = [
                    'code' => 400,
                    'message' => '缺少搜索关键词',
                    'data' => null
                ];
                echo json_encode($response);
                error_log("错误: 缺少搜索关键词");
            }
            break;
            
        case 'getTagList':
            // 获取参数
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            error_log("调用getTagList: limit={$limit}");
            
            // 调用API获取标签列表
            $response = $apiClient->getTagList($limit);
            echo json_encode($response);
            break;
            
        case 'comment':
            // 处理评论提交
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('评论提交必须使用POST方法');
            }
            
            $commentData = json_decode(file_get_contents('php://input'), true);
            if (!$commentData) {
                throw new Exception('无效的评论数据');
            }
            
            error_log("调用submitComment: " . json_encode($commentData, JSON_UNESCAPED_UNICODE));
            
            // 调用API提交评论
            $response = $apiClient->submitComment($commentData);
            echo json_encode($response);
            break;
            
        case 'like':
            // 处理评论点赞
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('点赞操作必须使用POST方法');
            }
            
            $commentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
            if (!$commentId) {
                throw new Exception('缺少评论ID');
            }
            
            error_log("调用likeComment: commentId={$commentId}");
            
            // 调用API进行点赞
            $response = $apiClient->likeComment($commentId);
            echo json_encode($response);
            break;
            
        case 'comments':
            // 获取评论列表参数
            $newsId = isset($_GET['newsId']) ? intval($_GET['newsId']) : 0;
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
            
            error_log("调用getCommentList: newsId={$newsId}, page={$page}, pageSize={$pageSize}");
            
            if ($newsId > 0) {
                // 调用API获取评论列表
                $apiUrl = API_BASE_URL . "/api/news/{$newsId}/comments?pageNum={$page}&pageSize={$pageSize}";
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                curl_close($ch);
                
                if ($response !== false) {
                    http_response_code($httpCode);
                    echo $response;
                } else {
                    http_response_code(500);
                    echo json_encode(['code' => 500, 'message' => '获取评论列表失败']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['code' => 400, 'message' => '缺少新闻ID']);
            }
            break;
            
        default:
            // 未知操作，返回错误信息
            $response = [
                'code' => 400,
                'message' => '未知的操作类型: ' . $action,
                'data' => null
            ];
            echo json_encode($response);
            error_log("错误: 未知的操作类型: " . $action);
            break;
    }
    
    // 记录响应信息
    if (isset($response)) {
        $responseCode = isset($response['code']) ? $response['code'] : 'unknown';
        error_log("API代理响应: code={$responseCode}");
    }
    
} catch (Exception $e) {
    // 处理异常
    $response = [
        'code' => 500,
        'message' => '服务器错误: ' . $e->getMessage(),
        'data' => null
    ];
    echo json_encode($response);
    error_log("API代理异常: " . $e->getMessage());
}
?> 