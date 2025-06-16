<?php
/**
 * 网易新闻风格的首页模板
 */
?>
<div class="ne-home">
    <!-- 移动端导航由header.php统一提供 -->

    <!-- 移动端导航样式已在header.php中定义 -->


    <!-- 移动端头条轮播 -->
    <div class="ne-headline-mobile">
        <div class="ne-headline-swiper">
            <?php
            // 获取最新的6条新闻用于轮播
            $carouselNews = array_slice($newsList, 0, 6);
            if (!empty($carouselNews)):
                foreach ($carouselNews as $index => $news):
            ?>
            <div class="ne-headline-swiper-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                <div class="ne-headline-image">
                    <a href="/news.html?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>" class="white">
                        <img src="<?php echo htmlspecialchars($news['coverImage'] ?? ''); ?>" 
                             alt="<?php echo htmlspecialchars($news['title'] ?? ''); ?>">
                    </a>
                    <?php if (!empty($news['category'])): ?>
                    <span class="ne-headline-category">
                        <?php echo htmlspecialchars($news['category']); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="ne-headline-content">
                    <h2 class="ne-headline-title">
                        <a href="/news.html?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>" class="white">
                            <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                        </a>
                    </h2>
                    <div class="ne-headline-meta">
                        <?php if (!empty($news['source'])): ?>
                        <span class="ne-headline-source">
                            <i class="fas fa-newspaper"></i>
                            <?php echo htmlspecialchars($news['source']); ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($news['publishTime'])): ?>
                        <span class="ne-headline-time">
                            <i class="far fa-clock"></i>
                            <?php echo date('m-d H:i', strtotime($news['publishTime'])); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            ?>
            <div class="ne-headline-swiper-dots">
                <?php for ($i = 0; $i < count($carouselNews); $i++): ?>
                <div class="ne-headline-swiper-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></div>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- 头条新闻区域 -->
    <div class="ne-headlines">
        <?php
        // 获取最新的6条新闻用于轮播
        $carouselNews = array_slice($newsList, 0, 6);
        if (!empty($carouselNews) && isset($carouselNews[0])):
        ?>
        <div class="ne-headline-main">
            <div class="ne-headline-image">
                <a href="/news.html?id=<?php echo htmlspecialchars($carouselNews[0]['id'] ?? ''); ?>" class="white">
                    <img src="<?php echo htmlspecialchars($carouselNews[0]['coverImage'] ?? ''); ?>" 
                         alt="<?php echo htmlspecialchars($carouselNews[0]['title'] ?? ''); ?>">
                </a>
                <?php if (!empty($carouselNews[0]['category'])): ?>
                <span class="ne-headline-category">
                    <?php echo htmlspecialchars($carouselNews[0]['category']); ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="ne-headline-content">
                <h2 class="ne-headline-title">
                        <a href="/news.html?id=<?php echo htmlspecialchars($carouselNews[0]['id'] ?? ''); ?>" class="white">
                        <?php echo htmlspecialchars($carouselNews[0]['title'] ?? ''); ?>
                    </a>
                </h2>
                <?php if (!empty($carouselNews[0]['summary'])): ?>
                <p class="ne-headline-summary">
                    <?php echo htmlspecialchars($carouselNews[0]['summary']); ?>
                </p>
                <?php endif; ?>
                <div class="ne-headline-meta">
                    <?php if (!empty($carouselNews[0]['source'])): ?>
                    <span class="ne-headline-source">
                        <i class="fas fa-newspaper"></i>
                        <?php echo htmlspecialchars($carouselNews[0]['source']); ?>
                    </span>
                    <?php endif; ?>
                    <?php if (!empty($carouselNews[0]['publishTime'])): ?>
                    <span class="ne-headline-time">
                        <i class="far fa-clock"></i>
                        <?php echo date('Y-m-d H:i', strtotime($carouselNews[0]['publishTime'])); ?>
                    </span>
                    <?php endif; ?>
                    <?php if (!empty($carouselNews[0]['viewCount'])): ?>
                    <span class="ne-headline-views">
                        <i class="far fa-eye"></i>
                        <?php echo number_format($carouselNews[0]['viewCount']); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- 次要头条 -->
        <div class="ne-headline-sub">
            <?php 
            $subHeadlines = array_slice($carouselNews, 1, 5);
            foreach ($subHeadlines as $news): 
            ?>
            <div class="ne-headline-item">
                <div class="ne-headline-item-image">
                    <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>" class="white">
                        <img src="<?php echo htmlspecialchars($news['coverImage'] ?? ''); ?>" 
                             alt="<?php echo htmlspecialchars($news['title'] ?? ''); ?>">
                    </a>
                    <?php if (!empty($news['category'])): ?>
                    <span class="ne-headline-item-category">
                        <?php echo htmlspecialchars($news['category']); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="ne-headline-item-content">
                    <h2 class="ne-headline-item-title">
                        <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>" class="white">
                            <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                        </a>
                    </h2>
                    <div class="ne-headline-item-meta">
                        <?php if (!empty($news['source'])): ?>
                        <span class="ne-headline-item-source">
                            <?php echo htmlspecialchars($news['source']); ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($news['publishTime'])): ?>
                        <span class="ne-headline-item-time">
                            <?php echo date('m-d H:i', strtotime($news['publishTime'])); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 添加NBA和CBA新闻展示区域 -->
    <div class="ne-basketball-section">
        <!-- NBA新闻卡片 -->
        <div class="ne-basketball-card" data-category="NBA">
            <div class="ne-basketball-header">
                <div class="ne-basketball-title">
                    <span class="ne-logo-nba" data-text="NBA"></span>
                    NBA新闻
                </div>
                <a href="/category.php?name=<?php echo urlencode(Utils::categoryToSlug('NBA')); ?>" class="ne-basketball-more">
                    更多 <i class="fas fa-angle-right"></i>
                </a>
            </div>
            <div class="ne-basketball-content">
                <?php
                if (!empty($nbaNewsForTemplate)):
                    $mainNews = array_shift($nbaNewsForTemplate); // 获取第一条作为主要新闻
                ?>
                    <div class="ne-basketball-main">
                        <img src="<?php echo htmlspecialchars($mainNews['coverImage'] ?? ''); ?>" alt="" class="ne-basketball-main-image">
                        <a href="/news.php?id=<?php echo htmlspecialchars($mainNews['id'] ?? ''); ?>" class="ne-basketball-main-title">
                            <?php echo htmlspecialchars($mainNews['title'] ?? ''); ?>
                        </a>
                    </div>
                    <div class="ne-basketball-list">
                        <?php foreach ($nbaNewsForTemplate as $news): ?>
                        <div class="ne-basketball-item">
                            <img src="<?php echo htmlspecialchars($news['coverImage'] ?? ''); ?>" alt="" class="ne-basketball-item-image">
                            <div class="ne-basketball-item-info">
                                <h4 class="ne-basketball-item-title">
                                    <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                                    </a>
                                </h4>
                                <div class="ne-basketball-item-meta">
                                    <?php if (!empty($news['publishTime'])): ?>
                                        <?php echo date('m-d H:i', strtotime($news['publishTime'])); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="ne-empty-message">暂无NBA新闻</div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- CBA新闻卡片 -->
        <div class="ne-basketball-card" data-category="CBA">
            <div class="ne-basketball-header">
                <div class="ne-basketball-title">
                    <span class="ne-logo-cba" data-text="CBA"></span>
                    CBA新闻
                </div>
                <a href="/category.php?name=<?php echo urlencode(Utils::categoryToSlug('CBA')); ?>" class="ne-basketball-more">
                    更多 <i class="fas fa-angle-right"></i>
                </a>
            </div>
            <div class="ne-basketball-content">
                <?php
                if (!empty($cbaNewsForTemplate)):
                    error_log("开始处理CBA新闻数据展示");
                    $mainNews = array_shift($cbaNewsForTemplate); // 获取第一条作为主要新闻
                ?>
                    <div class="ne-basketball-main">
                        <img src="<?php echo htmlspecialchars($mainNews['coverImage'] ?? ''); ?>" alt="" class="ne-basketball-main-image">
                        <a href="/news.php?id=<?php echo htmlspecialchars($mainNews['id'] ?? ''); ?>" class="ne-basketball-main-title">
                            <?php echo htmlspecialchars($mainNews['title'] ?? ''); ?>
                        </a>
                    </div>
                    <div class="ne-basketball-list">
                        <?php foreach ($cbaNewsForTemplate as $news): ?>
                        <div class="ne-basketball-item">
                            <img src="<?php echo htmlspecialchars($news['coverImage'] ?? ''); ?>" alt="" class="ne-basketball-item-image">
                            <div class="ne-basketball-item-info">
                                <h4 class="ne-basketball-item-title">
                                    <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                                    </a>
                                </h4>
                                <div class="ne-basketball-item-meta">
                                    <?php if (!empty($news['publishTime'])): ?>
                                        <?php echo date('m-d H:i', strtotime($news['publishTime'])); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <?php error_log("没有找到CBA新闻数据"); ?>
                    <div class="ne-empty-message">暂无CBA新闻</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 主要内容区 -->
    <div class="ne-content">
        <!-- 左侧新闻列表 -->
        <div class="ne-news-list">
            <?php 
            // 跳过已经在轮播中显示的新闻
            $remainingNews = array_slice($newsList, 4);
            foreach ($remainingNews as $news): 
            ?>
            <article class="ne-news-item">
                <?php if (!empty($news['image'])): ?>
                <div class="ne-news-image">
                    <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>" >
                        <img src="<?php echo htmlspecialchars($news['image']); ?>" 
                             alt="<?php echo htmlspecialchars($news['title'] ?? ''); ?>">
                    </a>
                </div>
                <?php endif; ?>
                <div class="ne-news-info">
                    <h3 class="ne-news-title">
                        <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>">
                            <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                        </a>
                    </h3>
                    <div class="ne-news-meta">
                        <?php if (!empty($news['category'])): ?>
                        <span class="ne-news-category">
                            <a href="/category.php?name=<?php echo urlencode(Utils::categoryToSlug($news['category'])); ?>">
                                <?php echo htmlspecialchars($news['category']); ?>
                            </a>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($news['publishTime'])): ?>
                        <span class="ne-news-time">
                            <?php echo date('Y-m-d H:i', strtotime($news['publishTime'])); ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($news['source'])): ?>
                        <span class="ne-news-source">
                            <?php echo htmlspecialchars($news['source']); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($news['summary'])): ?>
                    <p class="ne-news-summary">
                        <?php echo htmlspecialchars($news['summary']); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>

            <!-- 分页 -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="ne-pagination">
                <?php echo $pagination; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- 右侧边栏 -->
        <aside class="ne-sidebar">
            <!-- 热门新闻排行 -->
            <div class="ne-hot-rank">
                <h3 class="ne-sidebar-title">
                    <i class="fas fa-fire"></i> 热门排行
                </h3>
                <?php if (!empty($hotNews)): ?>
                <ul class="ne-rank-list">
                    <?php 
                    $rankNews = array_slice($hotNews, 0, 10);
                    foreach ($rankNews as $index => $news): 
                    ?>
                    <li class="ne-rank-item<?php echo $index < 3 ? ' ne-rank-top' : ''; ?>">
                        <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>" class="ne-rank-link">
                            <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="ne-empty-message">暂无热门新闻</p>
                <?php endif; ?>
            </div>

            <!-- 热门标签 -->
            <div class="ne-hot-tags">
                <h3 class="ne-sidebar-title">
                    <i class="fas fa-tags"></i> 热门标签
                </h3>
                <?php if (!empty($tags)): ?>
                <div class="ne-tag-cloud">
                    <?php foreach ($tags as $tag): ?>
                    <a href="/tag.php?name=<?php echo urlencode($tag['name'] ?? ''); ?>" 
                       class="ne-tag-item">
                        <?php echo htmlspecialchars($tag['name'] ?? ''); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="ne-empty-message">暂无标签</p>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<!-- 添加轮播效果的JavaScript代码 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化头条轮播
    initHeadlineSwiper();
});

