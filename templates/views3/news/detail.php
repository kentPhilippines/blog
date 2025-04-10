<?php
/**
 * 网易新闻风格的新闻详情页模板
 */
// 处理API代理请求
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_GET['action'] ?? '';
        
        if ($action === 'like') {
            $commentId = $_GET['id'] ?? 0;
            if ($commentId) {
                $ch = curl_init(API_BASE_URL . '/admin/comment/like/' . $commentId);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                curl_close($ch);
                
                if ($response !== false) {
                    http_response_code($httpCode);
                    echo $response;
                } else {
                    http_response_code(500);
                    echo json_encode(['code' => 500, 'message' => '请求失败']);
                }
                exit;
            }
        } elseif ($action === 'comment') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if ($data) {
                $ch = curl_init(API_BASE_URL . '/admin/comment/save');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                curl_close($ch);
                
                if ($response !== false) {
                    http_response_code($httpCode);
                    echo $response;
                } else {
                    http_response_code(500);
                    echo json_encode(['code' => 500, 'message' => '请求失败']);
                }
                exit;
            }
        }
    }
    
    http_response_code(400);
    echo json_encode(['code' => 400, 'message' => '无效请求']);
    exit;
}
?>
<div class="ne-news-detail">
    <!-- 文章与相关新闻的左右布局 -->
    <div class="ne-content">
        <!-- 文章主体部分 -->
        <article class="ne-article">
            <!-- 文章头部 -->
            <div class="ne-article-header">
                <h1 class="ne-article-title">
                    <?php echo htmlspecialchars($news['title'] ?? ''); ?>
                </h1>
                <div class="ne-article-meta">
                    <?php if (!empty($news['source'])): ?>
                    <span class="ne-article-source">
                        <?php echo htmlspecialchars($news['source']); ?>
                    </span>
                    <?php endif; ?>
                    <?php if (!empty($news['publishTime'])): ?>
                    <span class="ne-article-time">
                        <?php echo date('Y-m-d H:i', strtotime($news['publishTime'])); ?>
                    </span>
                    <?php endif; ?>
                    <?php if (!empty($news['author'])): ?>
                    <span class="ne-article-author">
                        <?php echo htmlspecialchars($news['author']); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 文章摘要 -->
            <?php if (!empty($news['summary'])): ?>
            <div class="ne-article-summary">
                <?php echo htmlspecialchars($news['summary']); ?>
            </div>
            <?php endif; ?>

            <!-- 文章图片 -->
            <?php if (!empty($news['image'])): ?>
            <div class="ne-article-image">
                <img src="<?php echo htmlspecialchars($news['image']); ?>" 
                     alt="<?php echo htmlspecialchars($news['title'] ?? ''); ?>">
                <?php if (!empty($news['imageCaption'])): ?>
                <div class="ne-image-caption">
                    <?php echo htmlspecialchars($news['imageCaption']); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- 文章内容 -->
            <div class="ne-article-content">
                <?php echo $news['content'] ?? ''; ?>
            </div>

            <!-- 文章标签 -->
            <?php if (!empty($news['tags'])): ?>
            <div class="ne-article-tags">
                <?php foreach ($news['tags'] as $tag): ?>
                <a href="/tag.php?name=<?php echo urlencode($tag); ?>" class="ne-tag">
                    <?php echo htmlspecialchars($tag); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </article>

        <!-- 侧边栏 -->
        <aside class="ne-sidebar">
            <!-- 相关新闻 -->
            <?php if (!empty($relatedNews)): ?>
            <div class="ne-related-news">
                <h3 class="ne-sidebar-title">
                    <i class="iconfont icon-related"></i> 相关新闻
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

            <!-- 热门标签 -->
            <?php if (!empty($hotTags)): ?>
            <div class="ne-hot-tags">
                <h3 class="ne-sidebar-title">
                    <i class="iconfont icon-tag"></i> 热门标签
                </h3>
                <div class="ne-tag-cloud">
                    <?php foreach ($hotTags as $tag): ?>
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
        </aside>
    </div>
    
    <!-- 评论区（放在底部） -->
    <div class="ne-comments-section">
        <div class="ne-comments" id="ne-comments">
            <h3 class="ne-section-title">评论</h3>
            
            <!-- 评论排序 -->
            <div class="ne-comment-sort">
                <div class="ne-comment-sort-item active" data-sort="newest">最新</div>
                <div class="ne-comment-sort-item" data-sort="hottest">最热</div>
            </div>
            
            <!-- 评论表单 -->
            <form id="commentForm" class="ne-comment-form" onsubmit="return handleSubmitComment(event)">
                <div class="ne-comment-input-group">
                    <label for="ne-comment-nickname">昵称</label>
                    <input type="text" id="ne-comment-nickname" name="nickname" class="ne-comment-input" placeholder="请输入您的昵称" required>
                </div>
                
                <textarea class="ne-comment-textarea" id="ne-comment-content" name="content" placeholder="请输入您的评论..." required></textarea>
                
                <div class="ne-comment-form-footer">
                    <div class="ne-comment-tips">请文明发言，共建和谐社区</div>
                    <button type="submit" class="ne-comment-submit">发表评论</button>
                </div>
            </form>
            
            <!-- 评论列表 -->
            <div class="ne-comment-list">
                <?php
                // 获取当前页码
                $pageNum = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $pageSize = 10;
                
                // 构建完整的API URL
                $apiUrl = API_BASE_URL . "/api/news/{$news['id']}/comments?pageNum={$pageNum}&pageSize={$pageSize}";
                
                // 发起API请求
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                
                $response = curl_exec($ch);
                
                if($response === false) {
                    // 记录错误信息
                    error_log('Curl error: ' . curl_error($ch));
                    $response = json_encode(['code' => 500, 'message' => '请求失败']);
                }
                
                curl_close($ch);
                // 解析响应数据
                $result = json_decode($response, true);
                // 打印API响应数据用于调试
                if ($result && $result['code'] === 200 && !empty($result['data']['list'])) {
                    foreach ($result['data']['list'] as $comment) {
                        $initial = mb_substr($comment['commenterName'], 0, 1);
                        $commentTime = date('Y-m-d H:i', strtotime($comment['commentTime']));
                        ?>
                        <div class="ne-comment" data-id="<?php echo $comment['id']; ?>">
                            <div class="ne-comment-img"><?php echo htmlspecialchars($initial); ?></div>
                            <div class="ne-comment-body">
                                <div class="ne-comment-info">
                                    <div class="ne-comment-name"><?php echo htmlspecialchars($comment['commenterName']); ?></div>
                                    <div class="ne-comment-date"><?php echo $commentTime; ?></div>
                                </div>
                                <div class="ne-comment-content"><?php echo htmlspecialchars($comment['content']); ?></div>
                                <div class="ne-comment-actions">
                                    <button onclick="handleLikeComment(<?php echo $comment['id']; ?>)" class="ne-comment-action <?php echo isset($comment['liked']) && $comment['liked'] ? 'liked' : ''; ?>">
                                        <i class="<?php echo isset($comment['liked']) && $comment['liked'] ? 'fas' : 'far'; ?> fa-thumbs-up"></i>
                                        <span class="like-count"><?php echo $comment['likeCount']; ?></span>
                                    </button>
                                    <div class="ne-comment-action" onclick="replyToComment('<?php echo htmlspecialchars($comment['commenterName']); ?>')">
                                        <i class="far fa-comment"></i> 回复
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    
                    // 分页
                    if ($result['data']['pages'] > 1) {
                        ?>
                        <div class="ne-pagination">
                            <?php if ($pageNum > 1): ?>
                                <a href="javascript:void(0)" onclick="loadComments(<?php echo ($pageNum - 1); ?>)" class="ne-page-link">上一页</a>
                            <?php endif; ?>
                            
                            <?php
                            $totalPages = $result['data']['pages'];
                            $startPage = max(1, $pageNum - 2);
                            $endPage = min($totalPages, $pageNum + 2);
                            
                            if ($startPage > 1) {
                                echo '<a href="javascript:void(0)" onclick="loadComments(1)" class="ne-page-link">1</a>';
                                if ($startPage > 2) {
                                    echo '<span class="ellipsis">...</span>';
                                }
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                if ($i == $pageNum) {
                                    echo "<span class=\"current\">{$i}</span>";
                                } else {
                                    echo "<a href=\"javascript:void(0)\" onclick=\"loadComments({$i})\" class=\"ne-page-link\">{$i}</a>";
                                }
                            }
                            
                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) {
                                    echo '<span class="ellipsis">...</span>';
                                }
                                echo "<a href=\"javascript:void(0)\" onclick=\"loadComments({$totalPages})\" class=\"ne-page-link\">{$totalPages}</a>";
                            }
                            
                            if ($pageNum < $totalPages): ?>
                                <a href="javascript:void(0)" onclick="loadComments(<?php echo ($pageNum + 1); ?>)" class="ne-page-link">下一页</a>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="ne-comment-empty">
                        <div class="ne-comment-empty-icon"><i class="far fa-comment-dots"></i></div>
                        <div class="ne-comment-empty-text">暂无评论，快来发表第一条评论吧！</div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- 添加页面样式 -->
<style>
.ne-news-detail {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.ne-content {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 300px;
    gap: 30px;
    margin-bottom: 40px;
}

/* 文章主体样式 */
.ne-article {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 30px;
}

.ne-article-header {
    margin-bottom: 24px;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.ne-article-title {
    font-size: 28px;
    line-height: 1.4;
    color: #333;
    margin: 0 0 16px;
    font-weight: 600;
}

.ne-article-meta {
    color: #666;
    font-size: 14px;
    display: flex;
    gap: 16px;
    align-items: center;
}

.ne-article-meta span {
    display: flex;
    align-items: center;
}

.ne-article-meta i {
    margin-right: 4px;
}

.ne-article-summary {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    background: #f8f9fa;
    padding: 16px;
    border-radius: 6px;
    margin-bottom: 24px;
}

.ne-article-image {
    margin-bottom: 24px;
    border-radius: 8px;
    overflow: hidden;
}

.ne-article-image img {
    width: 100%;
    height: auto;
    display: block;
}

.ne-image-caption {
    font-size: 14px;
    color: #666;
    text-align: center;
    padding: 8px;
    background: #f8f9fa;
}

.ne-article-content {
    font-size: 16px;
    line-height: 1.8;
    color: #333;
}

.ne-article-content p {
    margin-bottom: 16px;
}

.ne-article-tags {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.ne-tag {
    display: inline-block;
    padding: 4px 12px;
    background: #f0f2f5;
    color: #666;
    border-radius: 16px;
    font-size: 13px;
    margin: 0 8px 8px 0;
    text-decoration: none;
    transition: all 0.3s ease;
}

.ne-tag:hover {
    background: #e4e6e9;
    color: #333;
}

/* 侧边栏样式 */
.ne-sidebar {
    position: sticky;
    top: 20px;
}

.ne-sidebar > div {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 20px;
    margin-bottom: 20px;
}

.ne-sidebar-title {
    font-size: 18px;
    color: #333;
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ne-related-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.ne-related-item {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #f0f2f5;
}

.ne-related-item:last-child {
    border-bottom: none;
}

.ne-related-num {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    background: #f0f2f5;
    color: #666;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    margin-right: 12px;
}

.ne-related-top .ne-related-num {
    background: #ff6b6b;
    color: #fff;
}

.ne-related-link {
    color: #333;
    text-decoration: none;
    font-size: 14px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.3s ease;
}

.ne-related-link:hover {
    color: #1a73e8;
}

.ne-tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.ne-tag-item {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    background: #f0f2f5;
    color: #666;
    border-radius: 16px;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.ne-tag-item:hover {
    background: #e4e6e9;
    color: #333;
}

.ne-tag-count {
    margin-left: 6px;
    font-size: 12px;
    color: #999;
}

/* 评论区样式优化 */
.ne-comments-section {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    padding: 24px;
    margin-top: 30px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.ne-section-title {
    font-size: 20px;
    color: #2c3e50;
    margin: 0 0 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f2f5;
    font-weight: 600;
}

.ne-comment-sort {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    padding: 0 4px;
}

.ne-comment-sort-item {
    cursor: pointer;
    color: #7f8c8d;
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 16px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.ne-comment-sort-item:hover {
    color: #2c3e50;
    background: #f8f9fa;
}

.ne-comment-sort-item.active {
    background: #e3f2fd;
    color: #1a73e8;
}

.ne-comment-form {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 24px;
}

.ne-comment-input-group {
    margin-bottom: 16px;
}

.ne-comment-input-group label {
    font-size: 14px;
    margin-bottom: 6px;
}

.ne-comment-input {
    padding: 8px 12px;
    border: 1px solid #e0e3e7;
    border-radius: 6px;
    font-size: 14px;
}

.ne-comment-textarea {
    min-height: 100px;
    padding: 12px;
    border: 1px solid #e0e3e7;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 16px;
}

.ne-comment-submit {
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 14px;
}

.ne-comment {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #f0f2f5;
}

.ne-comment-img {
    width: 40px;
    height: 40px;
    font-size: 16px;
}

.ne-comment-info {
    margin-bottom: 8px;
}

.ne-comment-name {
    font-size: 15px;
}

.ne-comment-date {
    font-size: 13px;
}

.ne-comment-content {
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 12px;
}

.ne-comment-actions {
    gap: 16px;
}

.ne-comment-action {
    font-size: 13px;
    padding: 4px 10px;
}

.ne-pagination {
    margin-top: 24px;
    padding-top: 16px;
}

.ne-pagination a,
.ne-pagination span {
    min-width: 32px;
    height: 32px;
    padding: 0 12px;
    font-size: 13px;
}

/* 响应式布局优化 */
@media (max-width: 1024px) {
    .ne-content {
        grid-template-columns: 1fr;
    }
    
    .ne-sidebar {
        position: static;
        margin-top: 20px;
    }
}

@media (max-width: 768px) {
    .ne-news-detail {
        padding: 12px;
    }
    
    .ne-article {
        padding: 20px;
    }
    
    .ne-article-title {
        font-size: 22px;
        margin-bottom: 12px;
    }
    
    .ne-article-meta {
        flex-wrap: wrap;
        gap: 12px;
        font-size: 13px;
    }
    
    .ne-article-summary {
        font-size: 15px;
        padding: 12px;
        margin-bottom: 20px;
    }
    
    .ne-article-content {
        font-size: 15px;
        line-height: 1.6;
    }
    
    .ne-article-tags {
        margin-top: 20px;
        padding-top: 16px;
    }
    
    .ne-tag {
        padding: 3px 10px;
        font-size: 12px;
        margin: 0 6px 6px 0;
    }
    
    .ne-sidebar > div {
        padding: 16px;
        margin-bottom: 16px;
    }
    
    .ne-sidebar-title {
        font-size: 16px;
        margin-bottom: 12px;
        padding-bottom: 10px;
    }
    
    .ne-related-item {
        padding: 10px 0;
    }
    
    .ne-related-link {
        font-size: 13px;
    }
    
    .ne-tag-item {
        padding: 4px 10px;
        font-size: 12px;
    }
    
    .ne-comments-section {
        padding: 16px;
        margin-top: 20px;
        border-radius: 8px;
    }
    
    .ne-section-title {
        font-size: 18px;
        margin-bottom: 16px;
        padding-bottom: 10px;
    }
    
    .ne-comment-sort {
        gap: 12px;
        margin-bottom: 16px;
    }
    
    .ne-comment-sort-item {
        padding: 4px 10px;
        font-size: 13px;
    }
    
    .ne-comment-form {
        padding: 12px;
        margin-bottom: 16px;
    }
    
    .ne-comment-input-group {
        margin-bottom: 12px;
    }
    
    .ne-comment-input,
    .ne-comment-textarea {
        width: 100%;
        box-sizing: border-box;
    }
    
    .ne-comment-textarea {
        min-height: 80px;
    }
    
    .ne-comment {
        padding: 12px 0;
        gap: 10px;
    }
    
    .ne-comment-img {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .ne-comment-name {
        font-size: 14px;
    }
    
    .ne-comment-date {
        font-size: 12px;
    }
    
    .ne-comment-content {
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .ne-comment-actions {
        display: flex;
        gap: 12px;
    }
    
    .ne-comment-action {
        font-size: 12px;
        padding: 3px 8px;
    }
    
    .ne-pagination {
        margin-top: 20px;
        padding-top: 12px;
    }
    
    .ne-pagination a,
    .ne-pagination span {
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .ne-news-detail {
        padding: 8px;
    }
    
    .ne-article {
        padding: 16px;
        border-radius: 6px;
    }
    
    .ne-article-title {
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .ne-article-meta {
        gap: 8px;
        font-size: 12px;
    }
    
    .ne-article-summary {
        font-size: 14px;
        padding: 10px;
        margin-bottom: 16px;
    }
    
    .ne-article-content {
        font-size: 14px;
        line-height: 1.5;
    }
    
    .ne-comments-section {
        padding: 12px;
        margin-top: 16px;
    }
    
    .ne-comment-form-footer {
        flex-direction: column;
        gap: 12px;
    }
    
    .ne-comment-tips {
        text-align: center;
        font-size: 12px;
    }
    
    .ne-comment-submit {
        width: 100%;
        padding: 8px;
    }
    
    .ne-comment-actions {
        flex-wrap: wrap;
        gap: 8px;
    }
}

/* 添加评论加载相关样式 */
.ne-comment-loading,
.ne-comment-error {
    text-align: center;
    padding: 20px;
    color: #666;
}

.ne-comment-loading {
    color: #1a73e8;
}

.ne-comment-error {
    color: #dc3545;
}

.ne-page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 12px;
    margin: 0 4px;
    border-radius: 16px;
    background: #f0f2f5;
    color: #666;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s ease;
}

.ne-page-link:hover {
    background: #e4e6e9;
    color: #333;
}

.ne-pagination .current {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 12px;
    margin: 0 4px;
    border-radius: 16px;
    background: #1a73e8;
    color: #fff;
    font-size: 13px;
}

.ne-pagination .ellipsis {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    color: #666;
    font-size: 13px;
}
</style>

<!-- 评论功能的JavaScript代码 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 加载评论
    window.loadComments = async function(page) {
        const commentList = document.querySelector('.ne-comment-list');
        const newsId = '<?php echo $news['id']; ?>';
        
        try {
            // 显示加载中状态
            commentList.innerHTML = '<div class="ne-comment-loading">加载中...</div>';
            
            const response = await fetch(`/api_proxy.php?action=comments&newsId=${newsId}&page=${page}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const result = await response.json();
            
            if (response.ok && result.code === 200) {
                let html = '';
                
                if (result.data.list && result.data.list.length > 0) {
                    // 渲染评论列表
                    result.data.list.forEach(comment => {
                        const initial = comment.commenterName.charAt(0);
                        const commentTime = new Date(comment.commentTime).toLocaleString('zh-CN', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        
                        html += `
                            <div class="ne-comment" data-id="${comment.id}">
                                <div class="ne-comment-img">${initial}</div>
                                <div class="ne-comment-body">
                                    <div class="ne-comment-info">
                                        <div class="ne-comment-name">${comment.commenterName}</div>
                                        <div class="ne-comment-date">${commentTime}</div>
                                    </div>
                                    <div class="ne-comment-content">${comment.content}</div>
                                    <div class="ne-comment-actions">
                                        <button onclick="handleLikeComment(${comment.id})" class="ne-comment-action ${comment.liked ? 'liked' : ''}">
                                            <i class="${comment.liked ? 'fas' : 'far'} fa-thumbs-up"></i>
                                            <span class="like-count">${comment.likeCount}</span>
                                        </button>
                                        <div class="ne-comment-action" onclick="replyToComment('${comment.commenterName}')">
                                            <i class="far fa-comment"></i> 回复
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // 添加分页
                    if (result.data.pages > 1) {
                        html += '<div class="ne-pagination">';
                        if (page > 1) {
                            html += `<a href="javascript:void(0)" onclick="loadComments(${page - 1})" class="ne-page-link">上一页</a>`;
                        }
                        
                        const totalPages = result.data.pages;
                        const startPage = Math.max(1, page - 2);
                        const endPage = Math.min(totalPages, page + 2);
                        
                        if (startPage > 1) {
                            html += `<a href="javascript:void(0)" onclick="loadComments(1)" class="ne-page-link">1</a>`;
                            if (startPage > 2) {
                                html += '<span class="ellipsis">...</span>';
                            }
                        }
                        
                        for (let i = startPage; i <= endPage; i++) {
                            if (i === page) {
                                html += `<span class="current">${i}</span>`;
                            } else {
                                html += `<a href="javascript:void(0)" onclick="loadComments(${i})" class="ne-page-link">${i}</a>`;
                            }
                        }
                        
                        if (endPage < totalPages) {
                            if (endPage < totalPages - 1) {
                                html += '<span class="ellipsis">...</span>';
                            }
                            html += `<a href="javascript:void(0)" onclick="loadComments(${totalPages})" class="ne-page-link">${totalPages}</a>`;
                        }
                        
                        if (page < totalPages) {
                            html += `<a href="javascript:void(0)" onclick="loadComments(${page + 1})" class="ne-page-link">下一页</a>`;
                        }
                        html += '</div>';
                    }
                } else {
                    html = `
                        <div class="ne-comment-empty">
                            <div class="ne-comment-empty-icon"><i class="far fa-comment-dots"></i></div>
                            <div class="ne-comment-empty-text">暂无评论，快来发表第一条评论吧！</div>
                        </div>
                    `;
                }
                
                commentList.innerHTML = html;
                
                // 滚动到评论区顶部
                document.querySelector('.ne-comments-section').scrollIntoView({ behavior: 'smooth' });
            } else {
                commentList.innerHTML = '<div class="ne-comment-error">加载评论失败，请稍后重试</div>';
            }
        } catch (error) {
            console.error('加载评论出错：', error);
            commentList.innerHTML = '<div class="ne-comment-error">加载评论失败，请稍后重试</div>';
        }
    };

    // 处理评论提交
    window.handleSubmitComment = async function(event) {
        event.preventDefault();
        
        const form = event.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const nickname = document.getElementById('ne-comment-nickname').value.trim();
        const content = document.getElementById('ne-comment-content').value.trim();
        
        if (!nickname || !content) {
            alert('请填写昵称和评论内容');
            return false;
        }
        
        // 禁用提交按钮
        submitButton.disabled = true;
        submitButton.textContent = '提交中...';
        
        try {
            const response = await fetch('/api_proxy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    path: '/admin/comment/save',
                    method: 'POST',
                    data: {
                        newsId: '<?php echo $news['id']; ?>',
                        content: content,
                        commenterName: nickname,
                        domainConfig: window.location.hostname
                    }
                })
            });
            
            const result = await response.json();
            
            if (response.ok && result.code === 200) {
                // 评论成功，刷新页面显示新评论
                window.location.reload();
            } else {
                alert('评论提交失败：' + (result.message || '未知错误'));
            }
        } catch (error) {
            console.error('评论提交出错：', error);
            alert('评论提交失败，请稍后重试');
        } finally {
            // 恢复提交按钮状态
            submitButton.disabled = false;
            submitButton.textContent = '发表评论';
        }
        
        return false;
    };
    
    // 处理点赞
    window.handleLikeComment = async function(commentId) {
        const likeButton = event.target.closest('.ne-comment-action');
        const likeCount = likeButton.querySelector('.like-count');
        const icon = likeButton.querySelector('i');
        
        try {
            const response = await fetch('/api_proxy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    path: `/admin/comment/like/${commentId}`,
                    method: 'POST'
                })
            });
            
            const result = await response.json();
            
            if (response.ok && result.code === 200) {
                // 点赞成功，更新UI
                likeButton.classList.toggle('liked');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                
                // 更新点赞数
                if (result.data && typeof result.data.likeCount !== 'undefined') {
                    likeCount.textContent = result.data.likeCount;
                } else {
                    // 如果API没有返回新的点赞数，则+1
                    likeCount.textContent = parseInt(likeCount.textContent || 0) + 1;
                }
            } else {
                alert('点赞失败：' + (result.message || '未知错误'));
            }
        } catch (error) {
            console.error('点赞出错：', error);
            alert('点赞失败，请稍后重试');
        }
    };
    
    // 回复评论
    window.replyToComment = function(nickname) {
        const textarea = document.getElementById('ne-comment-content');
        textarea.value = `@${nickname}: `;
        textarea.focus();
        textarea.scrollIntoView({ behavior: 'smooth' });
    };
});
</script> 