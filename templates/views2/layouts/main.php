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
    
    <!-- Open Graph 标签 -->
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
    <link rel="stylesheet" href="/assets/css/theme-dark.css">
    <link rel="stylesheet" href="/assets/css/custom-views2.css">
    
    <!-- 预加载字体 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Noto+Serif+SC:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 添加Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.3.67/css/materialdesignicons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6200ee;
            --primary-dark: #3700b3;
            --primary-light: #bb86fc;
            --secondary-color: #03dac6;
            --secondary-dark: #018786;
            --background-color: #121212;
            --surface-color: #1e1e1e;
            --error-color: #cf6679;
            --on-primary: #ffffff;
            --on-secondary: #000000;
            --on-background: #ffffff;
            --on-surface: #ffffff;
            --on-error: #000000;
            --text-primary: rgba(255, 255, 255, 0.87);
            --text-secondary: rgba(255, 255, 255, 0.60);
            --text-hint: rgba(255, 255, 255, 0.38);
        }
        
        body {
            font-family: 'Roboto', 'Noto Serif SC', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.7;
        }
        
        .card {
            background-color: var(--surface-color);
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--on-secondary);
        }
        
        .btn-secondary:hover {
            background-color: var(--secondary-dark);
            border-color: var(--secondary-dark);
        }
        
        a {
            color: var(--primary-light);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        a:hover {
            color: var(--secondary-color);
        }
        
        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-light);
        }
        
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-light);
        }
        
        /* 过渡动画 */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="dark-mode">
    <div class="site-wrapper">
        <!-- 页面头部 -->
        <?php include(__DIR__ . '/../partials/header.php'); ?>
        
        <!-- 页面主体内容 -->
        <main class="site-main py-5">
            <!-- 内容视图的位置 -->
            <?php 
            if (isset($viewPath) && file_exists($viewPath)) {
                include($viewPath);
            } else {
                // 404 错误页面
                if (file_exists(__DIR__ . '/../errors/404.php')) {
                    include(__DIR__ . '/../errors/404.php');
                } else {
                    echo '<div class="container"><div class="alert alert-danger">页面未找到</div></div>';
                }
            }
            ?>
        </main>
        
        <!-- 页面底部 -->
        <?php include(__DIR__ . '/../partials/footer.php'); ?>
    </div>
    
    <!-- 回到顶部按钮 -->
    <button id="back-to-top" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4" style="display: none; z-index: 1000; width: 45px; height: 45px;">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- JavaScript 文件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="/assets/js/carousel-fix.js"></script>
    
    <script>
        // 回到顶部功能
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        
        $('#back-to-top').click(function() {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
        
        // 页面加载动画
        $(document).ready(function() {
            $('.fade-in').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
            });
            
            // 初始化提示框
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // 添加平滑滚动
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top
                }, 500, 'linear');
            });
        });
        
        // 移动端导航效果
        $('.navbar-toggler').click(function() {
            $(this).toggleClass('active');
        });
    </script>
</body>
</html> 