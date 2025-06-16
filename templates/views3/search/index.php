<?php
/**
 * 网易新闻风格的搜索结果模板
 */
?>
<div class="ne-search-page">
    <!-- 搜索结果头部 -->
    <div class="ne-search-header">
        <div class="ne-search-info">
            <?php if (!empty($keyword)): ?>
            <h1 class="ne-search-title">
                <i class="fas fa-search"></i> "<?php echo htmlspecialchars($keyword); ?>" 的搜索结果
            </h1>
            <div class="ne-search-stats">
                找到 <?php echo number_format($totalResults ?? 0); ?> 条结果 (用时 <?php echo isset($searchTime) ? number_format($searchTime, 3) : '0.000'; ?> 秒)
            </div>
            <?php else: ?>
            <h1 class="ne-search-title">搜索新闻</h1>
            <?php endif; ?>
        </div>
        <div class="ne-search-form">
            <form action="/search.php" method="get" role="search">
                <div class="ne-search-input-group">
                    <input type="text" 
                           name="q" 
                           class="ne-search-page-input" 
                           placeholder="输入关键词搜索新闻" 
                           aria-label="搜索新闻"
                           value="<?php echo isset($keyword) ? htmlspecialchars($keyword) : ''; ?>">
                    <button type="submit" class="ne-search-page-btn" aria-label="搜索">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="ne-search-filters-page">
                    <select name="category" class="ne-search-filter-page">
                        <option value="">所有分类</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <?php $catName = is_array($cat) ? ($cat['name'] ?? '') : $cat; ?>
                                <option value="<?php echo htmlspecialchars($catName); ?>"
                                        <?php echo (isset($category) && $category === $catName) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($catName); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <select name="sort" class="ne-search-filter-page">
                        <option value="time" <?php echo (isset($sortBy) && $sortBy === 'time') ? 'selected' : ''; ?>>按时间排序</option>
                        <option value="relevance" <?php echo (isset($sortBy) && $sortBy === 'relevance') ? 'selected' : ''; ?>>按相关性排序</option>
                        <option value="views" <?php echo (isset($sortBy) && $sortBy === 'views') ? 'selected' : ''; ?>>按热度排序</option>
                    </select>
                </div>
            </form>
            
            <!-- 当前筛选条件 -->
            <?php if (!empty($category) || !empty($sortBy) && $sortBy !== 'time'): ?>
            <div class="ne-search-current-filters">
                <span>当前筛选：</span>
                <?php if (!empty($category)): ?>
                <div class="ne-search-current-filter">
                    分类：<?php echo htmlspecialchars($category); ?>
                    <a href="<?php 
                        $clearCategoryUrl = $_SERVER['REQUEST_URI'];
                        $clearCategoryUrl = preg_replace('/[&?]category=[^&]*/', '', $clearCategoryUrl);
                        $clearCategoryUrl = preg_replace('/\?&/', '?', $clearCategoryUrl);
                        echo htmlspecialchars($clearCategoryUrl);
                    ?>" class="fa fa-times" title="清除分类筛选"></a>
                </div>
                <?php endif; ?>
                <?php if (!empty($sortBy) && $sortBy !== 'time'): ?>
                <div class="ne-search-current-filter">
                    排序：<?php 
                        echo $sortBy === 'relevance' ? '相关性' : ($sortBy === 'views' ? '热度' : '时间'); 
                    ?>
                    <a href="<?php 
                        $clearSortUrl = $_SERVER['REQUEST_URI'];
                        $clearSortUrl = preg_replace('/[&?]sort=[^&]*/', '', $clearSortUrl);
                        $clearSortUrl = preg_replace('/\?&/', '?', $clearSortUrl);
                        if (strpos($clearSortUrl, '?') === false && !empty($keyword)) {
                            $clearSortUrl .= '?q=' . urlencode($keyword);
                        }
                        echo htmlspecialchars($clearSortUrl);
                    ?>" class="fa fa-times" title="重置为时间排序"></a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 搜索结果内容区 -->
    <div class="ne-search-content">
        <!-- 搜索结果列表 -->
        <div class="ne-search-results">
            <?php if (!empty($searchResults)): ?>
                <?php foreach ($searchResults as $result): ?>
                <article class="ne-search-item">
                    <?php if (!empty($result['coverImage'])): ?>
                    <div class="ne-search-item-image">
                        <a href="/news.php?id=<?php echo htmlspecialchars($result['id'] ?? ''); ?>">
                            <img src="<?php echo htmlspecialchars($result['coverImage']); ?>" 
                                 alt="<?php echo htmlspecialchars($result['title'] ?? ''); ?>">
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="ne-search-item-info">
                        <h3 class="ne-search-item-title">
                            <a href="/news.php?id=<?php echo htmlspecialchars($result['id'] ?? ''); ?>">
                                <?php echo htmlspecialchars($result['title'] ?? ''); ?>
                            </a>
                        </h3>
                        <?php if (!empty($result['summary'])): ?>
                        <p class="ne-search-item-summary">
                            <?php echo htmlspecialchars($result['summary']); ?>
                        </p>
                        <?php endif; ?>
                        <div class="ne-search-item-meta">
                            <div class="ne-news-meta">
                                <?php if (!empty($result['category'])): ?>
                                <span class="ne-search-item-category">
                                    <a href="/category.html?name=<?php echo urlencode(Utils::categoryToSlug($result['category'])); ?>">
                                        <i class="fas fa-folder"></i> <?php echo htmlspecialchars($result['category']); ?>
                                    </a>
                                </span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($result['publishTime'])): ?>
                            <span class="ne-search-item-time">
                                <i class="far fa-clock"></i> <?php echo date('Y-m-d H:i', strtotime($result['publishTime'])); ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($result['source'])): ?>
                            <span class="ne-search-item-source">
                                <i class="fas fa-newspaper"></i> <?php echo htmlspecialchars($result['source']); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>

                <!-- 分页 -->
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="ne-pagination">
                    <?php echo $pagination; ?>
                </div>
                <?php endif; ?>
            <?php elseif (!empty($keyword)): ?>
                <div class="ne-empty-search">
                    <div class="ne-empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="ne-empty-title">未找到相关结果</h3>
                    <p class="ne-empty-message">
                        没有找到与 "<?php echo htmlspecialchars($keyword); ?>" 相关的新闻。
                    </p>
                    <div class="ne-empty-tips">
                        <p>您可以尝试：</p>
                        <ul>
                            <li>使用更简短、常见的关键词</li>
                            <li>检查关键词拼写是否正确</li>
                            <li>尝试使用相近的词语</li>
                            <li>浏览<a href="/">首页</a>查看最新新闻</li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="ne-search-welcome">
                    <div class="ne-search-welcome-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 class="ne-search-welcome-title">输入关键词搜索新闻</h3>
                    <p class="ne-search-welcome-text">在上方输入框中输入关键词，搜索感兴趣的新闻内容</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- 右侧边栏 -->
        <aside class="ne-search-sidebar">
            <!-- 热门搜索 -->
            <div class="ne-search-hot">
                <h3 class="ne-sidebar-title">
                    <i class="fas fa-fire"></i> 热门搜索
                </h3>
                <?php if (!empty($hotSearches)): ?>
                <ul class="ne-hot-searches">
                    <?php foreach ($hotSearches as $index => $hotSearch): ?>
                    <li class="ne-hot-search-item">
                        <a href="/search.php?q=<?php echo urlencode($hotSearch['keyword']); ?>" class="ne-hot-search-link">
                            <span class="ne-hot-search-num"><?php echo $index + 1; ?></span>
                            <span class="ne-hot-search-text"><?php echo htmlspecialchars($hotSearch['keyword']); ?></span>
                            <?php if (!empty($hotSearch['count'])): ?>
                            <span class="ne-hot-search-count"><?php echo number_format($hotSearch['count']); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="ne-empty-message">暂无热门搜索</p>
                <?php endif; ?>
            </div>

            <!-- 搜索历史 -->
            <div class="ne-search-history">
                <h3 class="ne-sidebar-title">
                    <i class="fas fa-history"></i> 搜索历史
                    <a href="javascript:void(0);" class="ne-search-history-clear" onclick="clearSearchHistory()">
                        <i class="fas fa-trash-alt"></i> 清空
                    </a>
                </h3>
                <div id="searchHistoryContainer">
                    <ul class="ne-search-history-list">
                        <!-- 搜索历史将通过JavaScript动态加载 -->
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- 搜索页面过滤器样式 -->
<style>
.ne-search-filters-page {
    display: flex;
    gap: 15px;
    margin-top: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.ne-search-filter-page {
    padding: 10px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    background: white;
    color: #333;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none;
    min-width: 120px;
}

.ne-search-filter-page:hover,
.ne-search-filter-page:focus {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
}

.ne-search-filter-page option {
    background: white;
    color: #333;
    padding: 5px;
}

/* 移动端适配 */
@media (max-width: 768px) {
    .ne-search-filters-page {
        flex-direction: column;
        gap: 10px;
    }
    
    .ne-search-filter-page {
        width: 100%;
        min-width: auto;
    }
}

/* 当前筛选条件提示 */
.ne-search-current-filters {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
    font-size: 14px;
    color: #666;
}

.ne-search-current-filter {
    background: #f0f0f0;
    padding: 4px 12px;
    border-radius: 15px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.ne-search-current-filter .fa-times {
    cursor: pointer;
    color: #999;
    transition: color 0.2s ease;
}

.ne-search-current-filter .fa-times:hover {
    color: #ff4444;
}
</style>

<!-- 搜索历史处理脚本 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 加载搜索历史
    loadSearchHistory();
    
    // 将当前搜索添加到历史
    <?php if (!empty($keyword)): ?>
    addSearchToHistory('<?php echo addslashes($keyword); ?>');
    <?php endif; ?>
});

