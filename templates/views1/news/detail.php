<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- 新闻详情 -->
            <article class="news-detail">
                <header class="mb-4">
                    <h1 class="news-title"><?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '无标题'; ?></h1>
                    
                    <?php if (isset($news['subtitle']) && !empty($news['subtitle'])): ?>
                        <h2 class="news-subtitle text-muted"><?php echo htmlspecialchars($news['subtitle']); ?></h2>
                    <?php endif; ?>
                    
                    <div class="news-meta mb-3">
                        <?php if (isset($news['categoryName'])): ?>
                            <span class="badge bg-primary me-2"><?php echo htmlspecialchars($news['categoryName']); ?></span>
                        <?php endif; ?>
                        
                        <?php if (isset($news['publishTime'])): ?>
                            <span class="text-muted me-3"><i class="far fa-clock"></i> <?php echo Utils::formatDateTime($news['publishTime']); ?></span>
                        <?php endif; ?>
                        
                        <?php if (isset($news['author'])): ?>
                            <span class="text-muted me-3"><i class="far fa-user"></i> <?php echo htmlspecialchars($news['author']); ?></span>
                        <?php endif; ?>
                        
                        <?php if (isset($news['source'])): ?>
                            <span class="text-muted me-3"><i class="far fa-newspaper"></i> 来源：<?php echo htmlspecialchars($news['source']); ?></span>
                        <?php endif; ?>
                        
                        <?php if (isset($news['viewCount'])): ?>
                            <span class="text-muted me-3"><i class="far fa-eye"></i> <?php echo $news['viewCount']; ?>次阅读</span>
                        <?php endif; ?>
                    </div>
                </header>
                
                <?php if (isset($news['summary']) && !empty($news['summary'])): ?>
                    <div class="news-summary mb-4">
                        <blockquote class="blockquote">
                            <p class="lead"><?php echo htmlspecialchars($news['summary']); ?></p>
                        </blockquote>
                    </div>
                <?php endif; ?>
                
                <?php
                // 显示封面图
                $coverImage = null;
                if (isset($news['images']) && is_array($news['images'])) {
                    foreach ($news['images'] as $image) {
                        if (isset($image['isCover']) && $image['isCover']) {
                            $coverImage = $image;
                            break;
                        }
                    }
                }
                
                if ($coverImage): 
                ?>
                    <div class="news-cover-image mb-4">
                        <img src="<?php echo $coverImage['url']; ?>" class="img-fluid rounded" alt="<?php echo isset($news['title']) ? htmlspecialchars($news['title']) : '新闻图片'; ?>">
                    </div>
                <?php endif; ?>
                
                <div class="news-content mb-4">
                    <?php 
                    if (isset($news['contentHtml']) && !empty($news['contentHtml'])) {
                        echo $news['contentHtml'];
                    } elseif (isset($news['content']) && !empty($news['content'])) {
                        echo nl2br(htmlspecialchars($news['content']));
                    } else {
                        echo '<p class="text-muted">暂无内容</p>';
                    }
                    ?>
                </div>
                
                <?php if (isset($news['tags']) && is_array($news['tags']) && !empty($news['tags'])): ?>
                    <div class="news-tags mb-4">
                        <h5>标签：</h5>
                        <div class="d-flex flex-wrap">
                            <?php foreach ($news['tags'] as $tag): ?>
                                <a href="/tag.php?name=<?php echo urlencode(isset($tag['name']) ? $tag['name'] : ''); ?>" class="badge bg-secondary me-2 mb-2 p-2">
                                    <?php echo isset($tag['name']) ? htmlspecialchars($tag['name']) : '未命名标签'; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="news-actions d-flex justify-content-between mb-4">
                    <div>
                        <button class="btn btn-outline-primary me-2" id="likeBtn">
                            <i class="far fa-thumbs-up"></i> 
                            赞 <span id="likeCount"><?php echo isset($news['likeCount']) ? $news['likeCount'] : 0; ?></span>
                        </button>
                        
                        <button class="btn btn-outline-primary" id="shareBtn">
                            <i class="far fa-share-square"></i> 分享
                        </button>
                    </div>
                    
                    <?php if (isset($news['url']) && !empty($news['url'])): ?>
                        <a href="<?php echo $news['url']; ?>" target="_blank" class="btn btn-outline-secondary">
                            <i class="fas fa-external-link-alt"></i> 查看原文
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- 相关新闻 -->
                <?php if (!empty($relatedNews)): ?>
                    <div class="related-news mb-4">
                        <h3 class="mb-3">相关新闻</h3>
                        <div class="row">
                            <?php foreach ($relatedNews as $related): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <?php if (isset($related['coverImage']) && !empty($related['coverImage'])): ?>
                                            <img src="<?php echo $related['coverImage']; ?>" class="card-img-top" alt="<?php echo isset($related['title']) ? htmlspecialchars($related['title']) : '无标题'; ?>">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="/news.php?id=<?php echo isset($related['id']) ? $related['id'] : 0; ?>" class="text-decoration-none">
                                                    <?php echo isset($related['title']) ? htmlspecialchars($related['title']) : '无标题'; ?>
                                                </a>
                                            </h5>
                                            <div class="small text-muted">
                                                <span><i class="far fa-clock"></i> <?php echo isset($related['publishTime']) ? Utils::getRelativeTime($related['publishTime']) : '未知时间'; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- 评论区 -->
                <div class="comments-section">
                    <h3 class="mb-3">评论 (<?php echo isset($news['commentCount']) ? $news['commentCount'] : 0; ?>)</h3>
                    
                    <!-- 评论表单 -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="commentForm">
                                <div class="mb-3">
                                    <textarea class="form-control" id="commentContent" rows="3" placeholder="发表您的评论..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">提交评论</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- 评论列表 -->
                    <div id="commentsList">
                        <div class="text-center">
                            <p class="text-muted">评论功能正在开发中...</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        
        <div class="col-md-4">
            <?php include VIEWS_PATH . '/partials/sidebar.php'; ?>
        </div>
    </div>
