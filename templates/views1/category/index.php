<?php
// 分类页面模板 - 强制从URL获取分类名称
$url_category_name = isset($_GET['name']) ? $_GET['name'] : '未知分类';

// 调试信息
$debug = isset($_GET['debug']) && $_GET['debug'] == 1;
if ($debug) {
    echo '<div class="alert alert-info">';
    echo '<p><strong>URL请求参数:</strong> ' . htmlspecialchars($_SERVER['QUERY_STRING']) . '</p>';
    echo '<p><strong>URL分类名称:</strong> ' . htmlspecialchars($url_category_name) . '</p>';
    echo '<p><strong>变量分类名称:</strong> ' . htmlspecialchars($categoryName) . '</p>';
    echo '</div>';
}

// 强制使用URL参数作为分类名称，覆盖可能被修改的分类名称变量
$categoryName = $url_category_name;
?>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-8">
            <!-- 分类标题和描述 -->
            <div class="category-header mb-4 pb-2 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="category-title"><?php echo htmlspecialchars($url_category_name); ?></h1>
                    <p class="text-muted mt-2">
                        <i class="fas fa-newspaper me-2"></i>共 <?php echo isset($totalItems) ? number_format($totalItems) : 0; ?> 篇文章
                    </p>
                </div>
                <!-- 布局切换按钮 -->
                <div class="view-controls">
                    <div class="btn-group" role="group" aria-label="布局切换">
                        <button type="button" class="btn btn-outline-primary btn-sm view-btn" data-view="list">
                            <i class="fas fa-list me-1"></i>列表
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm view-btn" data-view="grid">
                            <i class="fas fa-th-large me-1"></i>卡片
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- 调试信息 -->
            <?php if ($debug): ?>
            <div class="alert alert-info">
                <p><strong>当前分类:</strong> <?php echo htmlspecialchars($url_category_name); ?></p>
                <p><strong>请求URL:</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></p>
                <p><strong>新闻列表数量:</strong> <?php echo count($newsList); ?></p>
            </div>
            <?php endif; ?>
            
            <!-- 新闻列表 -->
            <?php if (empty($newsList)): ?>
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-muted"></i>
                    <p class="mb-0">暂无符合条件的新闻，请稍后再来查看。</p>
                </div>
            <?php else: ?>
                <!-- 列表视图容器 -->
                <div id="list-view" class="news-container">
                    <?php foreach ($newsList as $news): ?>
                        <div class="card mb-4 news-card shadow-sm border-0 overflow-hidden">
                            <div class="row g-0">
                                <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                    <div class="col-md-4 position-relative">
                                        <img src="<?php echo $news['coverImage']; ?>" class="img-fluid rounded-start h-100 news-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>" loading="lazy" style="object-fit: cover;">
                                        <?php if (isset($news['isHot']) && $news['isHot']): ?>
                                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                                <i class="fas fa-fire me-1"></i>热门
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8">
                                <?php else: ?>
                                    <div class="col-md-12">
                                <?php endif; ?>
                                    <div class="card-body d-flex flex-column h-100 py-3">
                                        <h5 class="card-title mb-2">
                                            <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none text-dark title-link">
                                                <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                            </a>
                                        </h5>
                                        <p class="card-text text-secondary"><?php echo isset($news['summary']) ? htmlspecialchars(mb_substr($news['summary'], 0, 100, 'UTF-8')) . (mb_strlen($news['summary'], 'UTF-8') > 100 ? '...' : '') : '暂无摘要'; ?></p>
                                        
                                        <div class="news-meta text-muted mt-auto d-flex justify-content-between align-items-center pt-2 small">
                                            <div>
                                                <span class="me-3"><i class="far fa-clock me-1"></i> <?php echo isset($news['publishTime']) ? date('Y-m-d', strtotime($news['publishTime'])) : '未知时间'; ?></span>
                                                <span><i class="far fa-eye me-1"></i> <?php echo isset($news['viewCount']) ? number_format($news['viewCount']) : 0; ?>次阅读</span>
                                            </div>
                                            <?php if (isset($news['author']) && !empty($news['author'])): ?>
                                                <div class="author-info">
                                                    <i class="far fa-user me-1"></i> <?php echo htmlspecialchars($news['author']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- 方块布局容器 -->
                <div id="grid-view" class="news-container" style="display: none;">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($newsList as $news): ?>
                            <div class="col">
                                <div class="card h-100 grid-news-card shadow-sm border-0 overflow-hidden">
                                    <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                        <div class="position-relative">
                                            <img src="<?php echo $news['coverImage']; ?>" class="card-img-top grid-news-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>" loading="lazy">
                                            <?php if (isset($news['isHot']) && $news['isHot']): ?>
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                                    <i class="fas fa-fire me-1"></i>热门
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none text-dark grid-title-link">
                                                <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                            </a>
                                        </h5>
                                        <p class="card-text text-secondary grid-summary"><?php echo isset($news['summary']) ? htmlspecialchars(mb_substr($news['summary'], 0, 80, 'UTF-8')) . (mb_strlen($news['summary'], 'UTF-8') > 80 ? '...' : '') : '暂无摘要'; ?></p>
                                        <div class="grid-news-meta text-muted mt-auto small">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span><i class="far fa-clock me-1"></i> <?php echo isset($news['publishTime']) ? date('Y-m-d', strtotime($news['publishTime'])) : '未知时间'; ?></span>
                                                <span><i class="far fa-eye me-1"></i> <?php echo isset($news['viewCount']) ? number_format($news['viewCount']) : 0; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- 分页 -->
                <div class="pagination-container my-5">
                    <?php if (isset($pagination)): echo $pagination; endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <?php include dirname(__FILE__) . '/../partials/sidebar.php'; ?>
        </div>
    </div>
</div>

<!-- 分类页面特定的JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 视图切换逻辑
    const viewButtons = document.querySelectorAll('.view-btn');
    const listView = document.getElementById('list-view');
    const gridView = document.getElementById('grid-view');
    
    // 从localStorage加载用户首选视图
    const preferredView = localStorage.getItem('newsViewPreference') || 'list';
    setActiveView(preferredView);
    
    // 为视图按钮添加点击事件
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            setActiveView(view);
            localStorage.setItem('newsViewPreference', view);
        });
        
        // 根据保存的首选项设置活动按钮
        if (button.getAttribute('data-view') === preferredView) {
            button.classList.add('active');
        }
    });
    
    // 设置活动视图
    function setActiveView(view) {
        // 更新按钮状态
        viewButtons.forEach(btn => {
            if (btn.getAttribute('data-view') === view) {
                btn.classList.add('btn-primary');
                btn.classList.remove('btn-outline-primary');
            } else {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            }
        });
        
        // 更新视图显示
        if (view === 'grid') {
            listView.style.display = 'none';
            gridView.style.display = 'block';
        } else {
            listView.style.display = 'block';
            gridView.style.display = 'none';
        }
    }
    
    // 平滑滚动效果
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // 懒加载优化
    const newsImages = document.querySelectorAll('.news-image, .grid-news-image');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    imageObserver.unobserve(img);
                }
            });
        });

        newsImages.forEach(img => {
            // 检查图片是否有src但没有dataset.src
            if (img.src && !img.dataset.src) {
                img.dataset.src = img.src;
                img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"%3E%3C/svg%3E';
                imageObserver.observe(img);
            }
        });
    }

    // 添加动画效果
    const newsCards = document.querySelectorAll('.news-card, .grid-news-card');
    setTimeout(() => {
        newsCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('news-card-visible');
            }, index * 100);
        });
    }, 300);
});
</script>

