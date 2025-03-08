<!-- 热门新闻 -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">热门新闻</h5>
    </div>
    <div class="card-body">
        <?php if (empty($hotNews)): ?>
            <p class="text-muted">暂无热门新闻</p>
        <?php else: ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($hotNews as $hot): ?>
                    <li class="list-group-item px-0">
                        <div class="row">
                            <?php if (isset($hot['coverImage']) && !empty($hot['coverImage'])): ?>
                                <div class="col-4">
                                    <img src="<?php echo $hot['coverImage']; ?>" class="img-fluid rounded" alt="<?php echo isset($hot['title']) ? htmlspecialchars($hot['title']) : '无标题'; ?>">
                                </div>
                                <div class="col-8">
                            <?php else: ?>
                                <div class="col-12">
                            <?php endif; ?>
                                <h6 class="mb-1">
                                    <a href="/news.php?id=<?php echo isset($hot['id']) ? $hot['id'] : 0; ?>" class="text-decoration-none">
                                        <?php echo isset($hot['title']) ? htmlspecialchars($hot['title']) : '无标题'; ?>
                                    </a>
                                </h6>
                                <div class="small text-muted">
                                    <span><i class="far fa-clock"></i> <?php echo isset($hot['publishTime']) ? Utils::getRelativeTime($hot['publishTime']) : '未知时间'; ?></span>
                                    <span><i class="far fa-eye"></i> <?php echo isset($hot['viewCount']) ? $hot['viewCount'] : 0; ?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- 分类列表 -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">新闻分类</h5>
    </div>
    <div class="card-body">
        <?php if (empty($categories)): ?>
            <p class="text-muted">暂无分类</p>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($categories as $category): ?>
                    <?php 
                        $categoryName = is_array($category) && isset($category['name']) ? $category['name'] : $category;
                        $isActive = isset($GLOBALS['categoryName']) && $GLOBALS['categoryName'] == $categoryName;
                    ?>
                    <a href="/category.php?name=<?php echo urlencode($categoryName); ?>" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?php echo $isActive ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($categoryName); ?>
                        <span class="badge <?php echo $isActive ? 'bg-light text-dark' : 'bg-primary'; ?> rounded-pill">
                            <?php 
                            // 使用API返回的newsCount字段
                            $count = 0;
                            if (is_array($category) && isset($category['newsCount'])) {
                                $count = $category['newsCount'];
                            } else {
                                // 兼容旧代码，如果没有newsCount字段，则手动计算
                                if (isset($newsList) && is_array($newsList)) {
                                    foreach ($newsList as $news) {
                                        $newsCategoryName = isset($news['categoryName']) ? $news['categoryName'] : '';
                                        if ($newsCategoryName == $categoryName) {
                                            $count++;
                                        }
                                    }
                                }
                            }
                            echo $count;
                            ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- 标签云 -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">热门标签</h5>
    </div>
    <div class="card-body">
        <?php if (empty($tags)): ?>
            <p class="text-muted">暂无标签</p>
        <?php else: ?>
            <div class="tag-cloud">
                <?php foreach ($tags as $tag): ?>
                    <?php 
                        $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : $tag;
                        $isActive = isset($tagName) && isset($GLOBALS['tagName']) && $GLOBALS['tagName'] == $tagName;
                    ?>
                    <a href="/tag.php?name=<?php echo urlencode($tagName); ?>" 
                       class="tag-item <?php echo $isActive ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($tagName); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div> 