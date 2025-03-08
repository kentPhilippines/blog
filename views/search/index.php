<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- 搜索表单 -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="/search.php" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="搜索新闻..." required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> 搜索
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (!empty($keyword)): ?>
                <!-- 搜索结果 -->
                <div class="search-results">
                    <h2 class="section-title mb-4">搜索结果：<?php echo htmlspecialchars($keyword); ?></h2>
                    
                    <?php if (empty($searchResults)): ?>
                        <div class="alert alert-info">
                            <p class="mb-0">未找到与"<?php echo htmlspecialchars($keyword); ?>"相关的新闻。</p>
                            <p class="mb-0">建议：</p>
                            <ul class="mb-0">
                                <li>请检查您的拼写</li>
                                <li>尝试使用更通用的关键词</li>
                                <li>尝试使用相关的其他关键词</li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-4">找到 <?php echo $totalItems; ?> 条相关结果</p>
                        
                        <?php foreach ($searchResults as $news): ?>
                            <div class="card mb-4 search-result-item">
                                <div class="row g-0">
                                    <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                                        <div class="col-md-3">
                                            <img src="<?php echo $news['coverImage']; ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?>">
                                        </div>
                                        <div class="col-md-9">
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
                </div>
            <?php else: ?>
                <!-- 搜索提示 -->
                <div class="search-tips">
                    <h2 class="section-title mb-4">搜索提示</h2>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">如何进行有效搜索</h5>
                            <ul class="mb-0">
                                <li>使用具体的关键词可以获得更精确的结果</li>
                                <li>尝试使用不同的词语或同义词</li>
                                <li>搜索特定分类的内容，可以在关键词中包含分类名称</li>
                                <li>搜索特定时间段的新闻，可以在关键词中包含时间信息</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- 热门搜索 -->
                    <h3 class="mt-4 mb-3">热门搜索</h3>
                    <div class="d-flex flex-wrap">
                        <?php foreach ($tags as $index => $tag): ?>
                            <?php if ($index < 10): ?>
                                <?php $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : $tag; ?>
                                <a href="/search.php?keyword=<?php echo urlencode($tagName); ?>" class="btn btn-outline-primary me-2 mb-2">
                                    <?php echo htmlspecialchars($tagName); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <?php include 'views/partials/sidebar.php'; ?>
        </div>
    </div>
</div>

<style>
.search-form .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.search-form .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.search-result-item {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.search-result-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.object-fit-cover {
    object-fit: cover;
}
</style> 