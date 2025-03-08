<?php
// 确保有新闻数据
if (empty($newsList)) {
    echo '<div class="alert alert-warning">暂无新闻数据</div>';
    return;
}

// 添加调试信息
if (isset($_GET['debug']) && $_GET['debug'] == 1) {
    echo '<div class="alert alert-info">';
    echo '<h5>调试信息</h5>';
    
    // 显示请求参数
    echo '<h6>请求参数:</h6>';
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';
    
    // 显示新闻数据
    echo '<h6>新闻数据:</h6>';
    echo '<pre>';
    // 只显示前3条新闻，避免页面过长
    $debugNewsList = array_slice($newsList, 0, 3);
    foreach ($debugNewsList as &$news) {
        // 截断可能很长的字段
        if (isset($news['content'])) {
            $news['content'] = substr($news['content'], 0, 100) . '...';
        }
        if (isset($news['summary'])) {
            $news['summary'] = substr($news['summary'], 0, 100) . '...';
        }
    }
    print_r($debugNewsList);
    echo '</pre>';
    
    // 显示分类数据
    if (isset($categories)) {
        echo '<h6>分类数据:</h6>';
        echo '<pre>';
        print_r($categories);
        echo '</pre>';
    }
    
    echo '</div>';
}

// 最多显示8条新闻
$displayNews = array_slice($newsList, 0, 8);

// 为新闻项分配不同的强调色
$accentColors = ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#d35400', '#34495e'];
?>

<div class="news-section-container">
    <!-- 装饰色彩块 -->
    <div class="color-block color-block-1"></div>
    <div class="color-block color-block-2"></div>
    <div class="color-block color-block-3"></div>
    
    <div class="category-news-section mb-5">
        <div class="section-header">
            <h2 class="section-title">热门滚动</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="news-card-container">
            <div class="card news-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-left">
                        <div class="header-icon"><i class="fas fa-fire"></i></div>
                        <h5 class="mb-0">最新资讯</h5>
                    </div>
                    <a href="/news.php" class="btn btn-sm btn-primary view-more-btn">
                        查看更多 <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="news-ticker-container">
                        <div class="news-ticker-wrapper">
                            <div class="news-ticker-scroll">
                                <?php foreach ($displayNews as $index => $news): 
                                    // 为每个新闻项分配一个强调色
                                    $accentColor = $accentColors[$index % count($accentColors)];
                                ?>
                                    <div class="news-ticker-item" data-accent="<?php echo $accentColor; ?>">
                                        <div class="item-accent" style="background-color: <?php echo $accentColor; ?>"></div>
                                        <div class="row g-0 p-3">
                                            <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                                <div class="col-md-3 col-4">
                                                    <div class="news-image-container">
                                                        <img src="<?php echo $news['coverImage']; ?>" class="img-fluid rounded news-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-9 col-8 ps-md-3">
                                            <?php else: ?>
                                                <div class="col-12">
                                            <?php endif; ?>
                                                    <h6 class="news-title mb-2">
                                                        <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none">
                                                            <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                                        </a>
                                                    </h6>
                                                    <p class="news-summary d-none d-md-block"><?php echo isset($news['summary']) ? Utils::truncateText($news['summary'], 80) : '暂无摘要'; ?></p>
                                                    <div class="news-meta">
                                                        <?php if (isset($news['categoryName'])): ?>
                                                        <span class="news-category" style="background-color: <?php echo $accentColor; ?>">
                                                            <?php echo htmlspecialchars($news['categoryName']); ?>
                                                        </span>
                                                        <?php endif; ?>
                                                        <span class="news-time">
                                                            <i class="far fa-clock"></i> 
                                                            <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?>
                                                        </span>
                                                        <span class="news-views">
                                                            <i class="far fa-eye"></i> 
                                                            <?php echo isset($news['viewCount']) ? $news['viewCount'] : 0; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="news-ticker-controls">
                            <button class="btn btn-control ticker-control" id="prevButton" title="上一条">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <button class="btn btn-control ticker-control" id="pauseButton" title="暂停">
                                <i class="fas fa-pause"></i>
                            </button>
                            <button class="btn btn-control ticker-control" id="nextButton" title="下一条">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* 整体容器样式 */
