<div class="container py-4 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <div class="categories-header text-center mb-5">
                <h1 class="display-5 fw-bold mb-3 text-gradient">所有分类</h1>
                <p class="lead text-white-50 mb-4">浏览我们网站的所有内容分类，找到您感兴趣的文章</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">首页</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">所有分类</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (isset($news_items) && count($news_items) > 0): ?>
            <?php foreach ($news_items as $item): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card h-100">
                        <div class="category-icon mb-3">
                            <i class="mdi mdi-shape-outline" style="font-size: 2.5rem; color: var(--primary-light);"></i>
                        </div>
                        <h3 class="category-title">
                            <a href="<?php echo $item['url']; ?>" class="text-decoration-none text-reset stretched-link">
                                <?php echo htmlspecialchars($item['title']); ?>
                            </a>
                        </h3>
                        <div class="category-count mb-3">
                            <span class="badge bg-primary-light rounded-pill">
                                <i class="mdi mdi-file-document-outline me-1"></i>
                                <?php echo $item['viewCount']; ?> 篇文章
                            </span>
                        </div>
                        <p class="category-summary text-white-50">
                            <?php 
                            if (isset($item['summary']) && !empty($item['summary'])) {
                                echo htmlspecialchars($item['summary']);
                            } else {
                                echo '此分类包含多篇文章，点击查看更多';
                            }
                            ?>
                        </p>
                        <div class="hover-overlay"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-dark">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                    暂无分类信息
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- 分页 -->
    <div class="pagination-container my-5">
        <?php if (isset($pagination)): ?>
            <?php if (is_array($pagination)): ?>
                <nav aria-label="分页导航" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php if (isset($pagination['currentPage']) && isset($pagination['prevPage']) && $pagination['currentPage'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link bg-dark text-light border-secondary" href="?type=hot&page=<?php echo $pagination['prevPage']; ?>" aria-label="上一页">
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
                                <a class="page-link <?php echo isset($pagination['currentPage']) && $i == $pagination['currentPage'] ? 'bg-primary border-primary' : 'bg-dark text-light border-secondary'; ?>" href="?type=hot&page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if (isset($pagination['currentPage']) && isset($pagination['totalPages']) && isset($pagination['nextPage']) && $pagination['currentPage'] < $pagination['totalPages']): ?>
                            <li class="page-item">
                                <a class="page-link bg-dark text-light border-secondary" href="?type=hot&page=<?php echo $pagination['nextPage']; ?>" aria-label="下一页">
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
            <?php else: ?>
                <?php echo $pagination; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .categories-header {
        position: relative;
        padding-bottom: 2rem;
        margin-bottom: 3rem;
    }
    
    .categories-header::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-light), var(--secondary-color));
        transform: translateX(-50%);
        border-radius: 2px;
    }
    
    .category-card {
        background-color: var(--surface-color);
        border-radius: 12px;
        padding: 1.75rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }
    
    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-light), var(--secondary-color));
        opacity: 0.8;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
    
    .category-card:hover .category-title a {
        color: var(--primary-light) !important;
    }
    
    .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top right, 
                                     rgba(187, 134, 252, 0.1), 
                                     transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }
    
    .category-card:hover .hover-overlay {
        opacity: 1;
    }
    
    .category-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
    }
    
    .category-count {
        font-size: 0.9rem;
    }
    
    .category-summary {
        font-size: 0.95rem;
        line-height: 1.7;
    }
    
    @media (max-width: 768px) {
        .categories-header {
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .category-card {
            padding: 1.25rem;
        }
        
        .category-title {
            font-size: 1.3rem;
        }
    }
</style> 