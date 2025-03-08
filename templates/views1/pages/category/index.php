<?php
// 这是一个旧的分类模板文件，已被移动到templates/views1/category/index.php
// 如果此文件被调用，确保重定向到正确的模板

// 强制使用URL参数的分类名称
$url_category_name = isset($_GET['name']) ? $_GET['name'] : '未知分类';

// 确保分类名称变量使用URL参数
$categoryName = $url_category_name;

// 记录错误日志
error_log('Warning: templates/views1/pages/category/index.php 被调用，应改用 templates/views1/category/index.php');

// 包含正确的模板文件
$correct_template = dirname(dirname(dirname(__FILE__))) . '/category/index.php';
if (file_exists($correct_template)) {
    include $correct_template;
    exit;
}
?> 