<div class="comments-section mt-5">
    <h3 class="mb-4">评论 (<?php echo isset($comments) ? count($comments) : 0; ?>)</h3>
    
    <!-- 评论表单 -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="comment-form" action="/comment.php" method="POST">
                <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                <div class="mb-3">
                    <label for="comment-name" class="form-label">您的昵称</label>
                    <input type="text" class="form-control" id="comment-name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="comment-email" class="form-label">电子邮箱（不会公开）</label>
                    <input type="email" class="form-control" id="comment-email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="comment-content" class="form-label">评论内容</label>
                    <textarea class="form-control" id="comment-content" name="content" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">提交评论</button>
            </form>
        </div>
    </div>
    
    <!-- 评论列表 -->
    <?php if (empty($comments)): ?>
        <div class="alert alert-info">暂无评论，快来发表第一条评论吧！</div>
    <?php else: ?>
        <div class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item card mb-3">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="comment-avatar me-3">
                                <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <?php echo strtoupper(substr($comment['name'], 0, 1)); ?>
                                </div>
                            </div>
                            <div class="comment-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0"><?php echo htmlspecialchars($comment['name']); ?></h5>
                                    <small class="text-muted"><?php echo Utils::formatDateTime($comment['createTime']); ?></small>
                                </div>
                                <p class="mb-2"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                <div class="comment-actions">
                                    <button class="btn btn-sm btn-link p-0 reply-btn" data-comment-id="<?php echo $comment['id']; ?>">
                                        <i class="far fa-comment-dots"></i> 回复
                                    </button>
                                    <button class="btn btn-sm btn-link p-0 ms-3 like-btn" data-comment-id="<?php echo $comment['id']; ?>">
                                        <i class="far fa-thumbs-up"></i> 
                                        <span class="like-count"><?php echo isset($comment['likeCount']) ? $comment['likeCount'] : 0; ?></span>
                                    </button>
                                </div>
                                
                                <!-- 回复表单，默认隐藏 -->
                                <div class="reply-form mt-3" id="reply-form-<?php echo $comment['id']; ?>" style="display: none;">
                                    <form action="/comment.php" method="POST">
                                        <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                                        <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">回复 <?php echo htmlspecialchars($comment['name']); ?></label>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="name" placeholder="您的昵称" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control" name="email" placeholder="电子邮箱（不会公开）" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" name="content" rows="3" required></textarea>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-2 cancel-reply-btn">取消</button>
                                            <button type="submit" class="btn btn-sm btn-primary">提交回复</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- 回复列表 -->
                                <?php if (isset($comment['replies']) && !empty($comment['replies'])): ?>
                                    <div class="replies-list mt-3">
                                        <?php foreach ($comment['replies'] as $reply): ?>
                                            <div class="reply-item card mt-2">
                                                <div class="card-body py-2 px-3">
                                                    <div class="d-flex">
                                                        <div class="reply-avatar me-2">
                                                            <div class="avatar-placeholder rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                                <?php echo strtoupper(substr($reply['name'], 0, 1)); ?>
                                                            </div>
                                                        </div>
                                                        <div class="reply-content flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <h6 class="mb-0"><?php echo htmlspecialchars($reply['name']); ?></h6>
                                                                <small class="text-muted"><?php echo Utils::formatDateTime($reply['createTime']); ?></small>
                                                            </div>
                                                            <p class="mb-1 small"><?php echo nl2br(htmlspecialchars($reply['content'])); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 回复按钮点击事件
    document.querySelectorAll('.reply-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('reply-form-' + commentId);
            
            // 隐藏所有其他回复表单
            document.querySelectorAll('.reply-form').forEach(function(form) {
                if (form.id !== 'reply-form-' + commentId) {
                    form.style.display = 'none';
                }
            });
            
            // 切换当前回复表单的显示状态
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });
    
    // 取消回复按钮点击事件
    document.querySelectorAll('.cancel-reply-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const replyForm = this.closest('.reply-form');
            replyForm.style.display = 'none';
        });
    });
    
    // 点赞按钮点击事件
    document.querySelectorAll('.like-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const likeCountElement = this.querySelector('.like-count');
            let likeCount = parseInt(likeCountElement.textContent);
            
            // 发送点赞请求
            fetch('/like_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'comment_id=' + commentId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCountElement.textContent = data.likeCount;
                    this.classList.add('text-primary');
                    this.querySelector('i').className = 'fas fa-thumbs-up';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script> 