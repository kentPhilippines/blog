<?php
/**
 * 公共函数库
 */

// 获取域名配置
function get_domain_config() {
    global $domain_config;
    
    if (!isset($domain_config)) {
        $current_domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $domain_config_result = call_api('config/domain/' . urlencode($current_domain), []);
        
        if (isset($domain_config_result['code']) && $domain_config_result['code'] == 200) {
            $domain_config = $domain_config_result['data'];
        } else {
            $domain_config = [
                'title' => SITE_NAME,
                'description' => SITE_DESCRIPTION,
                'keywords' => SITE_KEYWORDS,
                'views' => DEFAULT_VIEWS_PATH
            ];
        }
    }
    
    return $domain_config;
}

// 获取当前URL
function get_current_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

// 获取基础URL
function get_base_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . '/';
}

// 获取分类列表
function get_categories() {
    $result = [];
    $categories_result = call_api('category/list', []);
    
    if (isset($categories_result['code']) && $categories_result['code'] == 200) {
        foreach ($categories_result['data'] as $category_data) {
            if (!empty($category_data['category']) && !empty($category_data['category']['name'])) {
                $result[] = [
                    'name' => $category_data['category']['name'],
                    'newsCount' => $category_data['newsCount'] ?? 0
                ];
            }
        }
    }
    
    return $result;
}

// 截取字符串（支持中文）
function utf8_substr($str, $start, $length = null) {
    return mb_substr($str, $start, $length, 'UTF-8');
}

// 格式化日期时间
function format_date($datetime, $format = 'Y-m-d H:i') {
    return date($format, strtotime($datetime));
}

// 获取视图路径
function get_view_path() {
    $domain_config = get_domain_config();
    return isset($domain_config['views']) && !empty($domain_config['views']) 
        ? $domain_config['views'] 
        : DEFAULT_VIEWS_PATH;
}

// 获取热门新闻
function get_hot_news($limit = 5) {
    $hot_news = [];
    $result = call_api('news/hot', ['limit' => $limit]);
    
    if (isset($result['code']) && $result['code'] == 200 && !empty($result['data'])) {
        $hot_news = $result['data'];
    }
    
    return $hot_news;
}

// 获取热门标签
function get_hot_tags($limit = 20) {
    $tags = [];
    $result = call_api('tag/list', ['limit' => $limit]);
    
    if (isset($result['code']) && $result['code'] == 200 && !empty($result['data'])) {
        $tags = $result['data'];
    }
    
    return $tags;
} 