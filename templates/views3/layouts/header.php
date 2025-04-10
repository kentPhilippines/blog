<!-- 顶部导航 -->
<header class="ne-header">
    <div class="ne-header-inner">
        <a href="/" class="ne-logo">
            <div class="ne-logo-icon"></div>
            <div class="ne-logo-text">新闻<span>客户端</span></div>
        </a>
        <div class="ne-search">
            <form action="/search.php" method="get" role="search">
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
                $isActive = isset($GLOBALS['categoryName']) && $GLOBALS['categoryName'] === $catName;
                ?>
                <div class="ne-nav-item<?php echo $isActive ? ' active' : ''; ?>">
                    <a href="/category.php?name=<?php echo urlencode($catName); ?>"
                       <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                        <?php 
                        // 为不同分类添加对应的图标
                        $icon = '';
                        switch(strtolower($catName)) {
                            case 'nba':
                                $icon = '<i class="fas fa-basketball-ball"></i>';
                                break;
                            case 'cba':
                                $icon = '<i class="fas fa-basketball-ball"></i>';
                                break;
                            case '中国足球':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '西甲':
                                $icon = '<i class="fas fa-futbol"></i>';
                                break;
                            case '英超':
                                $icon = '<i class="fas fa-futbol"></i>';
                                break;
                            case '羽毛球':
                                $icon = '<i class="fas fa-table-tennis"></i>';
                                break;
                            case '国字号':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '乒乓球':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '意甲':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '亚冠':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '法甲':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '欧冠':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '游泳':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '德甲':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '台球':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '赛车':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '田径':
                                $icon = '<i class="fas fa-newspaper"></i>';
                                break;
                            case '排球':
                                $icon = '<i class="fas fa-volleyball-ball"></i>';
                                break;
                            default:
                                $icon = '<i class="fas fa-newspaper"></i>';
                        }
                        echo $icon . ' ' . htmlspecialchars($catName);
                        ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</nav>

<!-- 移动端导航栏 -->
<nav class="ne-mobile-nav">
    <div class="ne-mobile-nav-scroll">
        <div class="ne-mobile-nav-inner">
            <a href="/" class="ne-mobile-nav-item<?php echo empty($GLOBALS['categoryName']) ? ' active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>首页</span>
            </a>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <?php 
                    $catName = is_array($cat) ? ($cat['name'] ?? '') : $cat;
                    $isActive = isset($GLOBALS['categoryName']) && $GLOBALS['categoryName'] === $catName;
                    $icon = '';
                    switch(strtolower($catName)) {
                        case 'nba':
                            $icon = '<i class="fas fa-basketball-ball"></i>';
                            break;
                        case 'cba':
                            $icon = '<i class="fas fa-basketball-ball"></i>';
                            break;
                        case '中国足球':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '西甲':
                            $icon = '<i class="fas fa-futbol"></i>';
                            break;
                        case '英超':
                            $icon = '<i class="fas fa-futbol"></i>';
                            break;
                        case '羽毛球':
                            $icon = '<i class="fas fa-table-tennis"></i>';
                            break;
                        case '国字号':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '乒乓球':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '意甲':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '亚冠':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '法甲':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '欧冠':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '游泳':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '德甲':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '台球':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '赛车':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '田径':
                            $icon = '<i class="fas fa-newspaper"></i>';
                            break;
                        case '排球':
                            $icon = '<i class="fas fa-volleyball-ball"></i>';
                            break;
                        default:
                            $icon = '<i class="fas fa-newspaper"></i>';
                    }
                    ?>
                    <a href="/category.php?name=<?php echo urlencode($catName); ?>" 
                       class="ne-mobile-nav-item<?php echo $isActive ? ' active' : ''; ?>">
                        <?php echo $icon; ?>
                        <span><?php echo htmlspecialchars($catName); ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- 移动端导航栏样式 -->
<style>
.ne-mobile-nav {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    border-top: 1px solid #eee;
}

.ne-mobile-nav-scroll {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.ne-mobile-nav-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.ne-mobile-nav-inner {
    display: flex;
    padding: 8px 12px;
    min-width: min-content;
}

.ne-mobile-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #666;
    text-decoration: none;
    font-size: 12px;
    padding: 4px 0;
    min-width: 56px;
    margin: 0 8px;
    position: relative;
}

.ne-mobile-nav-item i {
    font-size: 20px;
    margin-bottom: 4px;
}

.ne-mobile-nav-item span {
    font-size: 12px;
    white-space: nowrap;
}

.ne-mobile-nav-item.active {
    color: #1a73e8;
}

.ne-mobile-nav-item.active::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 12px;
    height: 2px;
    background: #1a73e8;
    border-radius: 1px;
}

/* 移动端适配 */
@media (max-width: 768px) {
    .ne-mobile-nav {
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
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .ne-content {
        padding-bottom: 20px;
    }
}
</style> 