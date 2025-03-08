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

// 检查标签名称参数
if (!isset($_GET['name']) || empty($_GET['name'])) {
    header('Location: /');
    exit;
}

$tagName = $_GET['name'];

// 获取分类列表
$categoryResponse = $apiClient->getCategoryList();
$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 获取标签列表
$tagResponse = $apiClient->getTagList();
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 查找当前标签
$currentTag = null;
foreach ($tags as $tag) {
    if (isset($tag['name']) && $tag['name'] == $tagName) {
        $currentTag = $tag;
        break;
    }
}

// 如果找不到标签，重定向到首页
if ($currentTag === null) {
    header('Location: /');
    exit;
}

// 获取热门新闻
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取标签相关的新闻列表
// 注意：这里假设API支持按标签搜索，实际可能需要调整
$pageNum = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageSize = DEFAULT_PAGE_SIZE;

// 使用搜索API来获取标签相关的新闻
$searchResponse = $apiClient->searchNews($tagName, $pageNum, $pageSize);
$newsList = isset($searchResponse['data']['list']) ? $searchResponse['data']['list'] : [];
$totalPages = isset($searchResponse['data']['pages']) ? $searchResponse['data']['pages'] : 0;
$totalItems = isset($searchResponse['data']['total']) ? $searchResponse['data']['total'] : 0;

// 生成分页HTML
$urlPattern = '?name=' . urlencode($tagName) . '&page={page}';
$pagination = Utils::generatePagination($pageNum, $totalPages, $urlPattern);

// 设置页面标题和描述
$pageTitle = '标签：' . $tagName;
$pageDescription = '与"' . $tagName . '"标签相关的新闻和资讯';
$pageKeywords = $tagName . ',标签,新闻,资讯';

// 设置面包屑导航
$breadcrumbs = [
    ['text' => '首页', 'url' => '/'],
    ['text' => '标签', 'url' => '/tags.php'],
    ['text' => $tagName, 'url' => '/tag.php?name=' . urlencode($tagName)]
];

// 设置视图路径
$viewPath = VIEWS_PATH . '/tag/index.php';

// 包含主布局模板
include VIEWS_PATH . '/layouts/main.php';
?> 