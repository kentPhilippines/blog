<?php
// 确保有相关新闻数据
if (empty($relatedNews)) {
    return;
}
?>

<div class="related-news mt-5">
    <h3 class="mb-4">相关新闻</h3>
    
    <div class="row">
        <?php foreach ($relatedNews as $related): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if (isset($related['coverImage']) && !empty($related['coverImage'])): ?>
                        <img src="<?php echo $related['coverImage']; ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?php echo htmlspecialchars($related['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/news.php?id=<?php echo $related['id']; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($related['title']); ?>
                            </a>
                        </h5>
                        <p class="card-text small"><?php echo isset($related['summary']) ? Utils::truncateText($related['summary'], 80) : '暂无摘要'; ?></p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="small text-muted">
                            <span><i class="far fa-clock"></i> <?php echo Utils::getRelativeTime($related['publishTime']); ?></span>
                            <span class="ms-2"><i class="far fa-eye"></i> <?php echo $related['viewCount']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div> 