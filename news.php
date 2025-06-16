<?php
require_once 'config.php';
require_once 'api/ApiClient.php';
require_once 'includes/Utils.php';

// 初始化API客户端
$apiClient = new ApiClient();

// 初始化动态站点配置
$domainConfig = Utils::initDynamicConfig($apiClient, SITE_DOMAIN);

// 设置视图路径
$viewsPath = Utils::getViewsPath($apiClient, SITE_DOMAIN);
error_log("当前使用的视图路径: " . $viewsPath);

// 获取分类列表（用于导航）
$categoryResponse = $apiClient->getCategoryList();
$categories = isset($categoryResponse['data']) ? $categoryResponse['data'] : [];

// 获取标签列表（用于页脚）
$tagResponse = $apiClient->getTagList();
$tags = isset($tagResponse['data']) ? $tagResponse['data'] : [];

// 检查请求类型
if (isset($_GET['type']) && $_GET['type'] == 'hot') {
    // 显示所有分类新闻
    
    // 获取当前页码
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    if ($page < 1) $page = 1;
    
    // 每页显示数量
    $pageSize = 10;
    
    // 使用已获取的分类列表，不再查询热门新闻
    // $hotNewsResponse = $apiClient->getHotNews(50); // 注释掉热门新闻查询
    $newsList = $categories; // 直接使用分类列表
    
    // 对分类数据进行处理，使其适合模板展示
    $processedList = [];
    foreach ($newsList as $category) {
        if (isset($category['name'])) {
            // 构造与news_items结构相似的数组
            $processedList[] = [
                'id' => isset($category['id']) ? $category['id'] : 0,
                'title' => $category['name'],
                'categoryName' => '分类',
                'summary' => isset($category['newsCount']) ? "包含 {$category['newsCount']} 篇文章" : '',
                'coverImage' => null,
                'viewCount' => isset($category['newsCount']) ? $category['newsCount'] : 0,
                'publishTime' => date('Y-m-d'),
                'url' => "/category.php?name=" . urlencode($category['name'])
            ];
        }
    }
    $newsList = $processedList;
    
    // 计算总页数
    $totalItems = count($newsList);
    $totalPages = ceil($totalItems / $pageSize);
    
    // 截取当前页的数据
    $offset = ($page - 1) * $pageSize;
    $currentPageItems = array_slice($newsList, $offset, $pageSize);
    
    // 设置页面标题和描述
    $pageTitle = '全部分类';
    $pageDescription = '浏览所有新闻分类';
    $pageKeywords = '新闻分类,资讯分类,全部分类';
    
    // 设置面包屑导航
    $breadcrumbs = [
        ['text' => '首页', 'url' => '/'],
        ['text' => '全部分类', 'url' => '/news.php?type=hot']
    ];
    
    // 设置视图路径
    $viewPath = $viewsPath . '/news/categories.php';
    
    // 如果视图文件不存在，创建一个简单的显示逻辑
    if (!file_exists($viewPath)) {
        // 使用新创建的分类展示页面模板
        $viewPath = $viewsPath . '/news/categories.php';
        
        // 构造与分类页面兼容的数据结构
        $category = [
            'name' => '全部分类',
            'description' => '浏览所有可用的新闻分类'
        ];
        
        $pagination = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'hasNextPage' => $page < $totalPages,
            'hasPrevPage' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1
        ];
        
        // 生成分页HTML
        $paginationHtml = '';
        if ($totalPages > 1) {
            $paginationHtml .= '<nav aria-label="分页导航"><ul class="pagination justify-content-center">';
            
            // 上一页按钮
            if ($pagination['hasPrevPage']) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="/news.php?type=hot&page=' . $pagination['prevPage'] . '" aria-label="上一页"><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                $paginationHtml .= '<li class="page-item disabled"><a class="page-link" href="#" aria-label="上一页"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            
            // 页码按钮
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                    $paginationHtml .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
                } else {
                    $paginationHtml .= '<li class="page-item"><a class="page-link" href="/news.php?type=hot&page=' . $i . '">' . $i . '</a></li>';
                }
            }
            
            // 下一页按钮
            if ($pagination['hasNextPage']) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="/news.php?type=hot&page=' . $pagination['nextPage'] . '" aria-label="下一页"><span aria-hidden="true">&raquo;</span></a></li>';
            } else {
                $paginationHtml .= '<li class="page-item disabled"><a class="page-link" href="#" aria-label="下一页"><span aria-hidden="true">&raquo;</span></a></li>';
            }
            
            $paginationHtml .= '</ul></nav>';
        }
        
        // 将当前页的分类数据赋值给news_items变量，供模板使用
        $news_items = $currentPageItems;
        // 仅当news_items为空时，再设置一个备用的paginationHtml变量
        if (empty($news_items)) {
            $pagination = $paginationHtml;
        }
        $categoryName = '全部分类'; // 添加分类名称，确保与模板兼容
    } else {
        // 如果视图文件存在，直接使用数组形式的分页数据
        $pagination = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'hasNextPage' => $page < $totalPages,
            'hasPrevPage' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1
        ];
        
        // 将当前页的分类数据赋值给news_items变量，供模板使用
        $news_items = $currentPageItems;
        $categoryName = '全部分类';
    }
    
    // 包含主布局模板 templates/views1/layouts/main.php
    include $viewsPath . '/layouts/main.php';
    exit;
} else {
    // 设置默认视图路径，用于详情页
    $viewPath = $viewsPath . '/news/detail.php';
}

