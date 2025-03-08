<?php
require_once 'config.php';
require_once 'api/ApiClient.php';
require_once 'includes/Utils.php';

// 检查分类名称参数
if (!isset($_GET['name']) || empty($_GET['name'])) {
    header('Location: /');
    exit;
}

$categoryName = $_GET['name'];

 
// 初始化API客户端
$apiClient = new ApiClient();

// 获取域名配置
$domainConfigResponse = $apiClient->getDomainConfig(SITE_DOMAIN);
$domainConfig = isset($domainConfigResponse['data']) ? $domainConfigResponse['data'] : null;

// 设置视图路径
if ($domainConfig && isset($domainConfig['views'])) {
    define('VIEWS_PATH', $domainConfig['views']);
} else {
    define('VIEWS_PATH', 'templates/views1');
}

// 获取分类列表
$categoryResponse = $apiClient->getCategoryList();
$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 查找当前分类
$currentCategory = null;
foreach ($categories as $category) {
    $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
    if ($catName == $categoryName) {
        $currentCategory = $category;
        break;
    }
}

// 如果找不到分类，重定向到首页
if ($currentCategory === null) {
    // 添加调试信息
    if ($debug) {
        echo '<div class="alert alert-danger">找不到分类: ' . htmlspecialchars($categoryName) . '</div>';
        echo '<pre>';
        print_r($categories);
        echo '</pre>';
        exit;
    }
    header('Location: /');
    exit;
}

// 设置全局变量，用于在其他地方标识当前分类
$GLOBALS['categoryName'] = $categoryName;

// 获取标签列表
$tagResponse = $apiClient->getTagList();
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 获取热门新闻
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取分类新闻列表
$pageNum = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = DEFAULT_PAGE_SIZE;

$newsListResponse = $apiClient->getNewsList($pageNum, $pageSize, $categoryName);
$newsList = isset($newsListResponse['data']['list']) ? $newsListResponse['data']['list'] : [];
$totalPages = isset($newsListResponse['data']['pages']) ? $newsListResponse['data']['pages'] : 0;
$totalItems = isset($newsListResponse['data']['total']) ? $newsListResponse['data']['total'] : 0;

// 生成分页HTML
$urlPattern = '?name=' . urlencode($categoryName) . '&page={page}';
$pagination = Utils::generatePagination($pageNum, $totalPages, $urlPattern);

// 设置页面标题和描述
$pageTitle = $categoryName . '新闻';
$pageDescription = $categoryName . '分类下的最新新闻和资讯';
$pageKeywords = $categoryName . ',新闻,资讯';

// 设置面包屑导航
$breadcrumbs = [
    ['text' => '首页', 'url' => '/'],
    ['text' => $categoryName, 'url' => '/category.php?name=' . urlencode($categoryName)]
];

// 设置视图路径 - 直接使用对应的分类模板
$viewPath = VIEWS_PATH . '/category/index.php';

// 包含主布局模板
include VIEWS_PATH . '/layouts/main.php';
?> 