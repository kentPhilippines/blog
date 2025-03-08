<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- 标签标题 -->
            <div class="tag-header mb-4">
                <h1 class="tag-title">
                    <span class="badge bg-primary p-2 fs-4">
                        <i class="fas fa-tag me-2"></i><?php echo htmlspecialchars($tagName); ?>
                    </span>
                </h1>
                <p class="text-muted mt-3">找到 <?php echo $totalItems; ?> 篇相关文章</p>
            </div>
            
            <!-- 新闻列表 -->
            <?php if (empty($newsList)): ?>
                <div class="alert alert-info">该标签下暂无新闻</div>
            <?php else: ?>
                <?php foreach ($newsList as $news): ?>
                    <div class="card mb-4 news-card">
                        <div class="row g-0">
                            <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                <div class="col-md-4">
                                    <img src="<?php echo $news['coverImage']; ?>" class="img-fluid rounded-start news-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                                </div>
                                <div class="col-md-8">
                            <?php else: ?>
                                <div class="col-md-12">
                            <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none">
                                            <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                        </a>
                                    </h5>
                                    <p class="card-text"><?php echo isset($news['summary']) ? htmlspecialchars($news['summary']) : '暂无摘要'; ?></p>
                                    <div class="news-meta">
                                        <span class="badge bg-primary"><?php echo isset($news['categoryName']) ? $news['categoryName'] : '未分类'; ?></span>
                                        <span class="text-muted"><i class="far fa-clock"></i> <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?></span>
                                        <span class="text-muted"><i class="far fa-eye"></i> <?php echo isset($news['viewCount']) ? $news['viewCount'] : 0; ?>次阅读</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- 分页 -->
                <?php echo $pagination; ?>
            <?php endif; ?>
            
            <!-- 相关标签 -->
            <div class="related-tags mt-5">
                <h3 class="mb-3">相关标签</h3>
                <div class="d-flex flex-wrap">
                    <?php 
                    $relatedTagsCount = 0;
                    foreach ($tags as $tag): 
                        if ($tag != $tagName && $relatedTagsCount < 10):
                            $relatedTagsCount++;
                    ?>
                        <a href="/tag.php?name=<?php echo urlencode($tag); ?>" class="badge bg-secondary me-2 mb-2 p-2">
                            <?php echo htmlspecialchars($tag); ?>
                        </a>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <?php include 'views/partials/sidebar.php'; ?>
        </div>
    </div>
</div>

<style>
.tag-title {
    margin-bottom: 20px;
}

.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.news-image {
    height: 100%;
    object-fit: cover;
}

.badge {
    font-weight: 500;
}

.badge.bg-secondary {
    transition: background-color 0.3s ease;
}

.badge.bg-secondary:hover {
    background-color: #0d6efd !important;
}
</style> 