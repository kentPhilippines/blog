<?php
// API配置
//define('API_BASE_URL', 'http://localhost:8080'); // 实际API服务器地址
define('API_BASE_URL', 'http://103.112.99.20:8080'); // 实际API服务器地址
// 获取当前域名
$currentDomain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'default';

// 网站基本配置
define('SITE_NAME', '新闻博客');
define('SITE_DESCRIPTION', '提供最新、最热门的新闻资讯');
define('SITE_KEYWORDS', '新闻,博客,资讯,热点');
define('SITE_DOMAIN', $currentDomain); // 当前站点域名标识
define('DEFAULT_VIEWS_PATH', 'views'); // 默认视图路径

// 分页配置
define('DEFAULT_PAGE_SIZE', 10);

// 缓存配置
define('ENABLE_CACHE', false); // 开发环境禁用缓存
define('CACHE_EXPIRATION', 3600); // 缓存过期时间（秒）

// 时区设置
date_default_timezone_set('Asia/Shanghai');

// 开发环境显示错误
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 