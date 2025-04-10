<?php
require_once 'config.php';
require_once 'api/ApiClient.php';
require_once 'includes/Utils.php';

// 初始化API客户端
$apiClient = new ApiClient();

// 获取域名配置
$domainConfigResponse = $apiClient->getDomainConfig(SITE_DOMAIN);
$domainConfig = isset($domainConfigResponse['data']) ? $domainConfigResponse['data'] : null;
error_log("检索页面 域名配置: " . json_encode($domainConfig));
// 设置视图路径
$viewsPath = Utils::getViewsPath($apiClient, SITE_DOMAIN);

// 获取分类列表（用于导航）
$categoryResponse = $apiClient->getCategoryList();
$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 获取标签列表（用于侧边栏）
$tagResponse = $apiClient->getTagList();
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 获取热门新闻（用于侧边栏）
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取热门搜索数据（用于侧边栏）
$hotSearches = [];
if (!empty($hotNews)) {
    // 将热门新闻转换为热门搜索数据
    foreach (array_slice($hotNews, 0, 10) as $index => $news) {
        $hotSearches[] = [
            'keyword' => $news['title'] ?? '',
            'count' => $news['viewCount'] ?? 0
        ];
    }
}

// 处理搜索
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$pageNum = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = DEFAULT_PAGE_SIZE;

$searchResults = [];
$totalPages = 0;
$totalItems = 0;

// 记录搜索开始时间
$searchStartTime = microtime(true);

if (!empty($keyword)) {
    $searchResponse = $apiClient->searchNews($keyword, $pageNum, $pageSize);
    
    if (isset($searchResponse['code']) && $searchResponse['code'] == 200) {
        $searchResults = isset($searchResponse['data']['list']) ? $searchResponse['data']['list'] : [];
        $totalPages = isset($searchResponse['data']['pages']) ? $searchResponse['data']['pages'] : 0;
        $totalItems = isset($searchResponse['data']['total']) ? $searchResponse['data']['total'] : 0;
    }
}

// 计算搜索耗时
$searchTime = microtime(true) - $searchStartTime;
$totalResults = $totalItems;

// 生成分页HTML
$urlPattern = '?keyword=' . urlencode($keyword) . '&page={page}';
$pagination = Utils::generatePagination($pageNum, $totalPages, $urlPattern);

// 设置页面标题和描述
$pageTitle = !empty($keyword) ? '搜索：' . $keyword : '搜索新闻';
$pageDescription = !empty($keyword) ? '关于"' . $keyword . '"的搜索结果' : '搜索新闻和资讯';
$pageKeywords = !empty($keyword) ? $keyword . ',搜索,新闻,资讯' : '搜索,新闻,资讯';

// 设置面包屑导航
$breadcrumbs = [
    ['text' => '首页', 'url' => '/'],
    ['text' => '搜索', 'url' => '/search.php']
];

if (!empty($keyword)) {
    $breadcrumbs[] = ['text' => $keyword, 'url' => '/search.php?keyword=' . urlencode($keyword)];
}

 
    $viewPath = VIEWS_PATH . '/search/index.php';
//控制台日志
error_log("搜索关键词: " . $keyword);
error_log("当前页码: " . $pageNum);
error_log("每页显示数量: " . $pageSize);
error_log("搜索结果总数: " . $totalResults);
error_log("总页数: " . $totalPages);
error_log("搜索耗时: " . $searchTime . " 秒");
error_log("搜索页面加载完成，耗时: " . $searchTime . " 秒");
error_log("页面位置：" . $viewPath);

// 包含主布局模板
include VIEWS_PATH . '/layouts/main.php';
?> 