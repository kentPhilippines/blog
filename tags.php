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
if ($domainConfig && isset($domainConfig['views'])) {
    define('VIEWS_PATH', $domainConfig['views']);
} else {
    define('VIEWS_PATH', 'views');
}

// 获取分类列表
$categoryResponse = $apiClient->getCategoryList();
$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 获取热门新闻
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取所有标签
$tagResponse = $apiClient->getTagList(100); // 获取更多标签
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 按频率排序
usort($tags, function($a, $b) {
    return $b['frequency'] - $a['frequency'];
});

// 设置页面标题和描述
$pageTitle = '所有标签';
$pageDescription = '浏览所有新闻标签';
$pageKeywords = '标签,新闻,资讯,分类';

// 设置面包屑导航
$breadcrumbs = [
    ['text' => '首页', 'url' => '/'],
    ['text' => '标签', 'url' => '/tags.php']
];

// 设置视图路径
$viewPath = VIEWS_PATH . '/tags/index.php';

// 包含主布局模板
include VIEWS_PATH . '/layouts/main.php';
?> 