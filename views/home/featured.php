<?php
// 获取前3条新闻作为特色新闻
$featuredNews = array_slice($newsList, 0, 3);
?>

<div class="featured-news mb-5">
    <h2 class="section-title mb-4">特色新闻</h2>
    
    <?php if (empty($featuredNews)): ?>
        <div class="alert alert-info">暂无特色新闻</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($featuredNews as $index => $news): ?>
                <?php if ($index === 0): ?>
                    <!-- 第一个特色新闻（大图） -->
                    <div class="col-md-6 mb-4">
                        <div class="card featured-card h-100">
                            <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                <img src="<?php echo $news['coverImage']; ?>" class="card-img-top featured-image" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="/news.php?id=<?php echo isset($news['id']) ? $news['id'] : 0; ?>" class="text-decoration-none">
                                        <?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>
                                    </a>
                                </h3>
                                <p class="card-text"><?php echo isset($news['summary']) ? htmlspecialchars($news['summary']) : '暂无摘要'; ?></p>
                                <div class="news-meta">
                                    <span class="badge bg-primary"><?php echo isset($news['categoryName']) ? $news['categoryName'] : '未分类'; ?></span>
                                    <span class="text-muted"><i class="far fa-clock"></i> <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?></span>
                                    <span class="text-muted"><i class="far fa-eye"></i> <?php echo isset($news['viewCount']) ? $news['viewCount'] : 0; ?>次阅读</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row">
                <?php else: ?>
                    <!-- 其他特色新闻（小图） -->
                    <div class="col-md-12 mb-4">
                        <div class="card h-100">
                            <div class="row g-0">
                                <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                    <div class="col-4">
                                        <img src="<?php echo $news['coverImage']; ?>" class="img-fluid rounded-start h-100 w-100 object-fit-cover" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
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
                                        <p class="card-text small"><?php echo isset($news['summary']) ? Utils::truncateText($news['summary'], 80) : '暂无摘要'; ?></p>
                                        <div class="news-meta small">
                                            <span class="badge bg-primary"><?php echo isset($news['categoryName']) ? $news['categoryName'] : '未分类'; ?></span>
                                            <span class="text-muted"><i class="far fa-clock"></i> <?php echo isset($news['publishTime']) ? Utils::getRelativeTime($news['publishTime']) : '未知时间'; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($index === count($featuredNews) - 1 && $index > 0): ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.featured-image {
    height: 300px;
    object-fit: cover;
}

.featured-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.featured-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.section-title {
    position: relative;
    padding-bottom: 10px;
    font-weight: 700;
}

.section-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: #0d6efd;
}
</style> 