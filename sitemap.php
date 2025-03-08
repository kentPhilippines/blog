<?php
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/api_helpers.php';

// 设置内容类型为XML
header('Content-Type: application/xml; charset=utf-8');

// 获取域名配置
$domain = get_domain_config();

// 获取分类列表
$categories = get_categories();

// 获取最新文章列表（用于添加到网站地图）
$latest_news = [];
$news_result = call_api('news/list', ['pageNum' => 1, 'pageSize' => 100]);
if (isset($news_result['code']) && $news_result['code'] == 200 && !empty($news_result['data']['records'])) {
    $latest_news = $news_result['data']['records'];
} elseif (isset($news_result['code']) && $news_result['code'] == 200 && !empty($news_result['data'])) {
    // 确保获取的数据是数组格式
    $latest_news = is_array($news_result['data']) ? $news_result['data'] : [];
    
    // 过滤掉非数组项
    $latest_news = array_filter($latest_news, function($item) {
        return is_array($item);
    });
}

// 定义网站地图中的URL
$urls = [];

// 添加首页
$urls[] = [
    'loc' => get_base_url(),
    'lastmod' => date('Y-m-d'),
    'changefreq' => 'daily',
    'priority' => '1.0'
];

// 添加分类页面
foreach ($categories as $category) {
    if (!empty($category['name'])) {
        $urls[] = [
            'loc' => get_base_url() . 'category.php?name=' . urlencode($category['name']),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];
    }
}

// 添加文章页面
foreach ($latest_news as $news) {
    if (is_array($news) && !empty($news['id'])) {
        $pub_date = !empty($news['publishTime']) ? date('Y-m-d', strtotime($news['publishTime'])) : date('Y-m-d');
        $urls[] = [
            'loc' => get_base_url() . 'news.php?id=' . $news['id'],
            'lastmod' => $pub_date,
            'changefreq' => 'weekly',
            'priority' => '0.6'
        ];
    }
}

// 添加RSS页面
$urls[] = [
    'loc' => get_base_url() . 'rss.php',
    'lastmod' => date('Y-m-d'),
    'changefreq' => 'hourly',
    'priority' => '0.5'
];

// 生成XML
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($urls as $url): ?>
    <url>
        <loc><?php echo htmlspecialchars($url['loc']); ?></loc>
        <lastmod><?php echo $url['lastmod']; ?></lastmod>
        <changefreq><?php echo $url['changefreq']; ?></changefreq>
        <priority><?php echo $url['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
</urlset>

<?php
// 这些函数已在includes/functions.php中定义
?> 