<?php
/**
 * 网易新闻风格的主布局模板
 */
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? SITE_NAME); ?> - <?php echo htmlspecialchars(SITE_NAME); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? SITE_DESCRIPTION); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords ?? SITE_KEYWORDS); ?>">
    
    <!-- SEO优化 -->
    <link rel="canonical" href="<?php echo isset($canonicalUrl) ? htmlspecialchars($canonicalUrl) : 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle ?? SITE_NAME); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription ?? SITE_DESCRIPTION); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo isset($canonicalUrl) ? htmlspecialchars($canonicalUrl) : 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <?php if (isset($pageImage)): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($pageImage); ?>">
    <?php endif; ?>
    
    <!-- 移动端优化 -->
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/views3/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- 额外的头部内容 -->
    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>
    <!-- 头部区域 -->
    <?php include 'header.php'; ?>
    
    <!-- 主要内容区域 -->
    <main class="ne-main">
        <div class="ne-container">
            <!-- 页面主要内容 -->
            <?php include $viewPath; ?>
        </div>
    </main>
    
    <!-- 页脚区域 -->
    <?php include 'footer.php'; ?>
    
    <!-- 返回顶部按钮 -->
    <div class="ne-back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>
    
    <!-- JavaScript -->
    <script src="/assets/js/views3/main.js"></script>
</body>
</html> 