<?php
require_once 'config.php';

// 设置HTTP状态码
http_response_code(404);

// 设置页面标题和描述
$pageTitle = '页面未找到';
$pageDescription = '您访问的页面不存在或已被移除';
$pageKeywords = '404,页面未找到,错误';

// 设置视图路径
$viewPath = 'views/errors/404.php';

// 包含主布局模板
include 'views/layouts/main.php';
?> 