.news-section-container {
    position: relative;
    padding: 20px 0;
    overflow: hidden;
}

/* 装饰色彩块 */
.color-block {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    z-index: -1;
}

.color-block-1 {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #3498db, #9b59b6);
    top: -100px;
    left: -100px;
}

.color-block-2 {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #e74c3c, #f39c12);
    bottom: -50px;
    right: -50px;
}

.color-block-3 {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, #2ecc71, #1abc9c);
    top: 50%;
    right: 20%;
}

/* 标题样式 */
.section-header {
    margin-bottom: 25px;
    position: relative;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    position: relative;
    display: inline-block;
}

.section-line {
    height: 3px;
    width: 80px;
    background: linear-gradient(to right, #3498db, #2ecc71);
    border-radius: 3px;
}

/* 卡片容器 */
.news-card-container {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.news-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

/* 卡片头部 */
.card-header {
    background: linear-gradient(to right, #3498db, #2980b9);
    color: white;
    border-bottom: none;
    padding: 15px 20px;
}

.header-left {
    display: flex;
    align-items: center;
}

.header-icon {
    margin-right: 10px;
    font-size: 1.2rem;
    background-color: rgba(255, 255, 255, 0.2);
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.view-more-btn {
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    transition: all 0.3s ease;
}

.view-more-btn:hover {
    background-color: rgba(255, 255, 255, 0.3);
    transform: translateX(3px);
}

/* 新闻滚动区域 */
.news-ticker-container {
    position: relative;
    overflow: hidden;
    height: 450px;
    background-color: #fff;
}

.news-ticker-wrapper {
    height: 100%;
    overflow: hidden;
    position: relative;
}

.news-ticker-scroll {
    position: absolute;
    width: 100%;
    transition: transform 0.5s ease;
}

/* 新闻项样式 */
.news-ticker-item {
    position: relative;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    background-color: #fff;
    transition: all 0.3s ease;
    overflow: hidden;
}

.item-accent {
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
}

.news-ticker-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* 新闻图片容器 */
.news-image-container {
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    height: 100%;
}

.news-image {
    transition: transform 0.5s ease;
    object-fit: cover;
    height: 100%;
    min-height: 120px;
    width: 100%;
}

.news-ticker-item:hover .news-image {
    transform: scale(1.05);
}

/* 新闻标题 */
.news-title {
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 8px;
}

.news-title a {
    color: #2c3e50;
    transition: color 0.3s ease;
}

.news-title a:hover {
    color: #3498db;
}

/* 新闻摘要 */
.news-summary {
    color: #7f8c8d;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 10px;
}

/* 新闻元数据 */
.news-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    font-size: 0.8rem;
}

.news-category {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 3px;
    color: white;
    font-weight: 500;
}

.news-time, .news-views {
    color: #95a5a6;
}

/* 控制按钮 */
.news-ticker-controls {
    position: absolute;
    bottom: 15px;
    right: 15px;
    z-index: 10;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.btn-control {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(52, 152, 219, 0.8);
    color: white;
    border: none;
    opacity: 0.7;
    transition: all 0.3s ease;
}

.btn-control:hover {
    opacity: 1;
    background-color: rgba(52, 152, 219, 1);
}

/* 响应式调整 */
@media (max-width: 767.98px) {
    .news-ticker-container {
        height: 400px;
    }
    
    .news-title {
        font-size: 1rem;
    }
    
    .color-block {
        opacity: 0.05;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tickerScroll = document.querySelector('.news-ticker-scroll');
    const tickerItems = document.querySelectorAll('.news-ticker-item');
    const pauseButton = document.getElementById('pauseButton');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    
    if (!tickerScroll || tickerItems.length === 0) return;
    
    let currentIndex = 0;
    let isPaused = false;
    let itemHeight = 0;
    let scrollInterval;
    
    // 计算高度并设置初始状态
    function initTicker() {
        // 确保每个项目都已完全加载
        itemHeight = tickerItems[0].offsetHeight;
        
        // 如果高度为0，可能是图片还未加载完成，等待一下再试
        if (itemHeight === 0) {
            setTimeout(initTicker, 100);
            return;
        }
        
        // 设置滚动容器的高度
        tickerScroll.style.height = (itemHeight * tickerItems.length) + 'px';
        
        // 初始化位置
        scrollToIndex(0);
        
        // 开始自动滚动
        startScrolling();
    }
    
    // 滚动到指定索引
    function scrollToIndex(index) {
        currentIndex = index;
        tickerScroll.style.transform = `translateY(-${currentIndex * itemHeight}px)`;
    }
    
    // 自动滚动函数
    function startScrolling() {
        // 清除可能存在的旧定时器
        if (scrollInterval) {
            clearInterval(scrollInterval);
        }
        
        scrollInterval = setInterval(() => {
            if (isPaused) return;
            
            currentIndex = (currentIndex + 1) % tickerItems.length;
            scrollToIndex(currentIndex);
        }, 5000); // 每5秒滚动一次
    }
    
    // 初始化滚动器
    initTicker();
    
    // 确保图片加载后重新计算高度
    window.addEventListener('load', function() {
        initTicker();
    });
    
    // 暂停/继续按钮
    pauseButton.addEventListener('click', function() {
        isPaused = !isPaused;
        
        if (isPaused) {
            pauseButton.innerHTML = '<i class="fas fa-play"></i>';
            pauseButton.setAttribute('title', '继续');
        } else {
            pauseButton.innerHTML = '<i class="fas fa-pause"></i>';
            pauseButton.setAttribute('title', '暂停');
            // 立即滚动到下一条
            currentIndex = (currentIndex + 1) % tickerItems.length;
            scrollToIndex(currentIndex);
        }
    });
    
    // 上一条按钮
    prevButton.addEventListener('click', function() {
        isPaused = true;
        pauseButton.innerHTML = '<i class="fas fa-play"></i>';
        pauseButton.setAttribute('title', '继续');
        
        currentIndex = (currentIndex - 1 + tickerItems.length) % tickerItems.length;
        scrollToIndex(currentIndex);
    });
    
    // 下一条按钮
    nextButton.addEventListener('click', function() {
        isPaused = true;
        pauseButton.innerHTML = '<i class="fas fa-play"></i>';
        pauseButton.setAttribute('title', '继续');
        
        currentIndex = (currentIndex + 1) % tickerItems.length;
        scrollToIndex(currentIndex);
    });
    
    // 鼠标悬停时暂停
    document.querySelector('.news-ticker-wrapper').addEventListener('mouseenter', function() {
        isPaused = true;
        pauseButton.innerHTML = '<i class="fas fa-play"></i>';
    });
    
    // 鼠标离开时继续
    document.querySelector('.news-ticker-wrapper').addEventListener('mouseleave', function() {
        if (pauseButton.innerHTML.includes('pause')) {
            isPaused = false;
        }
    });
    
    // 窗口大小改变时重新计算高度
    window.addEventListener('resize', function() {
        initTicker();
    });
    
    // 添加触摸滑动支持
    let touchStartY = 0;
    let touchEndY = 0;
    
    document.querySelector('.news-ticker-wrapper').addEventListener('touchstart', function(e) {
        touchStartY = e.changedTouches[0].screenY;
    }, false);
    
    document.querySelector('.news-ticker-wrapper').addEventListener('touchend', function(e) {
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        if (touchEndY < touchStartY) {
            // 向上滑动，显示下一条
            currentIndex = (currentIndex + 1) % tickerItems.length;
        } else if (touchEndY > touchStartY) {
            // 向下滑动，显示上一条
            currentIndex = (currentIndex - 1 + tickerItems.length) % tickerItems.length;
        }
        scrollToIndex(currentIndex);
        isPaused = true;
        pauseButton.innerHTML = '<i class="fas fa-play"></i>';
    }
    
    // 为每个新闻项添加动画效果
    tickerItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
});
</script> 