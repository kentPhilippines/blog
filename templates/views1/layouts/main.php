<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo isset($domainConfig['title']) ? $domainConfig['title'] : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?></title>
    
    <!-- SEO 元标签 -->
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : (isset($domainConfig['description']) ? $domainConfig['description'] : (defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '最新的国内外新闻、时事、社会、军事、体育、财经、科技资讯，精选新闻大事记、最新热点新闻、热门话题、热点评论、深度解读。')); ?>">
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : (isset($domainConfig['keywords']) ? $domainConfig['keywords'] : (defined('SITE_KEYWORDS') ? SITE_KEYWORDS : '新闻,热点,资讯,国内,国际,军事,财经,娱乐,科技,体育')); ?>">
    <meta name="author" content="<?php echo isset($domainConfig['title']) ? $domainConfig['title'] : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph 标签（用于社交分享） -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo isset($domainConfig['title']) ? $domainConfig['title'] : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>">
    <meta property="og:description" content="<?php echo isset($pageDescription) ? $pageDescription : (isset($domainConfig['description']) ? $domainConfig['description'] : (defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '最新的国内外新闻、时事、社会、军事、体育、财经、科技资讯，精选新闻大事记、最新热点新闻、热门话题。')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="<?php echo isset($ogImage) ? $ogImage : '/assets/images/logo-social.jpg'; ?>">
    <meta property="og:site_name" content="<?php echo isset($domainConfig['title']) ? $domainConfig['title'] : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>">
    
    <!-- Twitter 卡片 -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo isset($domainConfig['title']) ? $domainConfig['title'] : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>">
    <meta name="twitter:description" content="<?php echo isset($pageDescription) ? $pageDescription : (isset($domainConfig['description']) ? $domainConfig['description'] : (defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '最新的国内外新闻、时事、社会、军事、体育、财经、科技资讯。')); ?>">
    <meta name="twitter:image" content="<?php echo isset($ogImage) ? $ogImage : '/assets/images/logo-social.jpg'; ?>">
    
    <!-- 网站图标 -->
    <link rel="shortcut icon" href="<?php echo isset($domainConfig['faviconUrl']) ? $domainConfig['faviconUrl'] : (isset($faviconUrl) ? $faviconUrl : '/favicon.ico'); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">
    
    <!-- 规范链接 -->
    <?php if (isset($canonicalUrl)): ?>
    <link rel="canonical" href="<?php echo $canonicalUrl; ?>">
    <?php else: ?>
    <link rel="canonical" href="https://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <?php endif; ?>
    
    <!-- CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/theme-light.css">
    <link rel="stylesheet" href="/assets/css/custom-views1.css">
    
    <!-- 预加载字体 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- 页面特定的头部元素 -->
    <?php if (isset($extraHead)) echo $extraHead; ?>
    
    <style>
        /* 核心样式内联，以提高性能 */
        :root {
            --primary-color: #2766d8;
            --secondary-color: #6c757d;
            --accent-color: #ff6b6b;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
            --border-color: #dee2e6;
            --text-color: #212529;
            --text-muted: #6c757d;
            --card-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Noto Sans SC', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-content {
            flex: 1 0 auto;
            padding: 2rem 0;
        }
        
        .site-footer {
            flex-shrink: 0;
            background-color: var(--dark-bg);
            color: #fff;
            padding: 2rem 0;
            margin-top: 2rem;
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
        }
        
        /* 骨架屏动画 */
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 0.8; }
            100% { opacity: 0.6; }
        }
        
        .skeleton {
            background-color: #eee;
            background-image: linear-gradient(90deg, #eee 0px, #f5f5f5 40px, #eee 80px);
            background-size: 200% 100%;
            animation: pulse 1.5s ease-in-out infinite;
            border-radius: 4px;
            height: 1em;
            margin-bottom: 0.5em;
        }
    </style>
    
    <!-- 结构化数据 -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo isset($domainConfig['title']) ? $domainConfig['title'] : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>",
        "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/search.php?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    
    <!-- 内联关键 CSS 预加载程序代码 -->
    <script>
    /* 用于异步加载CSS的程序 */
    (function(w){"use strict";var loadCSS=function(href,before,media,attributes){var doc=w.document;var ss=doc.createElement("link");var ref;if(before){ref=before}else{var refs=(doc.body||doc.getElementsByTagName("head")[0]).childNodes;ref=refs[refs.length-1]}var sheets=doc.styleSheets;ss.rel="stylesheet";ss.href=href;ss.media="only x";function ready(cb){if(doc.body){return cb()}setTimeout(function(){ready(cb)})}ready(function(){ref.parentNode.insertBefore(ss,(before?ref:ref.nextSibling))});var onloadcssdefined=function(cb){var resolvedHref=ss.href;var i=sheets.length;while(i--){if(sheets[i].href===resolvedHref){return cb()}}setTimeout(function(){onloadcssdefined(cb)})};function loadCB(){if(ss.addEventListener){ss.removeEventListener("load",loadCB)}ss.media=media||"all"}if(ss.addEventListener){ss.addEventListener("load",loadCB)}ss.onloadcssdefined=onloadcssdefined;onloadcssdefined(loadCB);return ss};if(typeof exports!=="undefined"){exports.loadCSS=loadCSS}else{w.loadCSS=loadCSS}}(typeof global!=="undefined"?global:this))
    </script>
</head>
<body>
    <!-- 顶部导航栏 -->
    <?php include VIEWS_PATH . '/partials/header.php'; ?>
    
    <!-- 页面主体内容 -->
    <main class="main-content">
        <div class="container">
            <?php if (isset($breadcrumbs)): ?>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-custom">
                    <?php 
                    // 确保使用URL中的分类名称
                    $url_category = isset($_GET['name']) ? $_GET['name'] : '';
                    
                    foreach ($breadcrumbs as $index => $crumb): 
                        // 如果是最后一个面包屑项且有分类名称参数
                        if ($index == count($breadcrumbs) - 1 && !empty($url_category) && basename($_SERVER['PHP_SELF']) == 'category.php'):
                    ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($url_category); ?></li>
                    <?php else: ?>
                        <li class="breadcrumb-item"><a href="<?php echo $crumb['url']; ?>"><?php echo $crumb['text']; ?></a></li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
            <?php endif; ?>
            
            <!-- 加载主视图内容 -->
            <?php include $viewPath; ?>
        </div>
    </main>
    
    <!-- 页脚 -->
    <?php include VIEWS_PATH . '/partials/footer.php'; ?>
    
    <!-- 回到顶部按钮 -->
    <a href="#" id="back-to-top" class="back-to-top" style="display: none;" aria-label="回到顶部">
        <i class="fas fa-arrow-up"></i>
    </a>
    
    <!-- JavaScript 文件（延迟加载） -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="/assets/js/carousel-fix.js" defer></script>
    
    <!-- 核心功能的内联脚本 -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 回到顶部按钮逻辑
        var backToTop = document.getElementById('back-to-top');
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.style.display = 'block';
                } else {
                    backToTop.style.display = 'none';
                }
            });
            
            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        }
    });
    </script>
    
    <!-- 各页面特定的脚本 -->
    <?php if (isset($extraScripts)) echo $extraScripts; ?>
    
    <!-- 站点统计代码 -->
    <?php if (defined('ANALYTICS_CODE') && constant('ANALYTICS_CODE')): ?>
        <?php echo constant('ANALYTICS_CODE'); ?>
    <?php elseif (isset($domainConfig['analyticsCode'])): ?>
        <?php echo $domainConfig['analyticsCode']; ?>
    <?php endif; ?>
</body>
</html>