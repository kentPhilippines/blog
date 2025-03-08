<?php
// 包含特色新闻部分
include 'views/home/featured.php';

// 包含分类新闻部分
include 'views/home/category_news.php';
?>

<!-- 首页装饰色彩块 -->
<div class="home-decoration">
    <div class="color-circle color-circle-1"></div>
    <div class="color-circle color-circle-2"></div>
    <div class="color-circle color-circle-3"></div>
    <div class="color-circle color-circle-4"></div>
</div>

<div class="container animate-fade-in">
    <!-- 头条新闻 -->
    <?php if (!empty($hotNews)): ?>
    <div class="featured-news mb-5">
        <div class="section-header">
            <h2 class="section-title">头条新闻</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="row g-4">
            <?php 
            // 获取第一条热门新闻作为主要新闻
            $mainNews = array_shift($hotNews); 
            ?>
            <div class="col-lg-7 col-md-12">
                <div class="card main-news-card h-100">
                    <?php if (isset($mainNews['coverImage']) && !empty($mainNews['coverImage'])): ?>
                    <div class="main-news-image-container">
                        <img src="<?php echo $mainNews['coverImage']; ?>" class="card-img-top main-news-image" alt="<?php echo isset($mainNews['title']) ? htmlspecialchars($mainNews['title']) : '无标题'; ?>">
                        <?php if (isset($mainNews['categoryName'])): ?>
                        <span class="news-category-badge"><?php echo htmlspecialchars($mainNews['categoryName']); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="/news.php?id=<?php echo isset($mainNews['id']) ? $mainNews['id'] : 0; ?>" class="text-decoration-none">
                                <?php echo isset($mainNews['title']) ? htmlspecialchars($mainNews['title']) : '无标题'; ?>
                            </a>
                        </h3>
                        <p class="card-text"><?php echo isset($mainNews['summary']) ? htmlspecialchars($mainNews['summary']) : '暂无摘要'; ?></p>
                        <div class="news-meta">
                            <span class="news-time"><i class="far fa-clock"></i> <?php echo isset($mainNews['publishTime']) ? Utils::getRelativeTime($mainNews['publishTime']) : '未知时间'; ?></span>
                            <span class="news-views"><i class="far fa-eye"></i> <?php echo isset($mainNews['viewCount']) ? $mainNews['viewCount'] : 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-12">
                <div class="sub-news-list">
                    <?php foreach (array_slice($hotNews, 0, 3) as $index => $news): ?>
                    <div class="card sub-news-card mb-3">
                        <div class="row g-0">
                            <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                            <div class="col-4">
                                <div class="sub-news-image-container">
                                    <img src="<?php echo $news['coverImage']; ?>" class="img-fluid sub-news-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                                </div>
                            </div>
                            <div class="col-8">
                            <?php else: ?>
                            <div class="col-12">
                            <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none">
                                            <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                        </a>
                                    </h5>
                                    <div class="news-meta">
                                        <?php if (isset($news['categoryName'])): ?>
                                        <span class="news-category"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                                        <?php endif; ?>
                                        <span class="news-time"><i class="far fa-clock"></i> <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- 新闻类型选择 -->
    <div class="category-filter mb-5">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h2 class="section-title">新闻分类</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="category-tabs">
            <div class="category-tabs-container">
                <ul class="nav nav-pills category-nav" id="categoryTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all-content" type="button" role="tab" aria-controls="all-content" aria-selected="true">
                            全部
                        </button>
                    </li>
                    <?php 
                    // 限制显示的分类数量
                    $displayCategories = array_slice($categories, 0, 8);
                    foreach ($displayCategories as $index => $category): 
                        $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
                        $catCount = is_array($category) && isset($category['newsCount']) ? $category['newsCount'] : 0;
                    ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="<?php echo 'cat-' . $index; ?>-tab" data-bs-toggle="pill" data-bs-target="#<?php echo 'cat-' . $index; ?>-content" type="button" role="tab" aria-controls="<?php echo 'cat-' . $index; ?>-content" aria-selected="false">
                            <?php echo htmlspecialchars($catName); ?>
                            <?php if ($catCount > 0): ?>
                            <span class="badge rounded-pill bg-primary"><?php echo $catCount; ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="tab-content mt-4" id="categoryTabsContent">
                <div class="tab-pane fade show active" id="all-content" role="tabpanel" aria-labelledby="all-tab">
                    <!-- 全部新闻内容 -->
                    <div class="row g-4">
                        <?php foreach (array_slice($newsList, 0, 8) as $index => $news): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card category-news-card h-100">
                                <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                <div class="category-news-image-container">
                                    <img src="<?php echo $news['coverImage']; ?>" class="card-img-top category-news-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                                    <?php if (isset($news['categoryName'])): ?>
                                    <span class="category-badge"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none">
                                            <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                        </a>
                                    </h5>
                                    <p class="card-text small"><?php echo isset($news['summary']) ? Utils::truncateText($news['summary'], 60) : '暂无摘要'; ?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="news-meta">
                                        <span class="news-time"><i class="far fa-clock"></i> <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?></span>
                                        <span class="news-views"><i class="far fa-eye"></i> <?php echo isset($news['viewCount']) ? $news['viewCount'] : 0; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-4">
                        <a href="/news.php" class="btn btn-primary">查看更多新闻</a>
                    </div>
                </div>
                
                <?php foreach ($displayCategories as $index => $category): 
                    $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
                    
                    // 筛选该分类下的新闻
                    $categoryNews = array_filter($newsList, function($news) use ($catName) {
                        return isset($news['categoryName']) && $news['categoryName'] == $catName;
                    });
                    
                    // 最多显示8条
                    $categoryNews = array_slice($categoryNews, 0, 8);
                ?>
                <div class="tab-pane fade" id="<?php echo 'cat-' . $index; ?>-content" role="tabpanel" aria-labelledby="<?php echo 'cat-' . $index; ?>-tab">
                    <!-- <?php echo htmlspecialchars($catName); ?>分类新闻内容 -->
                    <div class="category-news-container" data-category="<?php echo htmlspecialchars($catName); ?>">
                        <div class="text-center my-5 loading-spinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">加载中...</span>
                            </div>
                            <p class="mt-2">正在加载<?php echo htmlspecialchars($catName); ?>分类新闻...</p>
                        </div>
                        <div class="category-news-content row g-4" style="display: none;"></div>
                        <div class="alert alert-danger error-message" style="display: none;">
                            加载新闻失败，请稍后重试。
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="/category.php?name=<?php echo urlencode($catName); ?>" class="btn btn-primary">查看更多<?php echo htmlspecialchars($catName); ?>新闻</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- 最新新闻列表 -->
    <div class="latest-news mb-5">
        <div class="section-header">
            <h2 class="section-title">最新资讯</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($newsList as $index => $news): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card news-grid-card h-100">
                    <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                    <div class="news-grid-image-container">
                        <img src="<?php echo $news['coverImage']; ?>" class="card-img-top news-grid-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                        <?php if (isset($news['categoryName'])): ?>
                        <span class="news-category-badge"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none">
                                <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                            </a>
                        </h5>
                        <p class="card-text small"><?php echo isset($news['summary']) ? Utils::truncateText($news['summary'], 60) : '暂无摘要'; ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="news-meta">
                            <span class="news-time"><i class="far fa-clock"></i> <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?></span>
                            <span class="news-views"><i class="far fa-eye"></i> <?php echo isset($news['viewCount']) ? $news['viewCount'] : 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- 分页 -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination-container mt-5">
            <?php echo $pagination; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* 首页装饰 */
