<!-- 顶部导航 -->
<header class="ne-header">
    <div class="ne-header-inner">
        <a href="/" class="ne-logo">
            <h1 >
            <div class="ne-logo-icon"></div>
            </h1>

            <div class="ne-logo-text"><?php echo htmlspecialchars($domainConfig['title'] ?? DYNAMIC_SITE_NAME); ?><span><?php echo htmlspecialchars($domainConfig['subtitle'] ?? '客户端'); ?></span></div>
        </a>
        <div class="ne-search">
            <form action="/search.html" method="get" role="search">
                <input type="text" 
                       name="keyword" 
                       class="ne-search-input" 
                       placeholder="搜索新闻" 
                       aria-label="搜索新闻"
                       value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                <button type="submit" class="ne-search-btn" aria-label="搜索">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- 导航栏 -->
<nav class="ne-nav" aria-label="主导航">
    <div class="ne-nav-list">
        <div class="ne-nav-item<?php echo empty($GLOBALS['categoryName']) ? ' active' : ''; ?>">
            <a href="/" <?php echo empty($GLOBALS['categoryName']) ? 'aria-current="page"' : ''; ?>>
                <i class="fas fa-home"></i> 首页
            </a>
        </div>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <?php 
                $catName = is_array($cat) ? ($cat['name'] ?? '') : $cat;
                $catpinyin = Utils::categoryToSlug($catName);
                $isActive = isset($GLOBALS['categoryName']) && $GLOBALS['categoryName'] === $catName;
                ?>
                <div class="ne-nav-item<?php echo $isActive ? ' active' : ''; ?>">
                    <a href="/category.php?name=<?php echo urlencode($catpinyin); ?>"
                       <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                        <i class="<?php echo htmlspecialchars($cat['icon'] ?? 'fas fa-newspaper'); ?>"></i> <?php echo htmlspecialchars($catName); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <!-- 检索按钮 -->
        <div class="ne-nav-item ne-nav-search-btn">
            <a href="/search.php" class="ne-nav-search-link">
                <i class="fas fa-search"></i> 检索
            </a>
        </div>
    </div>
</nav>

<!-- 移动端导航栏 -->
<div class="ne-mobile-nav-container">
    <!-- 移动端按钮组 -->
    <div class="ne-mobile-buttons">
        <!-- 检索按钮 -->
        <a href="/search.php" class="ne-mobile-search-btn" aria-label="新闻检索">
            <i class="fas fa-search"></i>
            <span>检索</span>
        </a>
        
        <!-- 导航按钮 -->
        <button class="ne-mobile-nav-toggle" id="mobileNavToggle" aria-label="打开导航菜单">
            <i class="fas fa-bars"></i>
            <span>导航</span>
        </button>
    </div>
    
    <!-- 导航菜单 -->
    <nav class="ne-mobile-nav" id="mobileNav">
        <div class="ne-mobile-nav-header">
            <h3>导航菜单</h3>
            <button class="ne-mobile-nav-close" id="mobileNavClose" aria-label="关闭导航菜单">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="ne-mobile-nav-scroll">
            <div class="ne-mobile-nav-inner">
                <a href="/" class="ne-mobile-nav-item<?php echo empty($GLOBALS['categoryName']) ? ' active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>首页</span>
                </a>
                <?php 
                // 尝试从多个来源获取分类数据
                $availableCategories = [];
                if (!empty($domainConfig['categories'])) {
                    $availableCategories = $domainConfig['categories'];
                } elseif (!empty($categories)) {
                    $availableCategories = $categories;
                }
                
                if (!empty($availableCategories)): ?>
                    <?php foreach ($availableCategories as $cat): ?>
                        <?php 
                        $catName = is_array($cat) ? ($cat['name'] ?? '') : $cat;
                        $catIcon = is_array($cat) ? ($cat['icon'] ?? 'fas fa-newspaper') : 'fas fa-newspaper';
                        $catpinyin = Utils::categoryToSlug($catName);
                        $isActive = isset($GLOBALS['categoryName']) && $GLOBALS['categoryName'] === $catName;
                        ?>
                        <a href="/category.php?name=<?php echo urlencode($catpinyin); ?>" 
                           class="ne-mobile-nav-item<?php echo $isActive ? ' active' : ''; ?>">
                            <i class="<?php echo htmlspecialchars($catIcon); ?>"></i>
                            <span><?php echo htmlspecialchars($catName); ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- 遮罩层 -->
    <div class="ne-mobile-nav-overlay" id="mobileNavOverlay"></div>
</div>

<!-- 导航检索按钮和移动端导航栏样式 -->
<style>
/* 桌面端检索按钮 */
.ne-nav-search-btn .ne-nav-search-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 25px;
    margin: 8px 0;
    line-height: 30px !important;
    padding: 0 18px !important;
    color: white !important;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.ne-nav-search-btn .ne-nav-search-link:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white !important;
}

.ne-nav-search-btn .ne-nav-search-link::after {
    display: none; /* 移除下划线效果 */
}

.ne-nav-search-btn .ne-nav-search-link i {
    color: #ffd700;
    margin-right: 6px;
}

/* 移动端隐藏桌面端检索按钮 */
@media (max-width: 768px) {
    .ne-nav-search-btn {
        display: none;
    }
}
/* 移动端导航容器 */
.ne-mobile-nav-container {
    display: none;
}

