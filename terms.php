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
    define('VIEWS_PATH', 'templates/views1');
}

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

 
$viewPath = VIEWS_PATH . '/terms/index.php';

include VIEWS_PATH . '/layouts/main.php';

?>
