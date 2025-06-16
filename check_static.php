<?php
// 简单的静态检查处理器
require_once 'config.php';
require_once 'includes/Utils.php';

// 已由router.php处理的请求不应该到达这里

// 获取请求路径
$path = $_GET['path'] ?? '';

// 处理不同类型的请求
switch (true) {
    case $path === 'index':
        include 'index.php';
        break;
        
    case preg_match('/^news\/(\d+)$/', $path, $matches):
        $_GET['id'] = $matches[1];
        include 'news.php';
        break;
        
    case preg_match('/^category\/(.+)$/', $path, $matches):
        $categorySlug = urldecode($matches[1]);
        // 检查是否是英文slug，如果是则保持，如果是中文则转换为slug
        $categoryName = Utils::slugToCategory($categorySlug);
        if ($categoryName !== $categorySlug) {
            // 是英文slug，保持原样
            $_GET['name'] = $categorySlug;
        } else {
            // 可能是中文名称，转换为slug
            $_GET['name'] = Utils::categoryToSlug($categorySlug);
        }
        include 'category.php';
        break;
        
    case in_array($path, ['about', 'contact', 'privacy', 'terms', 'tags']):
        include $path . '.php';
        break;
        
    default:
        // 对于api_proxy请求，直接包含文件
        if (strpos($_SERVER['REQUEST_URI'], 'api_proxy') !== false) {
            include 'api_proxy.php';
        } else {
            // 其他请求返回404
            http_response_code(404);
            include '404.php';
        }
        break;
}
?> 