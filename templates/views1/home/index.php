<?php
// 首页模板
$showHotTags = true; // 告诉头部显示热门标签栏

// 处理API返回的数据
// 在实际使用时，这些数据应该由控制器传入模板
// 如果数据结构是直接从API返回的，需要以下处理
if (isset($apiResponse) && isset($apiResponse['code']) && $apiResponse['code'] == 200) {
    // 处理API直接返回的数据
    if (isset($apiResponse['data'])) {
        $apiData = $apiResponse['data'];
        
        // 热门新闻 - 如果直接传入的是API响应而不是处理后的数据
        if (isset($apiData['hotNews'])) {
            $hotNews = $apiData['hotNews'];
        }
        
        // 按分类的新闻
        if (isset($apiData['categoryNews'])) {
            $topNewsByCategory = $apiData['categoryNews'];
        }
        
        // 最新新闻
        if (isset($apiData['latestNews'])) {
            $latestNews = $apiData['latestNews'];
        }
        
        // 标签
        if (isset($apiData['tags'])) {
            $tags = $apiData['tags'];
        }
        
        // 专题
        if (isset($apiData['topics'])) {
            $hotTopics = $apiData['topics'];
        }
    }
}

// 确保变量存在，避免PHP警告
$hotNews = isset($hotNews) ? $hotNews : [];
$topNewsByCategory = isset($topNewsByCategory) ? $topNewsByCategory : [];
$latestNews = isset($latestNews) ? $latestNews : [];
$tags = isset($tags) ? $tags : [];
$hotTopics = isset($hotTopics) ? $hotTopics : [];

// 如果热门新闻是API的嵌套结构，需要进一步处理
if (isset($hotNews['code']) && $hotNews['code'] == 200 && isset($hotNews['data'])) {
    $hotNews = $hotNews['data'];
}

// 确保$hotTags存在用于顶部导航
$hotTags = $tags;
?>

<!-- 页面结构化数据 -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "<?php echo defined('SITE_NAME') ? SITE_NAME : '信息资讯网'; ?> - 首页",
    "description": "<?php echo defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '提供最新的国内外新闻、时事、社会、军事、体育、财经、科技资讯'; ?>",
    "publisher": {
        "@type": "Organization",
        "name": "<?php echo defined('SITE_NAME') ? SITE_NAME : '信息资讯网'; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "/assets/images/logo.png"
        }
    }
}
</script>

<!-- 轮播显示顶部新闻 -->
<section class="featured-slider mb-4" aria-label="热门新闻轮播">
    <div class="section-heading d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 position-relative ps-3">
            <span class="section-heading-icon bg-danger position-absolute"></span>
            热门要闻
        </h2>
        <a href="/news.php?type=hot" class="btn btn-sm btn-outline-primary">更多 <i class="fas fa-chevron-right"></i></a>
    </div>
    
    <?php if (!empty($hotNews)): ?>
    <div id="featuredCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <!-- 指示器 -->
            <div class="carousel-indicators">
                <?php foreach ($hotNews as $index => $news): ?>
                <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="<?php echo $index; ?>" 
                        <?php echo $index === 0 ? 'class="active"' : ''; ?>
                        aria-label="幻灯片 <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
            
            <!-- 轮播内容 -->
        <div class="carousel-inner rounded shadow-sm">
                <?php foreach ($hotNews as $index => $news): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" data-bs-interval="5000">
                    <div class="position-relative">
                        <img 
                            src="<?php echo isset($news['coverImage']) && !empty($news['coverImage']) ? htmlspecialchars($news['coverImage']) : '/assets/images/default-news.jpg'; ?>" 
                            class="d-block w-100" 
                            style="max-height: 450px; object-fit: cover;" 
                            alt="<?php echo htmlspecialchars($news['title']); ?>"
                            width="1200" height="450">
                            
                        <div class="news-overlay-gradient position-absolute bottom-0 start-0 w-100 p-4">
                            <?php if (isset($news['categoryName'])): ?>
                                <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                            <?php endif; ?>
                            
                            <h3 class="text-white h4 news-title-shadow">
                                <a href="/news.php?id=<?php echo $news['id']; ?>" class="text-white text-decoration-none">
                                    <?php echo htmlspecialchars($news['title']); ?>
                                </a>
                            </h3>
                            
                            <div class="text-white-50 news-meta small">
                                <?php if (isset($news['publishTime'])): ?>
                                    <span class="me-3"><i class="far fa-clock me-1"></i><?php echo date('Y-m-d', strtotime($news['publishTime'])); ?></span>
                                <?php endif; ?>
                                
                                <?php if (isset($news['viewCount'])): ?>
                                    <span><i class="far fa-eye me-1"></i><?php echo number_format($news['viewCount']); ?>人已读</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
        <!-- 控制按钮 -->
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">上一个</span>
            </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">下一个</span>
            </button>
        </div>
    <?php else: ?>
        <div class="alert alert-info">暂无热门新闻</div>
    <?php endif; ?>