/* 桌面端显示移动端按钮时隐藏桌面端导航 */
@media (max-width: 768px) {
    .ne-mobile-nav-container {
        display: block;
    }
}

/* 移动端按钮组 */
.ne-mobile-buttons {
    position: fixed;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 8px;
    z-index: 1001;
}

/* 移动端检索按钮 */
.ne-mobile-search-btn {
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
}

.ne-mobile-search-btn:hover {
    background: #5a67d8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
}

.ne-mobile-search-btn i {
    font-size: 16px;
}

/* 导航切换按钮 */
.ne-mobile-nav-toggle {
    background: #1a73e8;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(26, 115, 232, 0.3);
    transition: all 0.3s ease;
}

.ne-mobile-nav-toggle:hover {
    background: #1557b0;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(26, 115, 232, 0.4);
}

.ne-mobile-nav-toggle i {
    font-size: 16px;
}

/* 导航菜单 */
.ne-mobile-nav {
    position: fixed;
    top: 0;
    left: -280px; /* 初始隐藏在左侧 */
    width: 280px;
    height: 100vh;
    background: #fff;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 1002;
    transition: left 0.3s ease;
    overflow: hidden;
}

.ne-mobile-nav.active {
    left: 0; /* 滑入显示 */
}

/* 导航菜单头部 */
.ne-mobile-nav-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.ne-mobile-nav-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

.ne-mobile-nav-close {
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.ne-mobile-nav-close:hover {
    background: #e9ecef;
    color: #333;
}

.ne-mobile-nav-close i {
    font-size: 18px;
}

/* 导航内容滚动区域 */
.ne-mobile-nav-scroll {
    height: calc(100vh - 70px); /* 减去header高度 */
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    padding: 10px 0;
}

.ne-mobile-nav-scroll::-webkit-scrollbar {
    width: 4px;
}

.ne-mobile-nav-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.ne-mobile-nav-scroll::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.ne-mobile-nav-inner {
    display: flex;
    flex-direction: column; /* 垂直排列 */
    padding: 0;
}

/* 导航项目 */
.ne-mobile-nav-item {
    display: flex;
    align-items: center;
    color: #333;
    text-decoration: none;
    font-size: 15px;
    padding: 12px 20px;
    margin: 2px 0;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.ne-mobile-nav-item:hover {
    background: #f8f9fa;
    color: #1a73e8;
}

.ne-mobile-nav-item.active {
    background: #e3f2fd;
    color: #1a73e8;
    border-left-color: #1a73e8;
    font-weight: 600;
}

.ne-mobile-nav-item i {
    font-size: 18px;
    margin-right: 12px;
    width: 20px;
    text-align: center;
}

.ne-mobile-nav-item span {
    font-size: 15px;
    white-space: nowrap;
}

/* 遮罩层 */
.ne-mobile-nav-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1001;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.ne-mobile-nav-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* 移动端适配 */
@media (max-width: 768px) {
    .ne-mobile-nav-container {
        display: block;
    }

    .ne-nav {
        display: none; /* 隐藏默认导航栏 */
    }

    .ne-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: #fff;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    body {
        padding-top: 60px; /* 只需要header的高度 */
        padding-bottom: 20px;
    }

    .ne-content {
        padding-bottom: 20px;
    }
}

/* 桌面端隐藏 */
@media (min-width: 769px) {
    .ne-mobile-nav-container {
        display: none !important;
    }
}
</style>

<!-- 移动端导航JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavClose = document.getElementById('mobileNavClose');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');
    
    // 检查元素是否存在
    if (!mobileNavToggle || !mobileNav || !mobileNavClose || !mobileNavOverlay) {
        console.log('Mobile navigation elements not found in header - this is normal for some pages');
        return;
    }
    
    // 打开导航菜单
    function openMobileNav() {
        mobileNav.classList.add('active');
        mobileNavOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // 禁止背景滚动
        
        // 更改按钮图标
        const toggleIcon = mobileNavToggle.querySelector('i');
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-times';
        }
        mobileNavToggle.setAttribute('aria-label', '关闭导航菜单');
    }
    
    // 关闭导航菜单
    function closeMobileNav() {
        mobileNav.classList.remove('active');
        mobileNavOverlay.classList.remove('active');
        document.body.style.overflow = ''; // 恢复背景滚动
        
        // 恢复按钮图标
        const toggleIcon = mobileNavToggle.querySelector('i');
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-bars';
        }
        mobileNavToggle.setAttribute('aria-label', '打开导航菜单');
    }
    
    // 切换导航菜单
    function toggleMobileNav() {
        if (mobileNav.classList.contains('active')) {
            closeMobileNav();
        } else {
            openMobileNav();
        }
    }
    
    // 绑定事件
    mobileNavToggle.addEventListener('click', toggleMobileNav);
    mobileNavClose.addEventListener('click', closeMobileNav);
    mobileNavOverlay.addEventListener('click', closeMobileNav);
    
    // 点击导航项后关闭菜单
    const navItems = document.querySelectorAll('.ne-mobile-nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            // 延迟关闭，让用户看到点击效果
            setTimeout(closeMobileNav, 200);
        });
    });
    
    // ESC键关闭菜单
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
            closeMobileNav();
        }
    });
    
    // 窗口大小改变时关闭菜单
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && mobileNav.classList.contains('active')) {
            closeMobileNav();
        }
    });
});
</script> 