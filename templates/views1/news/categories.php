<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="categories-header">
                <h1 class="display-5 fw-bold mb-3">所有分类</h1>
                <p class="lead text-muted">浏览我们网站的所有内容分类，找到您感兴趣的文章</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">首页</a></li>
                        <li class="breadcrumb-item active" aria-current="page">所有分类</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (isset($news_items) && count($news_items) > 0): ?>
            <?php foreach ($news_items as $item): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="category-card h-100">
                        <a href="<?php echo htmlspecialchars($item['url']); ?>" class="text-decoration-none">
                            <div class="card shadow-sm hover-shadow h-100">
                                <div class="card-body">
                                    <h3 class="card-title h5 mb-3"><?php echo htmlspecialchars($item['title']); ?></h3>
                                    <div class="category-info">
                                        <span class="badge bg-primary rounded-pill me-2">
                                            <i class="fas fa-newspaper me-1"></i>
                                            <?php echo isset($item['viewCount']) ? number_format($item['viewCount']) : 0; ?> 篇文章
                                        </span>
                                    </div>
                                    <?php if (isset($item['summary']) && !empty($item['summary'])): ?>
                                        <p class="card-text mt-3 text-muted"><?php echo htmlspecialchars($item['summary']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i> <?php echo htmlspecialchars($item['publishTime']); ?>
                                        </small>
                                        <span class="btn btn-sm btn-outline-primary">浏览分类</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> 暂无分类数据
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- 分页 -->
    <div class="pagination-container my-5">
        <?php if (isset($pagination)): echo $pagination; endif; ?>
    </div>
</div>

<style>
    .category-card {
        transition: transform 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .categories-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
        animation: fadeInDown 0.5s ease-out;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* 让所有卡片高度相同 */
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    
    .category-info .badge {
        transition: all 0.3s ease;
    }
    
    .category-card:hover .badge {
        background-color: #0056b3 !important;
    }
    
    /* 响应式调整 */
    @media (max-width: 767.98px) {
        .col-md-4 {
            margin-bottom: 1rem;
        }
        
        .categories-header h1 {
            font-size: 2rem;
        }
    }
</style> 