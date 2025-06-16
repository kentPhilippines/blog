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
        ['name' => '中国足球', 'newsCount' => 0, 'slug' => 'zhongguozuqiu'],
        ['name' => '西甲', 'newsCount' => 0, 'slug' => 'xijia'],
        ['name' => 'CBA', 'newsCount' => 0, 'slug' => 'cba'],
        ['name' => '英超', 'newsCount' => 0, 'slug' => 'yingchao'],
        ['name' => '羽毛球', 'newsCount' => 0, 'slug' => 'yumaoqiu'],
        ['name' => 'NBA', 'newsCount' => 0, 'slug' => 'nba'],
        ['name' => '国字号', 'newsCount' => 0, 'slug' => 'guozihao'],
        ['name' => '乒乓球', 'newsCount' => 0, 'slug' => 'pingpangqiu'],
        ['name' => '意甲', 'newsCount' => 0, 'slug' => 'yijia'],
        ['name' => '亚冠', 'newsCount' => 0, 'slug' => 'yaguan'],
        ['name' => '法甲', 'newsCount' => 0, 'slug' => 'fajia'],
        ['name' => '欧冠', 'newsCount' => 0, 'slug' => 'ouguan'],
        ['name' => '游泳', 'newsCount' => 0, 'slug' => 'youyong'],
        ['name' => '德甲', 'newsCount' => 0, 'slug' => 'dejia'],
        ['name' => '台球', 'newsCount' => 0, 'slug' => 'taiqiu'],
        ['name' => '赛车', 'newsCount' => 0, 'slug' => 'saiche'],
        ['name' => '田径', 'newsCount' => 0, 'slug' => 'tianjing'],
        ['name' => '排球', 'newsCount' => 0, 'slug' => 'paiqiu']
    ];
}


// 为每个分类添加拼音字段
foreach ($categories as &$category) {
    $name = $category['name'];
    switch ($name) {
        case '中国足球':
            $category['pinyin'] = 'zhongguozuqiu';
            break;
        case '西甲':
            $category['pinyin'] = 'xijia';
            break;
        case 'CBA':
            $category['pinyin'] = 'CBA';
            break;
        case '英超':
            $category['pinyin'] = 'yingchao';
            break;
        case '羽毛球':
            $category['pinyin'] = 'yumaoqiu';
            break;
        case 'NBA':
            $category['pinyin'] = 'NBA';
            break;
        case '国字号':
            $category['pinyin'] = 'guozihao';
            break;
        case '乒乓球':
            $category['pinyin'] = 'pingpangqiu';
            break;
        case '意甲':
            $category['pinyin'] = 'yijia';
            break;
        case '亚冠':
            $category['pinyin'] = 'yaguan';
            break;
        case '法甲':
            $category['pinyin'] = 'fajia';
            break;
        case '欧冠':
            $category['pinyin'] = 'ouguan';
            break;
        case '游泳':
            $category['pinyin'] = 'youyong';
            break;
        case '德甲':
            $category['pinyin'] = 'dejia';
            break;
        case '台球':
            $category['pinyin'] = 'taiqiu';
            break;
        case '赛车':
            $category['pinyin'] = 'saiche';
            break;
        case '田径':
            $category['pinyin'] = 'tianjing';
            break;
        case '排球':
            $category['pinyin'] = 'paiqiu';
            break;
    }
}





// 获取标签列表
$tagResponse = $apiClient->getTagList();
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 获取热门新闻
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取NBA新闻
$nbaNewsResponse = $apiClient->getNewsList(1, 4, 'NBA');
$nbaNews = isset($nbaNewsResponse['data']['list']) ? $nbaNewsResponse['data']['list'] : [];
error_log("NBA新闻数据: " . json_encode($nbaNews, JSON_UNESCAPED_UNICODE));

// 获取CBA新闻
$cbaNewsResponse = $apiClient->getNewsList(1, 4, 'CBA');
$cbaNews = isset($cbaNewsResponse['data']['list']) ? $cbaNewsResponse['data']['list'] : [];
error_log("CBA新闻数据: " . json_encode($cbaNews, JSON_UNESCAPED_UNICODE));

// 为模板创建数据副本（避免array_shift修改原数组）
$nbaNewsForTemplate = $nbaNews;
$cbaNewsForTemplate = $cbaNews;

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