<style>
/* 分类标题样式 */
.category-title {
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 10px;
    font-weight: 700;
    font-size: 1.75rem;
    color: #333;
}

.category-header {
    border-bottom-color: #eee !important;
}

/* 视图切换按钮 */
.view-controls {
    margin-bottom: 15px;
}

/* 列表视图样式 */
.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 8px;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.news-image {
    height: 100%;
    object-fit: cover;
    border-radius: 8px 0 0 8px;
    min-height: 200px;
}

.card-body {
    padding: 1.25rem;
}

.card-title {
    font-weight: 600;
    line-height: 1.4;
    font-size: 1.15rem;
}

.title-link {
    display: inline-block;
    color: #333 !important;
}

.title-link:hover {
    color: #0d6efd !important;
    text-decoration: underline !important;
}

.card-text {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.news-meta {
    font-size: 0.85rem;
    border-top: 1px solid #f0f0f0;
}

.author-info {
    font-style: italic;
}

/* 方块布局特定样式 */
.grid-news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 8px;
    height: 100%;
}

.grid-news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.grid-news-image {
    height: 180px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
}

.grid-news-card .card-title {
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    height: 2.8rem;
}

.grid-summary {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    height: 4.5rem;
}

.grid-news-meta {
    font-size: 0.8rem;
    border-top: 1px solid #f0f0f0;
    padding-top: 0.75rem;
}

/* 分页样式 */
.pagination-container {
    margin-top: 2.5rem;
}

.pagination {
    gap: 0.25rem;
}

.page-link {
    color: #0d6efd;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    margin: 0;
    padding: 0.5rem 0.85rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    background-color: #fff;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(13, 110, 253, 0.3);
    z-index: 1;
}

.page-link:hover {
    background-color: #f0f7ff;
    color: #0a58ca;
    border-color: #c2d6f9;
    z-index: 2;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
    opacity: 0.8;
}

/* 响应式设计 */
@media (max-width: 767.98px) {
    .news-image {
        height: 200px;
        border-radius: 8px 8px 0 0;
    }
    
    .category-title {
        font-size: 1.5rem;
    }
    
    .card-title {
        font-size: 1.1rem;
    }
    
    .news-meta, .grid-news-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .news-meta > div, .grid-news-meta > div {
        width: 100%;
    }
    
    .view-controls {
        margin-top: 10px;
    }
    
    .category-header {
        flex-direction: column;
        align-items: flex-start !important;
    }
}

/* 新闻卡片动画效果 */
.news-card, .grid-news-card {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease, box-shadow 0.3s ease;
}

.news-card-visible {
    opacity: 1;
    transform: translateY(0);
}

/* 悬停效果增强 */
.news-card:hover .card-title a, .grid-news-card:hover .card-title a {
    color: #0d6efd !important;
    text-decoration: underline !important;
}

/* 图片效果 */
.news-image, .grid-news-image {
    transition: all 0.3s ease;
}

.news-card:hover .news-image, .grid-news-card:hover .grid-news-image {
    filter: brightness(1.05);
}

/* 标题动画效果 */
.category-title {
    position: relative;
    animation: slideDown 0.5s ease forwards;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style> 