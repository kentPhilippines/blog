<?php
// 包含特色新闻部分
include 'views/home/featured.php';

// 包含分类新闻部分
include 'views/home/category_news.php';
?>

<!-- 首页装饰色彩块 -->
<div class="home-decoration">
    <div class="color-circle circle-1"></div>
    <div class="color-circle circle-2"></div>
    <div class="color-circle circle-3"></div>
</div>

<div class="row">
    <div class="col-12">
        <div class="section-header mb-4">
            <h2 class="section-title">
                <i class="fas fa-fire text-danger me-2"></i>热门新闻
                <small class="text-muted ms-2">HOT NEWS</small>
            </h2>
        </div>
    </div>
</div>

<!-- 分类标签 -->
<div class="row mb-4">
    <div class="col-12">
        <ul class="nav nav-pills category-tabs" id="categoryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all-content" type="button" role="tab" aria-controls="all-content" aria-selected="true">
                    <i class="fas fa-globe me-1"></i>全部
                </button>
            </li>
            <?php foreach ($displayCategories as $index => $category): 
                $catName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
            ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="<?php echo 'cat-' . $index; ?>-tab" data-bs-toggle="pill" data-bs-target="#<?php echo 'cat-' . $index; ?>-content" type="button" role="tab" aria-controls="<?php echo 'cat-' . $index; ?>-content" aria-selected="false">
                    <i class="fas fa-folder me-1"></i><?php echo htmlspecialchars($catName); ?>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- 分类内容 -->
