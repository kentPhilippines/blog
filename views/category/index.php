<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- 分类标题 -->
            <div class="category-header mb-4">
                <h1 class="category-title"><?php echo htmlspecialchars($categoryName); ?></h1>
                <p class="text-muted">共 <?php echo $totalItems; ?> 篇文章</p>
            </div>
            
            <!-- 新闻列表 -->
            <?php if (empty($newsList)): ?>
                <div class="alert alert-info">该分类下暂无新闻</div>
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
        </div>
        
        <div class="col-md-4">
            <?php include 'views/partials/sidebar.php'; ?>
        </div>
    </div>
</div>

<style>
.category-title {
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-weight: 700;
}

.category-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: #0d6efd;
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
</style> 