// 加载搜索历史
function loadSearchHistory() {
    const historyContainer = document.getElementById('searchHistoryContainer');
    const searchHistory = getSearchHistory();
    
    if (searchHistory.length === 0) {
        historyContainer.innerHTML = '<p class="ne-empty-message">暂无搜索历史</p>';
        return;
    }
    
    let html = '<ul class="ne-search-history-list">';
    searchHistory.forEach(function(item) {
        html += `
            <li class="ne-search-history-item">
                <a href="/search.php?q=${encodeURIComponent(item)}" class="ne-search-history-link">
                    <i class="fas fa-history"></i>
                    <span>${escapeHtml(item)}</span>
                </a>
                <button type="button" class="ne-search-history-remove" onclick="removeSearchFromHistory('${escapeHtml(item)}')">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `;
    });
    html += '</ul>';
    
    historyContainer.innerHTML = html;
}

// 获取搜索历史
function getSearchHistory() {
    const history = localStorage.getItem('ne_search_history');
    return history ? JSON.parse(history) : [];
}

// 添加搜索到历史
function addSearchToHistory(keyword) {
    if (!keyword) return;
    
    let history = getSearchHistory();
    
    // 如果已存在，先移除
    history = history.filter(item => item !== keyword);
    
    // 添加到开头
    history.unshift(keyword);
    
    // 最多保留10个
    if (history.length > 10) {
        history = history.slice(0, 10);
    }
    
    localStorage.setItem('ne_search_history', JSON.stringify(history));
    loadSearchHistory();
}

// 从历史中移除某项
function removeSearchFromHistory(keyword) {
    let history = getSearchHistory();
    history = history.filter(item => item !== keyword);
    localStorage.setItem('ne_search_history', JSON.stringify(history));
    loadSearchHistory();
}

// 清空搜索历史
function clearSearchHistory() {
    if (confirm('确定要清空搜索历史吗？')) {
        localStorage.removeItem('ne_search_history');
        loadSearchHistory();
    }
}

// HTML转义
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script> 