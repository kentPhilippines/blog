<?php
require_once 'config.php';
require_once 'api/ApiClient.php';
require_once 'includes/Utils.php';

// 初始化API客户端
$apiClient = new ApiClient();

// 获取域名配置
$domainConfigResponse = $apiClient->getDomainConfig(SITE_DOMAIN);
$domainConfig = isset($domainConfigResponse['data']) ? $domainConfigResponse['data'] : null;

// 设置视图路径
$viewsPath = Utils::getViewsPath($apiClient, SITE_DOMAIN);
error_log("当前使用的视图路径: " . $viewsPath);

// 如果成功获取域名配置，覆盖默认配置
if ($domainConfig) {
    // 网站标题
    if (isset($domainConfig['title'])) {
        define('DYNAMIC_SITE_NAME', $domainConfig['title']);
    } else {
        define('DYNAMIC_SITE_NAME', SITE_NAME);
    }
    
    // 网站描述
    if (isset($domainConfig['description'])) {
        define('DYNAMIC_SITE_DESCRIPTION', $domainConfig['description']);
    } else {
        define('DYNAMIC_SITE_DESCRIPTION', SITE_DESCRIPTION);
    }
    
    // 网站关键词
    if (isset($domainConfig['keywords'])) {
        define('DYNAMIC_SITE_KEYWORDS', $domainConfig['keywords']);
    } else {
        define('DYNAMIC_SITE_KEYWORDS', SITE_KEYWORDS);
    }
} else {
    // 使用默认配置
    define('DYNAMIC_SITE_NAME', SITE_NAME);
    define('DYNAMIC_SITE_DESCRIPTION', SITE_DESCRIPTION);
    define('DYNAMIC_SITE_KEYWORDS', SITE_KEYWORDS);
}

//这里需要获取请求的域名然后 获取 数据库关于这个域名的配置
$domain = $_SERVER['SERVER_NAME'];
$config = $apiClient->getConfigByDomain($domain);

// 获取分类列表
$categoryResponse = $apiClient->getCategoryList();

// 添加调试代码，查看分类响应数据结构
if (isset($_GET['debug']) && $_GET['debug'] == 1) {
    echo '<pre>';
    echo "分类响应数据结构：\n";
    print_r($categoryResponse);
    echo "\n\n分类数据：\n";
    print_r($categories);
    echo "\n\n域名配置：\n";
    print_r($domainConfig);
    echo '</pre>';
}

$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 确保分类数据不为空
if (empty($categories)) {
    // 如果API没有返回分类数据，使用默认分类
    $categories = [
        ['name' => '头条', 'newsCount' => 0],
        ['name' => '国内', 'newsCount' => 0],
        ['name' => '国际', 'newsCount' => 0],
        ['name' => '军事', 'newsCount' => 0],
        ['name' => '财经', 'newsCount' => 0],
        ['name' => '科技', 'newsCount' => 0],
        ['name' => '体育', 'newsCount' => 0],
        ['name' => '娱乐', 'newsCount' => 0]
    ];
}

// 获取标签列表
$tagResponse = $apiClient->getTagList();
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 获取热门新闻
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取新闻列表
$pageNum = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = DEFAULT_PAGE_SIZE;
$categoryName = isset($_GET['category']) ? $_GET['category'] : null;

$newsListResponse = $apiClient->getNewsList($pageNum, $pageSize, $categoryName);

// 添加调试代码，仅在开发环境使用
if (isset($_GET['debug']) && $_GET['debug'] == 1) {
    echo '<pre>';
    echo "分类响应数据结构：\n";
    print_r($categoryResponse);
    echo "\n\n新闻列表响应数据结构：\n";
    print_r($newsListResponse);
    echo '</pre>';
}

$newsList = isset($newsListResponse['data']['list']) ? $newsListResponse['data']['list'] : [];
$totalPages = isset($newsListResponse['data']['pages']) ? $newsListResponse['data']['pages'] : 0;
$totalItems = isset($newsListResponse['data']['total']) ? $newsListResponse['data']['total'] : 0;

// 生成分页HTML
$urlPattern = '?page={page}' . ($categoryName ? '&category=' . urlencode($categoryName) : '');
$pagination = Utils::generatePagination($pageNum, $totalPages, $urlPattern);

// 设置页面标题和描述
$pageTitle = '首页';
$pageDescription = defined('DYNAMIC_SITE_DESCRIPTION') ? DYNAMIC_SITE_DESCRIPTION : SITE_DESCRIPTION;
$pageKeywords = defined('DYNAMIC_SITE_KEYWORDS') ? DYNAMIC_SITE_KEYWORDS : SITE_KEYWORDS;

// 设置面包屑导航
$breadcrumbs = [
    ['text' => '首页', 'url' => '/']
];

if ($categoryName) {
    $breadcrumbs[] = ['text' => $categoryName, 'url' => '/category.php?name=' . urlencode($categoryName)];
}

// 设置视图路径
$viewPath = VIEWS_PATH . '/home/index.php';

// 包含主布局模板
include VIEWS_PATH . '/layouts/main.php';
?> 