// 以下是显示单个新闻详情的逻辑（原有代码）
// 检查新闻ID参数
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /');
    exit;
}

$newsId = intval($_GET['id']);

// 获取新闻详情
$newsDetailResponse = $apiClient->getNewsDetail($newsId);

// 检查是否成功获取新闻
if (!isset($newsDetailResponse['code']) || $newsDetailResponse['code'] != 200 || !isset($newsDetailResponse['data'])) {
    header('HTTP/1.0 404 Not Found');
    
    // 设置404页面
    $pageTitle = '页面未找到';
    $pageDescription = '您访问的页面不存在或已被移除';
    $pageKeywords = '404,页面未找到,错误';
    
    $viewPath = $viewsPath . '/errors/404.php';
    include $viewsPath . '/layouts/main.php';
    exit;
}

$news = $newsDetailResponse['data'];

// 获取热门新闻（用于侧边栏）
$hotNewsResponse = $apiClient->getHotNews();
$hotNews = isset($hotNewsResponse['data']) ? $hotNewsResponse['data'] : [];

// 获取相关新闻
$relatedNews = [];
if (isset($news['categoryName'])) {
    $relatedNewsResponse = $apiClient->getNewsList(1, 4, $news['categoryName']);
    if (isset($relatedNewsResponse['code']) && $relatedNewsResponse['code'] == 200 && 
        isset($relatedNewsResponse['data']['list']) && is_array($relatedNewsResponse['data']['list'])) {
        
        // 过滤掉当前新闻
        foreach ($relatedNewsResponse['data']['list'] as $item) {
            if ($item['id'] != $news['id']) {
                $relatedNews[] = $item;
                if (count($relatedNews) >= 3) {
                    break;
                }
            }
        }
    }
}

// 设置页面标题和描述
$pageTitle = $news['title'];
$pageDescription = isset($news['summary']) ? $news['summary'] : '';
$pageKeywords = $pageTitle;

// 如果有标签，将其用作关键词
if (isset($news['tags']) && is_array($news['tags'])) {
    $tagNames = array_map(function($tag) {
        return $tag['name'];
    }, $news['tags']);
    $pageKeywords = implode(',', $tagNames);
}
$pageKeywords = $pageTitle;

// 设置规范URL
$canonicalUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/news.php?id=' . $newsId;

// 设置面包屑导航
$breadcrumbs = [
    ['text' => '首页', 'url' => '/']
];

if (isset($news['categoryName'])) {
    $breadcrumbs[] = ['text' => $news['categoryName'], 'url' => '/category.php?name=' . urlencode($news['categoryName'])];
}

$breadcrumbs[] = ['text' => $news['title'], 'url' => '/news.php?id=' . $newsId];

// 添加Open Graph元标签
$extraHead = '
<meta property="og:title" content="' . htmlspecialchars($news['title']) . '">
<meta property="og:description" content="' . htmlspecialchars(isset($news['summary']) ? $news['summary'] : '') . '">
<meta property="og:type" content="article">
<meta property="og:url" content="' . $canonicalUrl . '">
';

// 如果有封面图，添加og:image
if (!empty($news['images'])) {
    foreach ($news['images'] as $image) {
        if ($image['isCover']) {
            $extraHead .= '<meta property="og:image" content="' . $image['url'] . '">' . "\n";
            break;
        }
    }
}

// 包含主布局模板
include $viewsPath . '/layouts/main.php';
?> 