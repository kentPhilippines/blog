<header class="site-header">
    <!-- 顶部状态栏 -->
    <div class="top-status-bar py-1" style="background-color: var(--primary-dark);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="d-flex align-items-center">
                        <span class="small text-white-50 me-3">
                            <i class="mdi mdi-calendar-clock me-1"></i> <?php echo date('Y年m月d日 H:i'); ?>
                        </span>
                        <div class="vr bg-white-50 opacity-25 me-3" style="height: 16px;"></div>
                        <a href="/rss.php" class="text-white-50 small me-3 text-decoration-none" target="_blank">
                            <i class="mdi mdi-rss me-1"></i>RSS订阅
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end justify-content-center">
                        <!-- 主题切换按钮 -->
                        <button id="theme-toggle" class="btn btn-sm text-white-50 me-2 p-0" title="切换主题">
                            <i class="mdi mdi-white-balance-sunny"></i>
                        </button>
                        
                        <!-- 字体大小控制 -->
                        <div class="dropdown">
                            <button class="btn btn-sm text-white-50 dropdown-toggle p-0" type="button" id="fontSizeMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-format-size me-1"></i><span class="d-none d-sm-inline-block small">字体</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="fontSizeMenu" style="background-color: var(--surface-color);">
                                <li><button class="dropdown-item text-white-50 font-size-option" data-size="small">小</button></li>
                                <li><button class="dropdown-item text-white-50 font-size-option" data-size="medium">中</button></li>
                                <li><button class="dropdown-item text-white-50 font-size-option" data-size="large">大</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 导航栏 -->
    <nav class="navbar navbar-expand-lg py-3" style="background-color: var(--surface-color);">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <?php if (isset($domainConfig['logoUrl']) && !empty($domainConfig['logoUrl'])): ?>
                    <img src="<?php echo htmlspecialchars($domainConfig['logoUrl']); ?>" alt="<?php echo isset($domainConfig['title']) ? htmlspecialchars($domainConfig['title']) : '网站标志'; ?>" height="40" class="d-inline-block align-top">
                <?php else: ?>
                    <span class="fw-bold text-gradient">
                        <i class="mdi mdi-newspaper-variant-outline me-2"></i>
                        <?php echo isset($domainConfig['title']) ? htmlspecialchars($domainConfig['title']) : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <!-- 移动端菜单按钮 -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="切换导航">
                <span class="navbar-toggler-icon text-primary-light">
                    <i class="mdi mdi-menu"></i>
                </span>
            </button>
            
            <!-- 导航菜单 -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo empty($_SERVER['QUERY_STRING']) && basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" aria-current="page" href="/">
                            <i class="mdi mdi-home-outline me-1"></i>首页
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isset($_GET['type']) && $_GET['type'] === 'hot' ? 'active' : ''; ?>" href="/news.php?type=hot">
                            <i class="mdi mdi-shape-outline me-1"></i>分类导航
                        </a>
                    </li>
                    
                    <!-- 动态生成分类导航 -->
                    <?php if (isset($categories) && is_array($categories)): ?>
                        <?php 
                        // 只显示文章数量大于0的前5个分类
                        $displayCategories = array_filter($categories, function($cat) {
                            return isset($cat['newsCount']) && $cat['newsCount'] > 0;
                        });
                        $displayCategories = array_slice($displayCategories, 0, 5);
                        ?>
                        
                        <?php foreach ($displayCategories as $category): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isset($_GET['name']) && $_GET['name'] == $category['name'] ? 'active' : ''; ?>" href="/category.php?name=<?php echo urlencode($category['name']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                
                <!-- 搜索表单 -->
                <form class="d-flex" action="/search.php" method="get">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="搜索内容..." aria-label="搜索" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: var(--text-primary);">
                        <button class="btn btn-primary" type="submit">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- 面包屑导航 -->
    <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
    <div class="breadcrumb-wrapper py-2" style="background-color: rgba(255,255,255,0.03);">
        <div class="container">
            <nav aria-label="面包屑导航">
                <ol class="breadcrumb mb-0 small">
                    <?php foreach ($breadcrumbs as $index => $crumb): ?>
                        <?php if ($index == count($breadcrumbs) - 1): ?>
                            <li class="breadcrumb-item active text-white-50" aria-current="page"><?php echo htmlspecialchars($crumb['text']); ?></li>
                        <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?php echo $crumb['url']; ?>" class="text-primary-light"><?php echo htmlspecialchars($crumb['text']); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- 全局公告栏 -->
    <?php if (isset($siteAnnouncement)): ?>
    <div class="announcement-bar py-2 text-center" style="background-color: rgba(187, 134, 252, 0.1);">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <i class="mdi mdi-bell-ring-outline me-2 text-primary-light"></i>
                <span class="announcement-text"><?php echo $siteAnnouncement; ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>

<style>
    .navbar .nav-link {
        position: relative;
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }
    
    .navbar .nav-link.active,
    .navbar .nav-link:hover {
        color: var(--primary-light);
    }
    
    .navbar .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background-color: var(--primary-light);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    
    .navbar .nav-link.active::after,
    .navbar .nav-link:hover::after {
        width: 80%;
    }
    
    .text-gradient {
        background: linear-gradient(90deg, var(--primary-light), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
    }
    
    .dropdown-item:hover {
        background-color: rgba(187, 134, 252, 0.1);
    }
    
    .breadcrumb-item+.breadcrumb-item::before {
        color: var(--text-hint);
    }
    
    @media (max-width: 768px) {
        .navbar-toggler-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 1.5rem;
        }
    }
</style> 