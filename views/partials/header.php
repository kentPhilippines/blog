<header class="site-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <?php if (isset($domainConfig['logoUrl'])): ?>
                        <img src="<?php echo htmlspecialchars($domainConfig['logoUrl']); ?>" alt="<?php echo defined('DYNAMIC_SITE_NAME') ? DYNAMIC_SITE_NAME : SITE_NAME; ?>" height="30" class="d-inline-block align-text-top me-2">
                    <?php endif; ?>
                    <?php echo defined('DYNAMIC_SITE_NAME') ? DYNAMIC_SITE_NAME : SITE_NAME; ?>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo empty($_GET['category']) && basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="/">首页</a>
                        </li>
                        <?php if (isset($categories) && is_array($categories)): ?>
                            <?php 
                            // 限制显示的分类数量，避免导航栏过长
                            $displayCategories = array_slice($categories, 0, 7); 
                            foreach ($displayCategories as $category): 
                                $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
                            ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isset($_GET['name']) && $_GET['name'] == $catName ? 'active' : ''; ?>" 
                                   href="/category.php?name=<?php echo urlencode($catName); ?>">
                                   <?php echo htmlspecialchars($catName); ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <form class="d-flex" action="/search.php" method="GET">
                        <input class="form-control me-2" type="search" name="keyword" placeholder="搜索新闻..." aria-label="Search" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        <button class="btn btn-outline-success" type="submit">搜索</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header> 