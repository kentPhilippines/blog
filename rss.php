<?php
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/api_helpers.php';

// 设置内容类型为XML
header('Content-Type: application/rss+xml; charset=utf-8');

// 获取域名配置
$domain = get_domain_config();
$site_title = $domain['title'] ?? '新闻博客';
$site_description = $domain['description'] ?? '这是一个新闻博客网站';

// 获取分类参数
$category_name = isset($_GET['category']) ? urldecode($_GET['category']) : '';

// 构建RSS标题和描述
$rss_title = $site_title;
$rss_description = $site_description;

if (!empty($category_name)) {
    $rss_title .= " - {$category_name}分类";
    $rss_description = "{$category_name}分类的最新新闻";
}

// 获取最新新闻
$params = [
    'pageNum' => 1,
    'pageSize' => 20 // 获取最新的20条新闻
];

if (!empty($category_name)) {
    $params['categoryName'] = $category_name;
}

$api_result = call_api('news/list', $params);
$news_items = [];

if (isset($api_result['code']) && $api_result['code'] == 200 && !empty($api_result['data']['records'])) {
    $news_items = $api_result['data']['records'];
} elseif (isset($api_result['code']) && $api_result['code'] == 200 && !empty($api_result['data'])) {
    // 确保获取的数据是数组格式
    $news_items = is_array($api_result['data']) ? $api_result['data'] : [];
    
    // 过滤掉非数组项
    $news_items = array_filter($news_items, function($item) {
        return is_array($item);
    });
}

// 生成RSS XML
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0" 
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
    <channel>
        <title><?php echo htmlspecialchars($rss_title); ?></title>
        <atom:link href="<?php echo get_current_url(); ?>" rel="self" type="application/rss+xml" />
        <link><?php echo get_base_url(); ?></link>
        <description><?php echo htmlspecialchars($rss_description); ?></description>
        <lastBuildDate><?php echo date('r'); ?></lastBuildDate>
        <language>zh-CN</language>
        <sy:updatePeriod>hourly</sy:updatePeriod>
        <sy:updateFrequency>1</sy:updateFrequency>
        <generator>新闻博客 RSS Generator</generator>

        <?php foreach ($news_items as $item): ?>
        <?php if(is_array($item)): ?>
        <item>
            <title><?php echo htmlspecialchars($item['title'] ?? ''); ?></title>
            <link><?php echo get_base_url() . 'news.php?id=' . ($item['id'] ?? ''); ?></link>
            <guid isPermaLink="false"><?php echo 'news-' . ($item['id'] ?? ''); ?></guid>
            <pubDate><?php echo date('r', strtotime($item['publishTime'] ?? '')) ?: date('r'); ?></pubDate>
            <dc:creator><![CDATA[新闻博客]]></dc:creator>
            <category><![CDATA[<?php echo htmlspecialchars($item['categoryName'] ?? ''); ?>]]></category>
            
            <?php if (!empty($item['summary'])): ?>
            <description><![CDATA[<?php echo $item['summary']; ?>]]></description>
            <?php else: ?>
            <description><![CDATA[<?php echo htmlspecialchars($item['title'] ?? ''); ?>]]></description>
            <?php endif; ?>
            
            <?php
                // 获取新闻详情内容
                if (!empty($item['id'])) {
                    $detail_result = call_api('news/detail/' . $item['id'], []);
                    $content = '';
                    if (isset($detail_result['code']) && $detail_result['code'] == 200 && !empty($detail_result['data'])) {
                        $content = $detail_result['data']['content'] ?? '';
                    }
                    
                    if (!empty($content)) {
                        echo '<content:encoded><![CDATA[' . $content . ']]></content:encoded>';
                    }
                }
            ?>
        </item>
        <?php endif; ?>
        <?php endforeach; ?>
    </channel>
</rss>

<?php
// 这些函数已在includes/functions.php中定义
?> 