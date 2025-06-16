<?php
require_once 'config.php';
require_once 'api/ApiClient.php';
require_once 'includes/Utils.php';

// 检查分类名称参数
if (!isset($_GET['name']) || empty($_GET['name'])) {
    header('Location: /');
    exit;
}

$categorySlug = $_GET['name'];

// 将英文slug转换为中文分类名
$categoryName = Utils::slugToCategory($categorySlug);

// 添加调试信息
error_log("分类处理: slug='$categorySlug', categoryName='$categoryName'");

// 初始化API客户端
$apiClient = new ApiClient();

// 初始化动态站点配置
$domainConfig = Utils::initDynamicConfig($apiClient, SITE_DOMAIN);

// 设置视图路径
if ($domainConfig && isset($domainConfig['views'])) {
    define('VIEWS_PATH', $domainConfig['views']);
} else {
    define('VIEWS_PATH', 'templates/views3');
}

// 获取分类列表
$categoryResponse = $apiClient->getCategoryList();
$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 如果API没有返回分类数据，使用默认分类
if (empty($categories)) {
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
    error_log("使用默认分类列表，包含西甲");
}

// 查找当前分类
$currentCategory = null;
foreach ($categories as $category) {
    $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
    error_log("检查分类: '$catName' vs '$categoryName'");
    if ($catName == $categoryName) {
        $currentCategory = $category;
        error_log("找到匹配分类: " . print_r($currentCategory, true));
        break;
    }
}

// 如果找不到分类，尝试不区分大小写匹配
if ($currentCategory === null) {
    error_log("未找到完全匹配的分类，尝试不区分大小写匹配");
    foreach ($categories as $category) {
        $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
        if (strtolower($catName) == strtolower($categoryName)) {
            $currentCategory = $category;
            error_log("找到不区分大小写匹配分类: " . print_r($currentCategory, true));
            break;
        }
    }
}

// 如果还是找不到分类，我们依然继续，因为API可能会返回该分类的新闻
if ($currentCategory === null) {
    error_log("警告：找不到分类 '$categoryName'，但继续尝试获取新闻");
    // 创建一个临时分类对象
    $currentCategory = ['name' => $categoryName];
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

error_log("获取分类新闻: categoryName='$categoryName', pageNum=$pageNum, pageSize=$pageSize");
$newsListResponse = $apiClient->getNewsList($pageNum, $pageSize, $categoryName);
error_log("分类新闻API响应: " . json_encode($newsListResponse, JSON_UNESCAPED_UNICODE));

$newsList = isset($newsListResponse['data']['list']) ? $newsListResponse['data']['list'] : [];
$totalPages = isset($newsListResponse['data']['pages']) ? $newsListResponse['data']['pages'] : 0;
$totalItems = isset($newsListResponse['data']['total']) ? $newsListResponse['data']['total'] : 0;

// 生成分页HTML（使用英文slug）
$urlPattern = '?name=' . urlencode($categorySlug) . '&page={page}';
$pagination = Utils::generatePagination($pageNum, $totalPages, $urlPattern);

// 设置页面标题和描述
$pageTitle = $categoryName . '新闻';
$pageDescription = $categoryName . '分类下的最新新闻和资讯';
$pageKeywords = $categoryName . ',新闻,资讯';

// 设置面包屑导航（使用英文slug）
$breadcrumbs = [
    ['text' => '首页', 'url' => '/'],
    ['text' => $categoryName, 'url' => '/category.php?name=' . urlencode($categorySlug)]
];

// 设置视图路径 - 直接使用对应的分类模板
$viewPath = VIEWS_PATH . '/category/index.php';

// 检查视图文件是否存在
if (!file_exists($viewPath)) {
    error_log("错误：视图文件不存在: $viewPath");
    echo "错误：视图文件不存在: $viewPath";
    exit;
}

// 包含主布局模板
include VIEWS_PATH . '/layouts/main.php';
?> 
?> 