<div class="tab-content" id="categoryTabsContent">
    <!-- 全部新闻 -->
    <div class="tab-pane fade show active" id="all-content" role="tabpanel" aria-labelledby="all-tab">
        <div class="row g-4">
            <?php if (!empty($newsList)): ?>
                <?php 
                // 获取第一条新闻作为主要新闻
                $mainNews = $newsList[0];
                // 其余新闻作为次要新闻
                $subNewsList = array_slice($newsList, 1, 7);
                ?>
                
                <!-- 主要新闻 -->
                <div class="col-lg-8">
                    <div class="card main-news-card h-100">
                        <?php if (isset($mainNews['coverImage'])): ?>
                        <div class="main-news-image-container">
                            <img src="<?php echo htmlspecialchars($mainNews['coverImage']); ?>" class="card-img-top main-news-image" alt="<?php echo htmlspecialchars($mainNews['title']); ?>">
                            <?php if (isset($mainNews['categoryName'])): ?>
                            <span class="category-badge"><?php echo htmlspecialchars($mainNews['categoryName']); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="/news.php?id=<?php echo $mainNews['id']; ?>" class="text-decoration-none">
                                    <?php echo htmlspecialchars($mainNews['title']); ?>
                                </a>
                            </h3>
                            <?php if (isset($mainNews['summary'])): ?>
                            <p class="card-text"><?php echo htmlspecialchars($mainNews['summary']); ?></p>
                            <?php endif; ?>
                            <div class="news-meta">
                                <?php if (isset($mainNews['publishTime'])): ?>
                                <span class="news-time"><i class="far fa-clock"></i> <?php echo date('Y-m-d H:i', strtotime($mainNews['publishTime'])); ?></span>
                                <?php endif; ?>
                                <?php if (isset($mainNews['viewCount'])): ?>
                                <span class="news-views"><i class="far fa-eye"></i> <?php echo number_format($mainNews['viewCount']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 次要新闻列表 -->
                <div class="col-lg-4">
                    <div class="sub-news-list">
                        <?php foreach ($subNewsList as $news): ?>
                        <div class="card sub-news-card mb-3">
                            <div class="row g-0">
                                <?php if (isset($news['coverImage'])): ?>
                                <div class="col-4">
                                    <div class="sub-news-image-container">
                                        <img src="<?php echo htmlspecialchars($news['coverImage']); ?>" class="img-fluid sub-news-image" alt="<?php echo htmlspecialchars($news['title']); ?>">
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="<?php echo isset($news['coverImage']) ? 'col-8' : 'col-12'; ?>">
                                    <div class="card-body py-2">
                                        <h5 class="card-title small">
                                            <a href="/news.php?id=<?php echo $news['id']; ?>" class="text-decoration-none">
                                                <?php echo htmlspecialchars($news['title']); ?>
                                            </a>
                                        </h5>
                                        <div class="news-meta small">
                                            <?php if (isset($news['categoryName'])): ?>
                                            <span class="news-category"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                                            <?php endif; ?>
                                            <?php if (isset($news['publishTime'])): ?>
                                            <span class="news-time"><i class="far fa-clock"></i> <?php echo date('m-d', strtotime($news['publishTime'])); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">暂无新闻数据</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- 分类新闻 -->
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
            <a href="/category.php?name=<?php echo urlencode($catName); ?>" class="btn btn-primary">
                <i class="fas fa-list me-1"></i>查看更多<?php echo htmlspecialchars($catName); ?>新闻
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="section-header mb-4">
            <h2 class="section-title">
                <i class="fas fa-newspaper text-primary me-2"></i>最新资讯
                <small class="text-muted ms-2">LATEST NEWS</small>
            </h2>
        </div>
    </div>
</div>

<div class="row g-4 news-grid">
    <?php 
    // 显示剩余的新闻
    $remainingNews = array_slice($newsList, 8, 12);
    foreach ($remainingNews as $news): 
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card news-grid-card h-100">
            <?php if (isset($news['coverImage'])): ?>
            <div class="news-grid-image-container">
                <img src="<?php echo htmlspecialchars($news['coverImage']); ?>" class="card-img-top news-grid-image" alt="<?php echo htmlspecialchars($news['title']); ?>">
                <?php if (isset($news['categoryName'])): ?>
                <span class="category-badge"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/news.php?id=<?php echo $news['id']; ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($news['title']); ?>
                    </a>
                </h5>
                <?php if (isset($news['summary'])): ?>
                <p class="card-text small d-none d-md-block"><?php echo htmlspecialchars(mb_substr($news['summary'], 0, 60, 'UTF-8')); ?><?php echo (mb_strlen($news['summary'], 'UTF-8') > 60) ? '...' : ''; ?></p>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <div class="news-meta">
                    <?php if (isset($news['publishTime'])): ?>
                    <span class="news-time"><i class="far fa-clock"></i> <?php echo date('Y-m-d', strtotime($news['publishTime'])); ?></span>
                    <?php endif; ?>
                    <?php if (isset($news['viewCount'])): ?>
                    <span class="news-views"><i class="far fa-eye"></i> <?php echo number_format($news['viewCount']); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if ($totalPages > 1): ?>
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Page navigation">
            <?php echo $pagination; ?>
        </nav>
    </div>
</div>
<?php endif; ?>

<style>
/* 首页特有样式 */
.home-decoration {
    position: relative;
    overflow: hidden;
    height: 0;
}

.color-circle {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    z-index: -1;
    opacity: 0.1;
}

.circle-1 {
    width: 300px;
    height: 300px;
    background: var(--primary-color);
    top: 10%;
    left: 5%;
}

.circle-2 {
    width: 400px;
    height: 400px;
    background: var(--secondary-color);
    bottom: 10%;
    right: 5%;
}

.circle-3 {
    width: 250px;
    height: 250px;
    background: #ff4081;
    top: 40%;
    right: 30%;
}

.section-title {
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-weight: 700;
    color: var(--text-primary);
}

.section-title:after {
    content: '';
    position: absolute;
    width: 60px;
    height: 3px;
    background: var(--secondary-color);
    bottom: 0;
    left: 0;
}

.section-title small {
    font-size: 0.5em;
    font-weight: 400;
    letter-spacing: 2px;
}

.category-tabs {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 10px;
}

.category-tabs .nav-link {
    color: var(--text-secondary);
    border-radius: 20px;
    padding: 8px 16px;
    margin-right: 8px;
    margin-bottom: 8px;
    background-color: rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.category-tabs .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
}

.category-tabs .nav-link.active {
    background-color: var(--primary-color);
    color: white;
}

.main-news-card {
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.main-news-card:hover {
    transform: translateY(-5px);
}

.main-news-image-container {
    position: relative;
    height: 350px;
    overflow: hidden;
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

.sub-news-card {
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.sub-news-card:hover {
    transform: translateX(5px);
}

.sub-news-image-container {
    height: 80px;
    overflow: hidden;
}

.sub-news-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-grid-card {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.news-grid-card:hover {
    transform: translateY(-5px);
}

.news-grid-image-container {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.news-grid-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.news-grid-card:hover .news-grid-image {
    transform: scale(1.05);
}

.category-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: var(--primary-color);
    color: white;
    padding: 3px 10px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
    z-index: 2;
}

.news-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.news-category {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 3px;
    background-color: var(--primary-color);
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
        opacity: 0.05;
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
    
    // 动态加载分类新闻的函数
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