</section>

<!-- 新闻聚合区域 -->
<section class="news-aggregate mb-4">
    <div class="row g-4">
        <!-- 左侧：今日头条 -->
        <div class="col-lg-6">
            <div class="section-heading d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0 position-relative ps-3">
                    <span class="section-heading-icon bg-primary position-absolute"></span>
                    今日头条
                </h2>
                <a href="/category.php?name=头条" class="btn btn-sm btn-link text-primary p-0">更多</a>
            </div>
            
            <div class="top-news-container bg-white rounded shadow-sm p-3">
                <?php 
                // 尝试获取头条类别的新闻
                $headlineNews = isset($topNewsByCategory['头条']) && is_array($topNewsByCategory['头条']) 
                             ? $topNewsByCategory['头条'] 
                             : [];
                
                // 如果没有特定的头条分类，尝试从热门新闻中提取数据
                if (empty($headlineNews) && !empty($hotNews)) {
                    $headlineNews = array_slice($hotNews, 0, 6);
                }
                
                if (!empty($headlineNews)): 
                    // 取第一条作为主要头条
                    $mainHeadline = array_shift($headlineNews);
                ?>
                    <!-- 主要头条 -->
                    <div class="main-headline mb-3">
                        <div class="row g-0">
                            <?php if (isset($mainHeadline['coverImage'])): ?>
                            <div class="col-md-5">
                                <a href="/news.php?id=<?php echo $mainHeadline['id']; ?>" class="d-block">
                                    <img src="<?php echo htmlspecialchars($mainHeadline['coverImage']); ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?php echo htmlspecialchars($mainHeadline['title']); ?>"
                                          >
                                </a>
                            </div>
                            <div class="col-md-7 ps-md-3">
                            <?php else: ?>
                            <div class="col-12">
                            <?php endif; ?>
                                <h3 class="h5 mt-3 mt-md-0">
                                    <a href="/news.php?id=<?php echo $mainHeadline['id']; ?>" class="text-dark text-decoration-none headline-link">
                                        <?php echo htmlspecialchars($mainHeadline['title']); ?>
                                    </a>
                                </h3>
                                
                                <?php if (isset($mainHeadline['summary'])): ?>
                                <p class="text-muted small mb-2"><?php echo htmlspecialchars(mb_substr($mainHeadline['summary'], 0, 120, 'UTF-8')); ?>...</p>
                                <?php endif; ?>
                                
                                <div class="news-meta small text-muted">
                                    <?php if (isset($mainHeadline['publishTime'])): ?>
                                    <span class="me-3"><i class="far fa-clock me-1"></i><?php echo date('m-d H:i', strtotime($mainHeadline['publishTime'])); ?></span>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($mainHeadline['viewCount'])): ?>
                                    <span><i class="far fa-eye me-1"></i><?php echo number_format($mainHeadline['viewCount']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 次要头条列表 -->
                    <ul class="list-unstyled sub-headlines mb-0">
                        <?php foreach (array_slice($headlineNews, 0, 5) as $subHeadline): ?>
                        <li class="border-top py-2">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="h6 mb-1">
                                        <a href="/news.php?id=<?php echo $subHeadline['id']; ?>" class="text-dark text-decoration-none sub-headline-link">
                                            <?php echo htmlspecialchars($subHeadline['title']); ?>
                                        </a>
                                    </h4>
                                    <div class="small text-muted"><?php echo date('m-d H:i', strtotime($subHeadline['publishTime'])); ?></div>
                                </div>
                                <?php if (isset($subHeadline['coverImage'])): ?>
                                <div class="col-3">
                                    <a href="/news.php?id=<?php echo $subHeadline['id']; ?>">
                                        <img src="<?php echo htmlspecialchars($subHeadline['coverImage']); ?>" 
                                             class="img-fluid rounded" 
                                             alt="<?php echo htmlspecialchars($subHeadline['title']); ?>"
                                             width="80" height="60"
                                           >
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-newspaper text-muted fa-2x mb-3"></i>
                        <p class="text-muted">暂无头条新闻</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- 右侧：推荐阅读 -->
        <div class="col-lg-6">
            <div class="section-heading d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0 position-relative ps-3">
                    <span class="section-heading-icon bg-primary position-absolute"></span>
                    推荐阅读
                </h2>
                <a href="/category.php?name=科技" class="btn btn-sm btn-link text-primary p-0">更多</a>
            </div>
            
            <div class="recommended-news-container bg-white rounded shadow-sm p-3">
                <!-- 这里使用AJAX从API动态加载数据 -->
                <div id="recommendedNewsContainer" class="row g-3">
                    <!-- 动态加载的推荐内容将显示在这里 -->
                    <div class="text-center py-3 w-100" id="recommendedNewsLoading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">加载中...</span>
                        </div>
                        <p class="text-muted small mt-2">加载推荐内容...</p>
                    </div>
                    <div class="text-center py-4 w-100 d-none" id="recommendedNewsEmpty">
                        <i class="fas fa-book-reader text-muted fa-2x mb-3"></i>
                        <p class="text-muted">暂无推荐内容</p>
                    </div>
                </div>
            </div>
            
            <!-- 网站公告模块 -->
            <div class="mt-3 p-3 bg-white rounded shadow-sm">
                <h3 class="h6 mb-2 fw-bold"><i class="fas fa-bullhorn text-danger me-2"></i>网站公告</h3>
                <p class="small mb-0 text-muted">欢迎访问我们的新闻网站！本站提供最新的国内外新闻、财经、科技、娱乐等资讯。如有问题或建议，请联系我们。</p>
            </div>
            
            <!-- 添加JavaScript代码来动态加载推荐内容 -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 获取推荐阅读的容器
                const recommendedContainer = document.getElementById('recommendedNewsContainer');
                const loadingIndicator = document.getElementById('recommendedNewsLoading');
                const emptyMessage = document.getElementById('recommendedNewsEmpty');
                
                // 组合不同类别的推荐内容
                let recommendedCategories = ['科技', '财经'];
                let loadedCategories = 0;
                let totalRecommendations = [];
                
                // 从每个分类获取内容
                recommendedCategories.forEach(function(category) {
                    fetch('/api_proxy.php?action=getNewsList&categoryName=' + encodeURIComponent(category) + '&pageSize=4')
                        .then(response => response.json())
                        .then(data => {
                            loadedCategories++;
                            
                            if (data.code === 200 && data.data && data.data.list && data.data.list.length > 0) {
                                // 将此类别的新闻添加到总推荐中
                                data.data.list.forEach(item => {
                                    item.categoryName = category; // 确保有分类名称
                                    totalRecommendations.push(item);
                                });
                            }
                            
                            // 如果所有分类都已加载完成，则渲染界面
                            if (loadedCategories === recommendedCategories.length) {
                                renderRecommendations();
                            }
                        })
                        .catch(error => {
                            console.error('加载推荐内容失败:', error);
                            loadedCategories++;
                            
                            // 处理错误情况，仍要检查是否所有分类已加载
                            if (loadedCategories === recommendedCategories.length) {
                                renderRecommendations();
                            }
                        });
                });
                
                // 渲染推荐内容
                function renderRecommendations() {
                    // 隐藏加载提示
                    loadingIndicator.classList.add('d-none');
                    
                    if (totalRecommendations.length === 0) {
                        // 如果没有内容，显示空消息
                        emptyMessage.classList.remove('d-none');
                        return;
                    }
                    
                    // 按照一定规则排序（这里简单按发布时间排序）
                    totalRecommendations.sort((a, b) => {
                        return new Date(b.publishTime) - new Date(a.publishTime);
                    });
                    
                    // 只显示前4条推荐内容
                    const displayRecommendations = totalRecommendations.slice(0, 4);
                    
                    // 创建HTML
                    displayRecommendations.forEach((news, index) => {
                        const newsItem = document.createElement('div');
                        newsItem.className = 'col-12';
                        newsItem.innerHTML = `
                            <div class="recommended-item d-flex">
                                ${news.coverImage ? 
                                  `<div class="flex-shrink-0 me-3">
                                      <img src="${news.coverImage}" 
                                           class="recommended-img rounded" 
                                           alt="${news.title}"
                                           width="100" height="75"
                                           style="object-fit: cover;">
                                   </div>` : 
                                  `<div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center bg-light rounded" style="width:100px;height:75px;">
                                      <i class="fas fa-newspaper text-secondary fa-2x"></i>
                                   </div>`
                                }
                                <div class="flex-grow-1">
                                    <h4 class="h6 mb-1">
                                        <a href="/news.php?id=${news.id}" class="text-dark fw-bold text-decoration-none recommended-title">
                                            ${news.title}
                                        </a>
                                    </h4>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small text-muted">
                                            <span class="badge bg-secondary me-1">${news.categoryName}</span>
                                            <span><i class="far fa-calendar-alt me-1"></i>${new Date(news.publishTime).toLocaleDateString('zh-CN', {month: '2-digit', day: '2-digit'})}</span>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="far fa-eye me-1"></i>${news.viewCount.toLocaleString()}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${index < displayRecommendations.length - 1 ? '<hr class="my-2">' : ''}
                        `;
                        recommendedContainer.appendChild(newsItem);
                    });
                }
            });
            </script>
        </div>
    </div>
