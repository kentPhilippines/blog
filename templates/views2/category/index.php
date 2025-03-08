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
    <!-- 面包屑导航 -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-reset opacity-75">首页</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($url_category_name); ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <!-- 分类标题和描述 -->
            <div class="category-header mb-4 pb-2 border-bottom border-secondary d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="category-title text-glow mb-2"><?php echo htmlspecialchars($url_category_name); ?></h1>
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
                <div class="alert alert-dark text-center py-4">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-muted"></i>
                    <p class="mb-0">暂无符合条件的新闻，请稍后再来查看。</p>
                </div>
            <?php else: ?>
                <!-- 列表视图容器 -->
                <div id="list-view" class="news-container">
                    <?php foreach ($newsList as $news): ?>
                        <div class="card mb-4 news-card shadow-lg border-0 bg-dark-card overflow-hidden">
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
                                            <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none text-light fw-bold hover-primary title-link">
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
                
                <!-- 网格视图容器 -->
                <div id="grid-view" class="news-container d-none">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($newsList as $news): ?>
                            <div class="col">
                                <div class="card h-100 shadow-lg bg-dark-card border-0 hover-lift overflow-hidden">
                                    <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                        <div class="position-relative">
                                            <img src="<?php echo $news['coverImage']; ?>" class="card-img-top" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>" loading="lazy" style="height: 180px; object-fit: cover;">
                                            <?php if (isset($news['isHot']) && $news['isHot']): ?>
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                                    <i class="fas fa-fire me-1"></i>热门
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none text-light fw-bold hover-primary title-link">
                                                <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                            </a>
                                        </h5>
                                        <p class="card-text text-secondary"><?php echo isset($news['summary']) ? htmlspecialchars(mb_substr($news['summary'], 0, 80, 'UTF-8')) . (mb_strlen($news['summary'], 'UTF-8') > 80 ? '...' : '') : '暂无摘要'; ?></p>
                                        <div class="mt-auto pt-2 d-flex justify-content-between small text-muted">
                                            <span><i class="far fa-clock me-1"></i> <?php echo isset($news['publishTime']) ? date('m-d', strtotime($news['publishTime'])) : '未知'; ?></span>
                                            <span><i class="far fa-eye me-1"></i> <?php echo isset($news['viewCount']) ? number_format($news['viewCount']) : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- 分页控件 -->
                <?php if (isset($pagination) && is_array($pagination) && isset($pagination['totalPages']) && $pagination['totalPages'] > 1): ?>
                    <nav aria-label="分页导航" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php if (isset($pagination['currentPage']) && $pagination['currentPage'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-light border-secondary" href="<?php echo '?name=' . urlencode($categoryName) . '&page=' . ($pagination['currentPage'] - 1); ?>" aria-label="上一页">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link bg-dark text-light border-secondary">&laquo;</span>
                                </li>
                            <?php endif; ?>
                            
                            <?php 
                                // 仅显示当前页附近的5个页码
                                $startPage = max(1, isset($pagination['currentPage']) ? $pagination['currentPage'] - 2 : 1);
                                $endPage = min(isset($pagination['totalPages']) ? $pagination['totalPages'] : 1, $startPage + 4);
                                if ($endPage - $startPage < 4) {
                                    $startPage = max(1, $endPage - 4);
                                }
                                
                                for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item <?php echo isset($pagination['currentPage']) && $i == $pagination['currentPage'] ? 'active' : ''; ?>">
                                    <a class="page-link <?php echo isset($pagination['currentPage']) && $i == $pagination['currentPage'] ? 'bg-primary border-primary' : 'bg-dark text-light border-secondary'; ?>" href="<?php echo '?name=' . urlencode($categoryName) . '&page=' . $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if (isset($pagination['currentPage']) && isset($pagination['totalPages']) && $pagination['currentPage'] < $pagination['totalPages']): ?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-light border-secondary" href="<?php echo '?name=' . urlencode($categoryName) . '&page=' . ($pagination['currentPage'] + 1); ?>" aria-label="下一页">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link bg-dark text-light border-secondary">&raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4">
            <!-- 侧边栏内容 -->
            <div class="card bg-dark-card shadow-lg border-0 mb-4">
                <div class="card-header bg-dark border-secondary">
                    <h5 class="card-title mb-0"><i class="fas fa-search me-2"></i>搜索</h5>
                </div>
                <div class="card-body">
                    <form action="/search.php" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control bg-dark text-light border-secondary" placeholder="搜索关键词..." name="q">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- 热门分类 -->
            <div class="card bg-dark-card shadow-lg border-0 mb-4">
                <div class="card-header bg-dark border-secondary">
                    <h5 class="card-title mb-0"><i class="fas fa-th-list me-2"></i>热门分类</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush bg-transparent">
                        <?php foreach ($categories as $cat): ?>
                            <?php 
                                $catName = is_array($cat) && isset($cat['name']) ? $cat['name'] : $cat;
                                $newsCount = is_array($cat) && isset($cat['newsCount']) ? $cat['newsCount'] : 0;
                                $isActive = $catName == $categoryName;
                            ?>
                            <a href="/category.php?name=<?php echo urlencode($catName); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent border-secondary text-light <?php echo $isActive ? 'active fw-bold' : ''; ?>">
                                <?php echo htmlspecialchars($catName); ?>
                                <span class="badge bg-secondary rounded-pill"><?php echo number_format($newsCount); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- 标签云 -->
            <?php if (isset($tags) && !empty($tags)): ?>
            <div class="card bg-dark-card shadow-lg border-0 mb-4">
                <div class="card-header bg-dark border-secondary">
                    <h5 class="card-title mb-0"><i class="fas fa-tags me-2"></i>热门标签</h5>
                </div>
                <div class="card-body">
                    <div class="tags-cloud">
                        <?php foreach ($tags as $tag): ?>
                            <a href="/tag.php?name=<?php echo urlencode($tag['name']); ?>" class="tag-item badge bg-dark text-light me-2 mb-2">
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// 列表/网格视图切换
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const listView = document.getElementById('list-view');
    const gridView = document.getElementById('grid-view');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const viewType = this.getAttribute('data-view');
            
            // 激活点击的按钮
            viewButtons.forEach(btn => btn.classList.remove('active', 'btn-primary'));
            this.classList.add('active', 'btn-primary');
            this.classList.remove('btn-outline-primary');
            
            // 显示对应视图
            if (viewType === 'list') {
                listView.classList.remove('d-none');
                gridView.classList.add('d-none');
                // 保存用户偏好
                localStorage.setItem('newsViewPreference', 'list');
            } else {
                gridView.classList.remove('d-none');
                listView.classList.add('d-none');
                // 保存用户偏好
                localStorage.setItem('newsViewPreference', 'grid');
            }
        });
    });
    
    // 根据本地存储中的偏好设置初始视图
    const savedViewPreference = localStorage.getItem('newsViewPreference');
    if (savedViewPreference) {
        const activeButton = document.querySelector(`.view-btn[data-view="${savedViewPreference}"]`);
        if (activeButton) {
            activeButton.click();
        }
    } else {
        // 默认激活列表视图
        const listButton = document.querySelector('.view-btn[data-view="list"]');
        if (listButton) {
            listButton.click();
        }
    }
});
</script> 