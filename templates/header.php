<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : SITE_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : SITE_KEYWORDS; ?>">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.0.0/css/all.min.css">
    <?php if (isset($canonicalUrl)): ?>
    <link rel="canonical" href="<?php echo $canonicalUrl; ?>">
    <?php endif; ?>
    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/"><?php echo SITE_NAME; ?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link <?php echo empty($_GET['category']) && basename($_SERVER['PHP_SELF']) == 'index.html' ? 'active' : ''; ?>" href="/">首页</a>
                            </li>
                            <?php if (isset($categories) && is_array($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo isset($_GET['category']) && $_GET['category'] == $category['name'] ? 'active' : ''; ?>" href="/category.html?name=<?php echo urlencode($category['name']); ?>"><?php echo $category['name']; ?></a>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <form class="d-flex" action="/search.html" method="GET">
                            <input class="form-control me-2" type="search" name="keyword" placeholder="搜索新闻..." aria-label="Search" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                            <button class="btn btn-outline-success" type="submit">搜索</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main class="site-main">
        <div class="container mt-4"><?php if (isset($breadcrumbs)): ?>
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