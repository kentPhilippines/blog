<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . (defined('DYNAMIC_SITE_NAME') ? DYNAMIC_SITE_NAME : SITE_NAME) : (defined('DYNAMIC_SITE_NAME') ? DYNAMIC_SITE_NAME : SITE_NAME); ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : (defined('DYNAMIC_SITE_DESCRIPTION') ? DYNAMIC_SITE_DESCRIPTION : SITE_DESCRIPTION); ?>">
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : (defined('DYNAMIC_SITE_KEYWORDS') ? DYNAMIC_SITE_KEYWORDS : SITE_KEYWORDS); ?>">
    <?php if (isset($domainConfig['faviconUrl'])): ?>
    <link rel="shortcut icon" href="<?php echo htmlspecialchars($domainConfig['faviconUrl']); ?>" type="image/x-icon">
    <?php endif; ?>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if (isset($canonicalUrl)): ?>
    <link rel="canonical" href="<?php echo $canonicalUrl; ?>">
    <?php endif; ?>
    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>
    <?php include 'views/partials/header.php'; ?>
    
    <main class="site-main">
        <div class="container mt-4">
            <?php if (isset($breadcrumbs)): ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php foreach ($breadcrumbs as $index => $crumb): ?>
                        <?php if ($index == count($breadcrumbs) - 1): ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $crumb['text']; ?></li>
                        <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?php echo $crumb['url']; ?>"><?php echo $crumb['text']; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
            <?php endif; ?>
            
            <?php include $viewPath; ?>
        </div>
    </main>
    
    <?php include 'views/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <?php if (isset($extraScripts)) echo $extraScripts; ?>
</body>
</html> 