<?php
// 侧边栏模板
?>
<!-- 侧边栏 -->
<div class="sidebar">
    <!-- 搜索框 -->
    <div class="card mb-4 sidebar-card">
        <div class="card-body">
            <h5 class="sidebar-title">搜索</h5>
            <form action="/search.php" method="get" class="search-form">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="搜索新闻..." required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 热门新闻 -->
    <div class="card mb-4 sidebar-card">
        <div class="card-body">
            <h5 class="sidebar-title">热门新闻</h5>
            <?php 
            // 获取热门新闻数据
            $sidebarHotNews = isset($hotNews) ? $hotNews : [];
            
            // 如果没有热门新闻数据，显示默认提示
            if (!empty($sidebarHotNews)): 
            ?>
                <ul class="list-unstyled popular-news-list">
                    <?php 
                    // 确保只显示最多5条
                    $displayNews = array_slice($sidebarHotNews, 0, 5);
                    foreach ($displayNews as $index => $news): 
                    ?>
                        <li class="<?php echo $index > 0 ? 'border-top pt-2 mt-2' : ''; ?>">
                            <div class="d-flex">
                                <div class="flex-shrink-0 text-center me-2">
                                    <span class="badge <?php echo $index < 3 ? 'bg-danger' : 'bg-secondary'; ?> rounded-circle rank-badge"><?php echo $index + 1; ?></span>
                                </div>
                                <div>
                                    <a href="/news.php?id=<?php echo $news['id']; ?>" class="text-dark text-decoration-none small sidebar-news-link">
                                        <?php echo htmlspecialchars($news['title']); ?>
                                    </a>
                                    <div class="text-muted xsmall">
                                        <i class="far fa-eye me-1"></i><?php echo isset($news['viewCount']) ? number_format($news['viewCount']) : 0; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-newspaper text-muted fa-2x mb-2"></i>
                    <p class="text-muted small mb-0">暂无热门新闻</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 热门标签 -->
    <div class="card mb-4 sidebar-card">
        <div class="card-body">
            <h5 class="sidebar-title">热门标签</h5>
            <?php 
            // 获取热门标签数据
            $sidebarTags = isset($tags) ? $tags : [];
            
            // 如果没有标签数据，显示默认提示
            if (!empty($sidebarTags)): 
            ?>
                <div class="tags-cloud">
                    <?php 
                    // 确保只显示最多12个标签
                    $displayTags = array_slice($sidebarTags, 0, 12);
                    foreach ($displayTags as $tag): 
                        // 支持两种可能的API返回格式
                        $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : (is_string($tag) ? $tag : '');
                    ?>
                        <a href="/tag.php?name=<?php echo urlencode($tagName); ?>" class="btn btn-sm btn-outline-secondary mb-2 me-1 tag-btn">
                            <?php echo htmlspecialchars($tagName); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-tags text-muted fa-2x mb-2"></i>
                    <p class="text-muted small mb-0">暂无热门标签</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 广告区域 -->
    <div class="card mb-4 text-center sidebar-card">
        <div class="card-body">
            <h5 class="sidebar-title">赞助商</h5>
            <div class="sidebar-ad">
                <img src="/assets/images/default-ad.jpg" alt="广告" class="img-fluid rounded mb-2">
                <p class="small text-muted mb-0">广告位招商，联系我们</p>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar-card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.sidebar-card:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.sidebar-title {
    font-size: 1.1rem;
    font-weight: 600;
    position: relative;
    padding-bottom: 0.75rem;
    margin-bottom: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.sidebar-news-link {
    display: block;
    line-height: 1.4;
    font-weight: 500;
    transition: color 0.2s;
}

.sidebar-news-link:hover {
    color: var(--primary-color, #0d6efd) !important;
    text-decoration: underline !important;
}

.rank-badge {
    width: 24px;
    height: 24px;
    line-height: 24px;
    padding: 0;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.popular-news-list li {
    padding-bottom: 0.75rem;
}

.popular-news-list li:last-child {
    padding-bottom: 0;
}

.xsmall {
    font-size: 0.75rem;
}

.search-form .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.tag-btn {
    border-radius: 20px;
    font-size: 0.75rem;
    transition: all 0.2s;
}

.tag-btn:hover {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.sidebar-ad img {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.sidebar-ad img:hover {
    transform: scale(1.02);
}

@media (max-width: 767.98px) {
    .sidebar {
        margin-top: 2rem;
    }
}
</style> 