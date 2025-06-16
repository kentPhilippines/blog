<?php
/**
 * PHP内置服务器路由器
 * 用于处理URL重写，替代.htaccess文件
 */

$uri = $_SERVER['REQUEST_URI'];
$query = $_SERVER['QUERY_STRING'] ?? '';

// 解析URL
$parsedUrl = parse_url($uri);
$path = $parsedUrl['path'] ?? '/';

// 记录路由日志
error_log("Router: Processing request - URI: $uri, Path: $path, Query: $query");

// 处理静态资源文件（直接返回false让PHP服务器处理）
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|pdf|woff|woff2|ttf|otf)$/', $path)) {
    return false; // 让PHP内置服务器处理静态文件
}

// 特殊处理：category.html 请求
if ($path === '/category.html' && isset($_GET['name'])) {
    error_log("Router: Handling category.html request with name=" . $_GET['name']);
    include 'category.php';
    return true;
}

// 直接访问category.php时的特殊处理
if ($path === '/category.php' && isset($_GET['name'])) {
    error_log("Router: Handling category.php request with name=" . $_GET['name']);
    include 'category.php';
    return true;
}

// 直接访问news.php时的特殊处理
if ($path === '/news.php' && isset($_GET['id'])) {
    error_log("Router: Handling news.php request with id=" . $_GET['id']);
    include 'news.php';
    return true;
}

// 直接访问tag.php时的特殊处理
if ($path === '/tag.php' && isset($_GET['name'])) {
    error_log("Router: Handling tag.php request with name=" . $_GET['name']);
    include 'tag.php';
    return true;
}

// 直接访问的PHP文件
$phpFiles = [
    '/index.php', 
    '/news.php',
    '/api_proxy.php',
    '/test_rewrite.php',
    '/simple_test.php'
];

if (in_array($path, $phpFiles)) {
    $filename = ltrim($path, '/');
    if (file_exists($filename)) {
        include $filename;
        return true;
    }
}

// 处理首页
if ($path === '/' || $path === '/index.html') {
    include 'index.php';
    return true;
}

// 新闻详情页: /news/123 或 /news/123.html
if (preg_match('/^\/news\/(\d+)(?:\.html)?$/', $path, $matches)) {
    $_GET['id'] = $matches[1];
    include 'news.php';
    return true;
}

// 分类页面: /category/分类名 或 /category/分类名.html
if (preg_match('/^\/category\/([^\/]+)(?:\.html)?$/', $path, $matches)) {
    $categorySlug = urldecode($matches[1]);
    // 检查是否是英文slug，如果是则保持，如果是中文则转换为slug
    require_once 'includes/Utils.php';
    $categoryName = Utils::slugToCategory($categorySlug);
    if ($categoryName !== $categorySlug) {
        // 是英文slug，保持原样
        $_GET['name'] = $categorySlug;
    } else {
        // 可能是中文名称，转换为slug
        $_GET['name'] = Utils::categoryToSlug($categorySlug);
    }
    include 'category.php';
    return true;
}

// 分类分页: /category/分类名/page-2.html
if (preg_match('/^\/category\/([^\/]+)\/page-(\d+)(?:\.html)?$/', $path, $matches)) {
    $categorySlug = urldecode($matches[1]);
    $_GET['page'] = $matches[2];
    require_once 'includes/Utils.php';
    $categoryName = Utils::slugToCategory($categorySlug);
    if ($categoryName !== $categorySlug) {
        $_GET['name'] = $categorySlug;
    } else {
        $_GET['name'] = Utils::categoryToSlug($categorySlug);
    }
    include 'category.php';
    return true;
}

// 其他页面: /about, /contact, /privacy, /terms, /tags
$otherPages = ['about', 'contact', 'privacy', 'terms', 'tags'];
$pathWithoutSlash = ltrim($path, '/');
$pathWithoutHtml = preg_replace('/\.html?$/', '', $pathWithoutSlash);

if (in_array($pathWithoutHtml, $otherPages)) {
    $filename = $pathWithoutHtml . '.php';
    if (file_exists($filename)) {
        include $filename;
        return true;
    }
}

// 如果都没有匹配，使用check_static.php处理
include 'check_static.php';
return true;
?> 