</div>

<style>
.news-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.news-subtitle {
    font-size: 1.5rem;
    font-weight: 400;
    margin-bottom: 1rem;
}

.news-summary {
    background-color: #f8f9fa;
    border-left: 4px solid #0d6efd;
    padding: 1rem;
}

.news-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.news-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
}

.news-tags .badge {
    font-size: 0.9rem;
}

.comments-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #dee2e6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 点赞功能
    const likeBtn = document.getElementById('likeBtn');
    const likeCount = document.getElementById('likeCount');
    
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            const currentCount = parseInt(likeCount.textContent);
            likeCount.textContent = currentCount + 1;
            
            likeBtn.classList.remove('btn-outline-primary');
            likeBtn.classList.add('btn-primary');
            likeBtn.disabled = true;
            
            // 这里可以添加AJAX请求，将点赞信息发送到服务器
        });
    }
    
    // 分享功能
    const shareBtn = document.getElementById('shareBtn');
    
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo isset($news['title']) ? addslashes(htmlspecialchars($news['title'])) : '分享新闻'; ?>',
                    text: '<?php echo isset($news['summary']) ? addslashes(htmlspecialchars($news['summary'])) : ''; ?>',
                    url: window.location.href
                })
                .catch(error => console.log('分享失败:', error));
            } else {
                // 复制链接到剪贴板
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = window.location.href;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                
                alert('链接已复制到剪贴板，您可以粘贴分享给好友');
            }
        });
    }
    
    // 评论表单提交
    const commentForm = document.getElementById('commentForm');
    
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const commentContent = document.getElementById('commentContent').value;
            
            if (!commentContent.trim()) {
                alert('评论内容不能为空');
                return;
            }
            
            // 这里可以添加AJAX请求，将评论发送到服务器
            alert('评论功能正在开发中，感谢您的支持！');
            document.getElementById('commentContent').value = '';
        });
    }
});
</script> 