// 初始化头条轮播功能
function initHeadlineSwiper() {
    const swiperContainer = document.querySelector('.ne-headline-swiper');
    if (!swiperContainer) return;
    
    const slides = document.querySelectorAll('.ne-headline-swiper-slide');
    const dots = document.querySelectorAll('.ne-headline-swiper-dot');
    let currentIndex = 0;
    let autoplayInterval;
    
    // 设置自动播放
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            goToSlide((currentIndex + 1) % slides.length);
        }, 5000); // 每5秒切换一次
    }
    
    // 停止自动播放
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }
    
    // 切换到指定的幻灯片
    function goToSlide(index) {
        if (index === currentIndex) return;
        
        slides[currentIndex].classList.remove('active');
        dots[currentIndex].classList.remove('active');
        
        currentIndex = index;
        
        slides[currentIndex].classList.add('active');
        dots[currentIndex].classList.add('active');
    }
    
    // 为小圆点添加点击事件
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            stopAutoplay();
            startAutoplay();
        });
    });
    
    // 添加触摸滑动功能
    let touchStartX = 0;
    let touchEndX = 0;
    
    swiperContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
    }, { passive: true });
    
    swiperContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startAutoplay();
    }, { passive: true });
    
    function handleSwipe() {
        // 计算滑动距离
        const swipeDistance = touchEndX - touchStartX;
        const threshold = 50; // 需要滑动超过这个距离才会切换
        
        if (swipeDistance > threshold) {
            // 向右滑动，显示上一张
            goToSlide((currentIndex - 1 + slides.length) % slides.length);
        } else if (swipeDistance < -threshold) {
            // 向左滑动，显示下一张
            goToSlide((currentIndex + 1) % slides.length);
        }
    }
    
    // 开始自动播放
    startAutoplay();
    
    // 当页面不可见时暂停自动播放
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });
}

// 移动端导航JavaScript已在header.php中定义

</script>

</div> <!-- 结束.ne-home div --> 