</section>

<!-- 分类新闻展示区 -->
<section class="category-news-section mb-5">
    <ul class="nav nav-tabs nav-fill mb-4" id="categoryTab" role="tablist">
        <?php 
        // 如果已经有分类列表，使用已有的
        $categoryList = isset($categories) ? $categories : ['国内', '国际', '军事', '财经', '科技'];
        
        // 确保有可显示的分类
        $displayCategories = [];
        foreach ($categoryList as $catItem) {
            // 如果是数组格式（API可能返回的格式）
            if (is_array($catItem) && isset($catItem['name'])) {
                $catName = $catItem['name'];
            } else {
                $catName = $catItem;
            }
            
            // 只显示有新闻的分类
            if (isset($topNewsByCategory[$catName]) && !empty($topNewsByCategory[$catName])) {
                $displayCategories[] = $catName;
            }
        }
        
        // 如果没有分类有新闻，显示默认分类
        if (empty($displayCategories)) {
            $displayCategories = ['国内', '国际', '军事', '财经', '科技'];
        }
        
        foreach ($displayCategories as $index => $categoryName): 
        ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                    id="<?php echo $categoryName; ?>-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#<?php echo $categoryName; ?>-content" 
                    type="button" role="tab" 
                    aria-controls="<?php echo $categoryName; ?>-content" 
                    aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                <?php echo $categoryName; ?>
            </button>
        </li>
        <?php endforeach; ?>
    </ul>
    
    <div class="tab-content" id="categoryTabContent">
        <?php foreach ($displayCategories as $index => $categoryName): ?>
        <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" 
             id="<?php echo $categoryName; ?>-content" 
             role="tabpanel" 
             aria-labelledby="<?php echo $categoryName; ?>-tab">
            
            <?php 
            $categoryNews = isset($topNewsByCategory[$categoryName]) && is_array($topNewsByCategory[$categoryName]) 
                          ? $topNewsByCategory[$categoryName] 
                          : [];
            
            // 如果该分类没有新闻但有加载方法，添加加载逻辑
            if (empty($categoryNews)): 
            ?>
                <div class="text-center py-5" id="loadingIndicator-<?php echo $categoryName; ?>">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">加载中...</span>
                    </div>
                    <p class="mt-2 text-muted">正在加载<?php echo $categoryName; ?>分类的新闻...</p>
                </div>
                
                <div class="alert alert-info d-none" id="noNewsMessage-<?php echo $categoryName; ?>">
                    暂无<?php echo $categoryName; ?>分类的新闻
                </div>
                
                <div class="row g-4 d-none" id="categoryNewsContainer-<?php echo $categoryName; ?>"></div>
        
        <script>
                // 加载分类新闻的函数
            document.addEventListener('DOMContentLoaded', function() {
                    loadCategoryNews('<?php echo $categoryName; ?>');
                });
                
                function loadCategoryNews(categoryName) {
                    const loadingIndicator = document.getElementById('loadingIndicator-' + categoryName);
                    const noNewsMessage = document.getElementById('noNewsMessage-' + categoryName);
                    const container = document.getElementById('categoryNewsContainer-' + categoryName);
                    
                    // 隐藏加载指示器
                    if (loadingIndicator) {
                        loadingIndicator.classList.add('d-none');
                    }
                    
                    // 使用代理请求获取数据
                    fetch('/api_proxy.php?action=getNewsList&categoryName=' + encodeURIComponent(categoryName) + '&pageSize=4')
                        .then(response => response.json())
                        .then(data => {
                            if (data.code === 200 && data.data && data.data.list && data.data.list.length > 0) {
                                // 显示新闻容器
                                container.classList.remove('d-none');
                                
                                // 渲染新闻卡片
                                data.data.list.forEach(news => {
                                    const newsCard = document.createElement('div');
                                    newsCard.className = 'col-md-6 col-lg-3';
                                    newsCard.innerHTML = `
                                        <div class="card h-100 news-card shadow-sm">
                                            <div class="position-relative">
                                                <img src="${news.coverImage || '/assets/images/default-news.jpg'}" 
                                                     class="card-img-top" style="height: 160px; object-fit: cover;" 
                                                     alt="${news.title}"
                                                    >
                                                <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                                    ${categoryName}
                                                </span>
    </div>
        <div class="card-body">
                                                <h3 class="card-title h6">
                                                    <a href="/news.php?id=${news.id}" class="text-dark text-decoration-none stretched-link">
                                                        ${news.title}
                                                    </a>
                                                </h3>
                                                <div class="card-text small text-muted">
                                                    <i class="far fa-clock me-1"></i>${new Date(news.publishTime).toLocaleDateString()}
                                                    <span class="ms-2"><i class="far fa-eye me-1"></i>${news.viewCount}</span>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    container.appendChild(newsCard);
                                });
                                
                                // 添加"查看更多"按钮
                                const moreButtonContainer = document.createElement('div');
                                moreButtonContainer.className = 'text-center mt-4';
                                moreButtonContainer.innerHTML = `
                                    <a href="/category.php?name=${encodeURIComponent(categoryName)}" class="btn btn-outline-primary btn-sm">
                                        查看更多${categoryName}新闻 <i class="fas fa-angle-right ms-1"></i>
                                    </a>
                                `;
                                container.parentNode.appendChild(moreButtonContainer);
                            } else {
                                // 显示无新闻消息
                                if (noNewsMessage) {
                                    noNewsMessage.classList.remove('d-none');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('加载分类新闻失败:', error);
                            if (loadingIndicator) {
                                loadingIndicator.classList.add('d-none');
                            }
                            if (noNewsMessage) {
                                noNewsMessage.classList.remove('d-none');
                            }
                        });
                }
                </script>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach (array_slice($categoryNews, 0, 4) as $news): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 news-card shadow-sm">
                            <div class="position-relative">
                                <img src="<?php echo isset($news['coverImage']) ? htmlspecialchars($news['coverImage']) : '/assets/images/default-news.jpg'; ?>" 
                                     class="card-img-top" style="height: 160px; object-fit: cover;" 
                                     alt="<?php echo htmlspecialchars($news['title']); ?>"
                                     >
                                <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                    <?php echo htmlspecialchars($categoryName); ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title h6">
                                    <a href="/news.php?id=<?php echo $news['id']; ?>" class="text-dark text-decoration-none stretched-link">
                                        <?php echo htmlspecialchars($news['title']); ?>
                                    </a>
                                </h3>
                                <div class="card-text small text-muted">
                                    <i class="far fa-clock me-1"></i><?php echo date('m-d', strtotime($news['publishTime'])); ?>
                                    <span class="ms-2"><i class="far fa-eye me-1"></i><?php echo number_format($news['viewCount']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-4">
                    <a href="/category.php?name=<?php echo urlencode($categoryName); ?>" class="btn btn-outline-primary btn-sm">
                        查看更多<?php echo $categoryName; ?>新闻 <i class="fas fa-angle-right ms-1"></i>
                    </a>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>

 

<style>
/* 首页特有样式 */
.news-overlay-gradient {
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%);
    height: 60%;
}

.news-title-shadow {
    text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
}

.section-heading-icon {
    width: 4px;
    height: 18px;
    top: 3px;
    left: 0;
    border-radius: 2px;
}

.headline-link:hover, .sub-headline-link:hover {
    color: var(--primary-color, #2766d8) !important;
    text-decoration: underline !important;
}

.news-card {
    transition: transform 0.3s ease;
}

.news-card:hover {
    transform: translateY(-5px);
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
}

.nav-tabs .nav-link {
    color: var(--text-primary);
    border: none;
    border-bottom: 2px solid transparent;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
}

.nav-tabs .nav-link:hover:not(.active) {
    border-bottom: 2px solid var(--border-color);
}

@media (max-width: 767px) {
    .carousel-caption h3 {
        font-size: 1.2rem;
    }
    
    .carousel-indicators {
        margin-bottom: 0.5rem;
    }
}
</style>

<!-- AJAX请求辅助函数 -->
<script>
// 通过API加载数据的通用函数
function fetchApiData(action, params, callback) {
    // 构建请求URL
    let url = '/api_proxy.php?action=' + action;
    for (let key in params) {
        url += '&' + key + '=' + encodeURIComponent(params[key]);
    }
    
    // 发送请求
        fetch(url)
        .then(response => response.json())
            .then(data => {
            if (data.code === 200) {
                callback(data.data);
                } else {
                console.error('API错误:', data.message);
                callback(null);
                }
            })
            .catch(error => {
            console.error('请求失败:', error);
            callback(null);
        });
}

// 首页特定JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // 轮播初始化已在carousel-fix.js中处理
    
    // 初始化分类标签页
    var categoryTabs = document.querySelectorAll('#categoryTab button');
    categoryTabs.forEach(function(tab) {
        tab.addEventListener('click', function(event) {
            const categoryName = this.textContent.trim();
            const contentId = this.getAttribute('data-bs-target').substring(1);
            const contentContainer = document.getElementById(contentId);
            
            // 如果内容区域为空，尝试加载数据
            if (contentContainer && contentContainer.querySelector('.row')?.children.length === 0) {
                // 可以在此处添加其他动态加载逻辑
            }
        });
    });
});
</script> 