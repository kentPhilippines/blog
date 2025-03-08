<header class="site-header">
    <!-- 顶部信息栏 -->
    <div class="top-bar py-1 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 d-none d-lg-block">
                    <ul class="list-inline mb-0 small">
                        <li class="list-inline-item me-3">
                            <i class="fas fa-clock me-1"></i> <?php echo date('Y年m月d日 H:i'); ?>
                        </li>
                        <li class="list-inline-item">
                            <i class="fas fa-rss me-1"></i> 
                            <a href="/rss.php" class="text-white" target="_blank">RSS订阅</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end justify-content-center small">
                        <a href="javascript:void(0);" id="dark-mode-toggle" class="text-white me-3" aria-label="切换深色模式">
                            <i class="fas fa-moon"></i> <span class="d-none d-sm-inline">切换模式</span>
                        </a>
                        <div class="dropdown top-bar-dropdown">
                            <a class="dropdown-toggle text-white" href="#" role="button" id="fontSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-font"></i> <span class="d-none d-sm-inline">字体大小</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="fontSizeDropdown">
                                <li><a class="dropdown-item font-size-control" href="javascript:void(0);" data-size="small">小</a></li>
                                <li><a class="dropdown-item font-size-control" href="javascript:void(0);" data-size="medium">中</a></li>
                                <li><a class="dropdown-item font-size-control" href="javascript:void(0);" data-size="large">大</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 主导航栏 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <!-- 网站Logo -->
            <a class="navbar-brand" href="/" title="<?php echo defined('SITE_NAME') ? SITE_NAME : '信息资讯网'; ?>">
                <?php if (isset($siteLogo)): ?>
                    <img src="<?php echo htmlspecialchars($siteLogo); ?>" alt="<?php echo defined('SITE_NAME') ? SITE_NAME : '信息资讯网'; ?>" height="40" width="auto" class="img-fluid">
                <?php else: ?>
                    <span class="fw-bold fs-4"><i class="fas fa-newspaper text-primary me-2"></i><?php echo defined('SITE_NAME') ? SITE_NAME : '信息资讯网'; ?></span>
                <?php endif; ?>
            </a>
            
            <!-- 移动端菜单按钮 -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="切换导航">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- 导航菜单 -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo empty($_SERVER['QUERY_STRING']) ? 'active' : ''; ?>" aria-current="page" href="/">
                            <i class="fas fa-home me-1"></i>首页
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isset($_GET['type']) && $_GET['type'] === 'hot' ? 'active' : ''; ?>" href="/news.php?type=hot">
                            <i class="fas fa-list me-1"></i>分类导航
                        </a>
                    </li>
                    
                    <!-- 主要分类 -->
                    <?php 
                    // 设置要显示在主导航的分类数量（除"更多"下拉菜单外）
                    $mainCategoriesLimit = 5;
                    
                    // 如果存在分类数据，则显示API返回的分类
                    if (isset($categories) && is_array($categories) && !empty($categories)):
                        $mainCategories = array_slice($categories, 0, $mainCategoriesLimit);
                        foreach ($mainCategories as $category):
                            // 获取分类名称，兼容不同数据结构
                            $categoryName = is_array($category) ? ($category['name'] ?? '') : $category;
                            if (empty($categoryName)) continue;
                    ?>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo isset($_GET['name']) && $_GET['name'] == $categoryName ? 'active fw-bold' : ''; ?>" href="/category.php?name=<?php echo urlencode($categoryName); ?>">
                            <?php echo htmlspecialchars($categoryName); ?>
                        </a>
                    </li>
                    <?php 
                        endforeach;
                    else:
                        // 如果没有分类数据，显示默认分类
                    ?>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo isset($_GET['name']) && $_GET['name'] == '头条' ? 'active fw-bold' : ''; ?>" href="/category.php?name=头条">
                            头条
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo isset($_GET['name']) && $_GET['name'] == '国内' ? 'active fw-bold' : ''; ?>" href="/category.php?name=国内">
                            国内
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo isset($_GET['name']) && $_GET['name'] == '国际' ? 'active fw-bold' : ''; ?>" href="/category.php?name=国际">
                            国际
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo isset($_GET['name']) && $_GET['name'] == '军事' ? 'active fw-bold' : ''; ?>" href="/category.php?name=军事">
                            军事
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo isset($_GET['name']) && $_GET['name'] == '财经' ? 'active fw-bold' : ''; ?>" href="/category.php?name=财经">
                            财经
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <!-- 更多分类下拉菜单 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium" href="#" id="moreCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            更多
                        </a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="moreCategories">
                            <?php 
                            // 如果存在分类数据，则显示剩余的分类
                            if (isset($categories) && is_array($categories) && count($categories) > $mainCategoriesLimit):
                                $moreCategories = array_slice($categories, $mainCategoriesLimit);
                                foreach ($moreCategories as $category):
                                    // 获取分类名称，兼容不同数据结构
                                    $categoryName = is_array($category) ? ($category['name'] ?? '') : $category;
                                    if (empty($categoryName)) continue;
                                    
                                    // 为分类选择适当的图标
                                    $icon = 'fa-folder';
                                    if (strpos($categoryName, '科技') !== false) $icon = 'fa-microchip';
                                    elseif (strpos($categoryName, '体育') !== false) $icon = 'fa-basketball-ball';
                                    elseif (strpos($categoryName, '娱乐') !== false) $icon = 'fa-film';
                                    elseif (strpos($categoryName, '教育') !== false) $icon = 'fa-graduation-cap';
                                    elseif (strpos($categoryName, '健康') !== false) $icon = 'fa-heartbeat';
                                    elseif (strpos($categoryName, '财经') !== false) $icon = 'fa-chart-line';
                                    elseif (strpos($categoryName, '军事') !== false) $icon = 'fa-fighter-jet';
                            ?>
                            <li>
                                <a class="dropdown-item <?php echo isset($_GET['name']) && $_GET['name'] == $categoryName ? 'active' : ''; ?>" href="/category.php?name=<?php echo urlencode($categoryName); ?>">
                                    <i class="fas <?php echo $icon; ?> me-2"></i><?php echo htmlspecialchars($categoryName); ?>
                                </a>
                            </li>
                            <?php 
                                endforeach;
                            else:
                                // 如果没有更多分类数据，显示默认分类
                            ?>
                            <li>
                                <a class="dropdown-item <?php echo isset($_GET['name']) && $_GET['name'] == '科技' ? 'active' : ''; ?>" href="/category.php?name=科技">
                                    <i class="fas fa-microchip me-2"></i>科技
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo isset($_GET['name']) && $_GET['name'] == '体育' ? 'active' : ''; ?>" href="/category.php?name=体育">
                                    <i class="fas fa-basketball-ball me-2"></i>体育
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo isset($_GET['name']) && $_GET['name'] == '娱乐' ? 'active' : ''; ?>" href="/category.php?name=娱乐">
                                    <i class="fas fa-film me-2"></i>娱乐
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo isset($_GET['name']) && $_GET['name'] == '教育' ? 'active' : ''; ?>" href="/category.php?name=教育">
                                    <i class="fas fa-graduation-cap me-2"></i>教育
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo isset($_GET['name']) && $_GET['name'] == '健康' ? 'active' : ''; ?>" href="/category.php?name=健康">
                                    <i class="fas fa-heartbeat me-2"></i>健康
                                </a>
                            </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="/categories.php">
                                    <i class="fas fa-th-list me-2"></i>所有分类
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- 专题 -->
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo basename($_SERVER['PHP_SELF']) == 'topics.php' ? 'active fw-bold' : ''; ?>" href="/topics.php">
                            专题
                        </a>
                    </li>
                </ul>
                
                <!-- 搜索框 -->
                <form class="d-flex" action="/search.php" method="get" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" name="q" placeholder="搜索..." 
                               aria-label="搜索" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
                        <button class="btn btn-outline-primary" type="submit" aria-label="搜索按钮">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- 热门标签(可选，根据页面是否需要显示) -->
    <?php if (isset($showHotTags) && $showHotTags && isset($hotTags) && !empty($hotTags)): ?>
    <div class="hot-tags-bar py-2 bg-light border-top border-bottom">
        <div class="container">
            <div class="d-flex align-items-center">
                <span class="hot-tags-label fw-medium me-2"><i class="fas fa-tags text-primary me-1"></i>热门标签:</span>
                <div class="hot-tags-scroll">
                    <ul class="list-inline mb-0">
                        <?php foreach(array_slice($hotTags, 0, 10) as $tag): ?>
                        <li class="list-inline-item">
                            <a href="/tag.php?name=<?php echo urlencode($tag['name']); ?>" class="badge bg-white text-dark border">
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="/tags.php" class="ms-auto small">更多</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- SEO 优化的辅助导航 - 首页才展示，可增强内链结构 -->
    <?php if (basename($_SERVER['PHP_SELF']) == 'index.php' && empty($_GET)): ?>
    <div class="sub-category-nav py-2 d-none d-lg-block bg-light border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav small justify-content-between" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <?php 
                        // 如果存在分类数据，则显示所有分类（或最多10个）
                        if (isset($categories) && is_array($categories) && !empty($categories)):
                            // 显示最多10个分类
                            $seoCategories = array_slice($categories, 0, 10);
                            foreach ($seoCategories as $category):
                                // 获取分类名称，兼容不同数据结构
                                $categoryName = is_array($category) ? ($category['name'] ?? '') : $category;
                                if (empty($categoryName)) continue;
                        ?>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=<?php echo urlencode($categoryName); ?>" itemprop="url"><?php echo htmlspecialchars($categoryName); ?></a>
                        </li>
                        <?php 
                            endforeach;
                        else:
                            // 如果没有分类数据，显示默认分类
                        ?>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=时政" itemprop="url">时政</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=社会" itemprop="url">社会</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=法制" itemprop="url">法制</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=文化" itemprop="url">文化</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=汽车" itemprop="url">汽车</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=房产" itemprop="url">房产</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=旅游" itemprop="url">旅游</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=美食" itemprop="url">美食</a>
                        </li>
                        <li class="nav-item" itemprop="name">
                            <a class="nav-link text-dark px-2" href="/category.php?name=生活" itemprop="url">生活</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>

<!-- 移动端导航抽屉菜单的遮罩层 -->
<div class="navbar-backdrop fade" id="navbarBackdrop"></div> 