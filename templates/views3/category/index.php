<?php
/**
 * 网易新闻风格的分类页面模板
 */
?>
<div class="ne-category">
    <!-- 面包屑导航 -->
    <div class="ne-breadcrumb">
        <a href="/" class="ne-breadcrumb-item">首页</a>
        <span class="ne-breadcrumb-separator">/</span>
        <span class="ne-breadcrumb-item ne-breadcrumb-current">
            <?php 
            $categoryName = is_array($category) ? ($category['name'] ?? '分类') : $category;
            echo htmlspecialchars($categoryName); 
            ?>
        </span>
    </div>

    <!-- 分类标题 -->
    <div class="ne-category-header">
        <h1 class="ne-category-title">
            <?php 
            $categoryName = is_array($category) ? ($category['name'] ?? '分类') : $category;
            echo htmlspecialchars($categoryName); 
            ?>
        </h1>
        <?php if (!empty($category['description']) || !empty($categoryDescription)): ?>
        <div class="ne-category-description">
            <?php 
            $description = is_array($category) ? 
                ($category['description'] ?? $categoryDescription ?? '') : 
                ($categoryDescription ?? '');
            echo htmlspecialchars($description);
            ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- 新闻列表区域 -->
    <div class="ne-content">
        <div class="ne-news-list">
            <?php if (!empty($newsList)): ?>
                <?php foreach ($newsList as $news): ?>
                <article class="ne-news-item">
                    <div class="ne-news-info">
                        <h3 class="ne-news-title">
                            <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>">
                                <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                            </a>
                        </h3>
                        <?php if (!empty($news['summary'])): ?>
                        <p class="ne-news-summary">
                            <?php echo htmlspecialchars($news['summary']); ?>
                        </p>
                        <?php endif; ?>
                        <div class="ne-news-meta">
                            <?php if (!empty($news['source'])): ?>
                            <span class="ne-news-source">
                                <?php echo htmlspecialchars($news['source']); ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($news['publishTime'])): ?>
                            <span class="ne-news-time">
                                <?php echo date('Y-m-d H:i', strtotime($news['publishTime'])); ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($news['commentCount'])): ?>
                            <span class="ne-news-comments">
                                <i class="iconfont icon-comment"></i>
                                <?php echo (int)$news['commentCount']; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($news['image'])): ?>
                    <div class="ne-news-image">
                        <a href="/news.php?id=<?php echo htmlspecialchars($news['id'] ?? ''); ?>">
                            <img src="<?php echo htmlspecialchars($news['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($news['title'] ?? ''); ?>">
                        </a>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>

                <!-- 分页 -->
                <?php if (!empty($totalPages) && $totalPages > 1): ?>
                <div class="ne-pagination">
                    <?php echo $pagination; ?>
                </div>
                <?php endif; ?>
            <?php else: ?>
            <div class="ne-empty-message">
                该分类下暂无新闻
            </div>
            <?php endif; ?>
        </div>

        <!-- 侧边栏 -->
        <aside class="ne-sidebar">
            <!-- 热门分类 -->
            <?php if (!empty($categories)): ?>
            <div class="ne-hot-categories">
                <h3 class="ne-sidebar-title">
                    <i class="iconfont icon-category"></i> 热门分类
                </h3>
                <ul class="ne-category-list">
                    <?php foreach ($categories as $cat): ?>
                    <?php 
                    $catName = is_array($cat) ? ($cat['name'] ?? '') : $cat;
                    $isActive = $catName === $categoryName;
                    ?>
                    <li class="ne-category-item<?php echo $isActive ? ' active' : ''; ?>">
                        <a href="/category.php?name=<?php echo urlencode($catName); ?>">
                            <?php echo htmlspecialchars($catName); ?>
                            <?php if (!empty($cat['count'])): ?>
                            <span class="ne-category-count">(<?php echo (int)$cat['count']; ?>)</span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- 热门标签 -->
            <?php if (!empty($tags)): ?>
            <div class="ne-hot-tags">
                <h3 class="ne-sidebar-title">
                    <i class="iconfont icon-tag"></i> 热门标签
                </h3>
                <div class="ne-tag-cloud">
                    <?php foreach ($tags as $tag): ?>
                    <a href="/tag.php?name=<?php echo urlencode($tag['name']); ?>" 
                       class="ne-tag-item">
                        <?php echo htmlspecialchars($tag['name']); ?>
                        <?php if (!empty($tag['count'])): ?>
                        <span class="ne-tag-count"><?php echo (int)$tag['count']; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- 相关推荐 -->
            <?php if (!empty($relatedNews)): ?>
            <div class="ne-related-news">
                <h3 class="ne-sidebar-title">
                    <i class="iconfont icon-related"></i> 相关推荐
                </h3>
                <ul class="ne-related-list">
                    <?php foreach ($relatedNews as $index => $related): ?>
                    <li class="ne-related-item<?php echo $index < 3 ? ' ne-related-top' : ''; ?>">
                        <span class="ne-related-num"><?php echo $index + 1; ?></span>
                        <a href="/news.php?id=<?php echo htmlspecialchars($related['id']); ?>" class="ne-related-link">
                            <?php echo htmlspecialchars($related['title']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </aside>
    </div>
</div> 