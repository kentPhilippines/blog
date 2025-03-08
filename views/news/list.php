<div class="row">
    <div class="col-md-8">
        <?php if (isset($categoryName) && !empty($categoryName)): ?>
            <h1 class="mb-4"><?php echo $categoryName; ?>新闻</h1>
            <?php if (isset($currentCategory['description']) && !empty($currentCategory['description'])): ?>
                <div class="category-description mb-4">
                    <p><?php echo htmlspecialchars($currentCategory['description']); ?></p>
                </div>
            <?php endif; ?>
        <?php elseif (isset($tagName) && !empty($tagName)): ?>
            <h1 class="mb-4">标签：<?php echo htmlspecialchars($tagName); ?></h1>
            <div class="tag-stats mb-4">
                <?php if (isset($currentTag) && isset($currentTag['frequency'])): ?>
                    <p>该标签已被使用 <strong><?php echo $currentTag['frequency']; ?></strong> 次</p>
                <?php endif; ?>
                <p>共找到 <strong><?php echo $totalItems; ?></strong> 条相关新闻</p>
            </div>
        <?php elseif (isset($keyword) && !empty($keyword)): ?>
            <h1 class="mb-4">搜索结果：<?php echo htmlspecialchars($keyword); ?></h1>
            <div class="search-stats mb-4">
                <p>共找到 <strong><?php echo $totalItems; ?></strong> 条相关结果</p>
            </div>
        <?php else: ?>
            <h1 class="mb-4">最新新闻</h1>
        <?php endif; ?>
        
        <?php if (empty($newsList)): ?>
            <div class="alert alert-info">
                <?php if (isset($keyword)): ?>
                    <p>未找到与"<?php echo htmlspecialchars($keyword); ?>"相关的新闻。</p>
                    <p>建议：</p>
                    <ul>
                        <li>请检查您的拼写</li>
                        <li>尝试使用更通用的关键词</li>
                        <li>尝试使用相关的其他关键词</li>
                    </ul>
                <?php elseif (isset($tagName)): ?>
                    暂无与"<?php echo htmlspecialchars($tagName); ?>"标签相关的新闻
                <?php elseif (isset($categoryName)): ?>
                    该分类下暂无新闻
                <?php else: ?>
                    暂无新闻
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($newsList as $news): ?>
                <div class="card mb-4 news-card">
                    <div class="row g-0">
                        <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                            <div class="col-md-4">
                                <img src="<?php echo $news['coverImage']; ?>" class="img-fluid rounded-start news-image" alt="<?php echo htmlspecialchars($news['title']); ?>">
                            </div>
                            <div class="col-md-8">
                        <?php else: ?>
                            <div class="col-md-12">
                        <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="/news.php?id=<?php echo $news['id']; ?>" class="text-decoration-none">
                                        <?php echo htmlspecialchars($news['title']); ?>
                                    </a>
                                </h5>
                                <p class="card-text"><?php echo isset($news['summary']) ? htmlspecialchars($news['summary']) : '暂无摘要'; ?></p>
                                <div class="news-meta">
                                    <span class="badge bg-primary"><?php echo $news['categoryName']; ?></span>
                                    <span class="text-muted"><i class="far fa-clock"></i> <?php echo Utils::getRelativeTime($news['publishTime']); ?></span>
                                    <span class="text-muted"><i class="far fa-eye"></i> <?php echo $news['viewCount']; ?>次阅读</span>
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
        <?php if (isset($keyword)): ?>
            <!-- 搜索框 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">搜索</h5>
                </div>
                <div class="card-body">
                    <form action="/search.php" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="搜索新闻..." value="<?php echo htmlspecialchars($keyword); ?>" required>
                            <button class="btn btn-primary" type="submit">搜索</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <?php include 'views/partials/sidebar.php'; ?>
    </div>
</div> 