.home-decoration {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: -1;
}

.color-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.05;
}

.color-circle-1 {
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, #3498db, #9b59b6);
    top: -100px;
    left: -100px;
}

.color-circle-2 {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #e74c3c, #f39c12);
    bottom: 10%;
    right: -50px;
}

.color-circle-3 {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #2ecc71, #1abc9c);
    top: 30%;
    right: 20%;
}

.color-circle-4 {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, #f39c12, #d35400);
    bottom: 20%;
    left: 10%;
}

/* 头条新闻样式 */
.main-news-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.main-news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.main-news-image-container {
    position: relative;
    overflow: hidden;
    height: 300px;
}

.main-news-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.main-news-card:hover .main-news-image {
    transform: scale(1.05);
}

.news-category-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(to right, #3498db, #2980b9);
    color: white;
    padding: 5px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

/* 次要新闻样式 */
.sub-news-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.sub-news-card:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.sub-news-image-container {
    height: 100%;
    overflow: hidden;
}

.sub-news-image {
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.sub-news-card:hover .sub-news-image {
    transform: scale(1.1);
}

/* 网格新闻样式 */
.news-grid-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.news-grid-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.news-grid-image-container {
    position: relative;
    overflow: hidden;
    height: 180px;
}

.news-grid-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.news-grid-card:hover .news-grid-image {
    transform: scale(1.1);
}

.news-grid-card .card-footer {
    background-color: transparent;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 0.75rem 1.25rem;
}

/* 新闻元数据 */
.news-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    font-size: 0.8rem;
    color: #95a5a6;
}

.news-category {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 3px;
    background-color: #3498db;
    color: white;
    font-weight: 500;
}

/* 响应式调整 */
@media (max-width: 767.98px) {
    .main-news-image-container {
        height: 200px;
    }
    
    .news-grid-image-container {
        height: 150px;
    }
    
    .color-circle {
        opacity: 0.03;
    }
}
</style>

<script>
// 分类新闻加载
document.addEventListener('DOMContentLoaded', function() {
    console.log('页面加载完成，初始化分类新闻加载功能');
    
    // 监听分类标签点击事件
    const categoryTabs = document.querySelectorAll('[data-bs-toggle="pill"]');
    categoryTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(event) {
            const targetId = event.target.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);
            console.log('分类标签点击:', event.target.textContent.trim(), '目标ID:', targetId);
            
            // 如果不是"全部"标签，且内容区域包含category-news-container
            if (targetId !== '#all-content' && targetPane) {
                const container = targetPane.querySelector('.category-news-container');
                if (container && !container.dataset.loaded) {
                    console.log('开始加载分类新闻:', container.dataset.category);
                    loadCategoryNews(container);
                } else if (container && container.dataset.loaded) {
                    console.log('该分类新闻已加载:', container.dataset.category);
                }
            }
        });
    });
    
    // 加载分类新闻
    function loadCategoryNews(container) {
        const category = container.dataset.category;
        const spinner = container.querySelector('.loading-spinner');
        const content = container.querySelector('.category-news-content');
        const errorMsg = container.querySelector('.error-message');
        
        console.log('加载分类新闻:', category);
        
        // 显示加载中
        spinner.style.display = 'block';
        content.style.display = 'none';
        errorMsg.style.display = 'none';
        
        // 构建请求URL
        const url = `/api_proxy.php?action=getNewsList&categoryName=${encodeURIComponent(category)}&pageSize=5`;
        console.log('发送AJAX请求:', url);
        
        // 发送AJAX请求
        fetch(url)
            .then(response => {
                console.log('收到响应:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error('网络响应不正常: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('解析响应数据:', data);
                
                // 标记为已加载
                container.dataset.loaded = 'true';
                
                // 隐藏加载中
                spinner.style.display = 'none';
                
                if (data.code === 200 && data.data && data.data.list && data.data.list.length > 0) {
                    console.log(`成功获取${category}分类新闻，共${data.data.list.length}条`);
                    // 渲染新闻列表
                    renderCategoryNews(content, data.data.list, category);
                    content.style.display = 'flex';
                } else {
                    console.log(`${category}分类没有新闻数据`);
                    // 显示无数据提示
                    content.innerHTML = `<div class="col-12"><div class="alert alert-info">暂无${category}分类的新闻</div></div>`;
                    content.style.display = 'flex';
                }
            })
            .catch(error => {
                console.error('获取分类新闻失败:', error);
                spinner.style.display = 'none';
                errorMsg.style.display = 'block';
                errorMsg.textContent = `加载新闻失败: ${error.message}`;
            });
    }
    
    // 手动触发第一个分类标签的点击事件（除了"全部"标签）
    setTimeout(() => {
        const firstCategoryTab = document.querySelector('#categoryTabs .nav-link:not(.active):not(#all-tab)');
        if (firstCategoryTab) {
            console.log('自动触发第一个分类标签点击:', firstCategoryTab.textContent.trim());
            firstCategoryTab.click();
        }
    }, 1000);
    
    // 渲染分类新闻
    function renderCategoryNews(container, newsList, category) {
        container.innerHTML = '';
        
        newsList.forEach(news => {
            const newsCard = document.createElement('div');
            newsCard.className = 'col-lg-3 col-md-4 col-sm-6';
            
            let coverHtml = '';
            if (news.coverImage) {
                coverHtml = `
                    <div class="category-news-image-container">
                        <img src="${news.coverImage}" class="card-img-top category-news-image" alt="${news.title || '无标题'}">
                        <span class="category-badge">${category}</span>
                    </div>
                `;
            }
            
            const title = news.title || '无标题';
            const summary = news.summary ? truncateText(news.summary, 60) : '暂无摘要';
            const publishTime = news.publishTime ? getRelativeTime(news.publishTime) : '未知时间';
            const viewCount = news.viewCount || 0;
            
            newsCard.innerHTML = `
                <div class="card category-news-card h-100">
                    ${coverHtml}
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/news.php?id=${news.id || 0}" class="text-decoration-none">
                                ${title}
                            </a>
                        </h5>
                        <p class="card-text small">${summary}</p>
                    </div>
                    <div class="card-footer">
                        <div class="news-meta">
                            <span class="news-time"><i class="far fa-clock"></i> ${publishTime}</span>
                            <span class="news-views"><i class="far fa-eye"></i> ${viewCount}</span>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(newsCard);
        });
    }
    
    // 辅助函数：截断文本
    function truncateText(text, length) {
        if (text.length <= length) return text;
        return text.substring(0, length) + '...';
    }
    
    // 辅助函数：获取相对时间
    function getRelativeTime(timestamp) {
        const now = new Date();
        const date = new Date(timestamp * 1000);
        const diff = Math.floor((now - date) / 1000);
        
        if (diff < 60) return '刚刚';
        if (diff < 3600) return Math.floor(diff / 60) + '分钟前';
        if (diff < 86400) return Math.floor(diff / 3600) + '小时前';
        if (diff < 2592000) return Math.floor(diff / 86400) + '天前';
        
        return date.getFullYear() + '-' + 
               ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
               ('0' + date.getDate()).slice(-2);
    }
});
</script> 