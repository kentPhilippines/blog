<div class="container py-4 fade-in">
    <div class="row">
        <!-- 主内容区 -->
        <div class="col-lg-8">
            <!-- 新闻详情 -->
            <article class="news-detail mb-4">
                <header class="news-header mb-4">
                    <h1 class="news-title mb-3"><?php echo htmlspecialchars($news['title']); ?></h1>
                    
                    <div class="news-meta d-flex flex-wrap align-items-center text-white-50 small">
                        <!-- 分类 -->
                        <div class="me-3 mb-2">
                            <a href="/category.php?name=<?php echo urlencode($news['categoryName']); ?>" class="text-primary-light text-decoration-none">
                                <i class="mdi mdi-folder-outline me-1"></i><?php echo htmlspecialchars($news['categoryName']); ?>
                            </a>
                        </div>
                        
                        <!-- 发布时间 -->
                        <div class="me-3 mb-2">
                            <i class="mdi mdi-calendar-outline me-1"></i>
                            <?php echo date('Y-m-d H:i', strtotime($news['publishTime'])); ?>
                        </div>
                        
                        <!-- 阅读量 -->
                        <div class="me-3 mb-2">
                            <i class="mdi mdi-eye-outline me-1"></i>
                            <?php echo $news['viewCount']; ?> 阅读
                        </div>
                        
                        <!-- 来源 -->
                        <?php if (isset($news['source']) && !empty($news['source'])): ?>
                        <div class="mb-2">
                            <i class="mdi mdi-link-variant me-1"></i>
                            来源: <?php echo htmlspecialchars($news['source']); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </header>
                
                <!-- 文章特色图片 -->
                <?php if (isset($news['coverImage']) && !empty($news['coverImage'])): ?>
                <div class="news-featured-image mb-4">
                    <img src="<?php echo htmlspecialchars($news['coverImage']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>" class="img-fluid rounded">
                </div>
                <?php endif; ?>
                
                <!-- 文章摘要 -->
                <?php if (isset($news['summary']) && !empty($news['summary'])): ?>
                <div class="news-summary mb-4 p-3 rounded" style="background-color: rgba(187, 134, 252, 0.1); border-left: 4px solid var(--primary-light);">
                    <p class="mb-0 fst-italic"><?php echo htmlspecialchars($news['summary']); ?></p>
                </div>
                <?php endif; ?>
                
                <!-- 文章内容 -->
                <div class="news-content mb-4">
                    <?php echo $news['content']; ?>
                </div>
                
                <!-- 文章标签 -->
                <?php if (isset($news['tags']) && is_array($news['tags']) && !empty($news['tags'])): ?>
                <div class="news-tags">
                    <h5 class="mb-3"><i class="mdi mdi-tag-multiple-outline me-2"></i>标签</h5>
                    <div class="d-flex flex-wrap">
                        <?php foreach ($news['tags'] as $tag): ?>
                            <a href="/tag.php?name=<?php echo urlencode($tag['name']); ?>" class="tag-item me-2 mb-2">
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </article>
            
            <!-- 分享按钮 -->
            <div class="news-share mb-4 p-3 rounded" style="background-color: var(--surface-color); box-shadow: var(--card-shadow);">
                <h5 class="mb-3"><i class="mdi mdi-share-variant-outline me-2"></i>分享文章</h5>
                <div class="d-flex">
                    <a href="javascript:void(0);" onclick="window.open('https://service.weibo.com/share/share.php?url='+encodeURIComponent(window.location.href)+'&title='+encodeURIComponent(document.title))" class="share-button me-2" title="分享到微博">
                        <i class="mdi mdi-sina-weibo"></i>
                    </a>
                    <a href="javascript:void(0);" onclick="window.open('https://connect.qq.com/widget/shareqq/index.html?url='+encodeURIComponent(window.location.href)+'&title='+encodeURIComponent(document.title))" class="share-button me-2" title="分享到QQ">
                        <i class="mdi mdi-qqchat"></i>
                    </a>
                    <a href="javascript:void(0);" class="share-button wechat-share me-2" title="分享到微信" data-bs-toggle="modal" data-bs-target="#wechatShareModal">
                        <i class="mdi mdi-wechat"></i>
                    </a>
                    <a href="javascript:void(0);" onclick="copyLink()" class="share-button" title="复制链接">
                        <i class="mdi mdi-content-copy"></i>
                    </a>
                </div>
            </div>
            
            <!-- 相关阅读 -->
            <?php if (!empty($relatedNews)): ?>
            <div class="related-news mb-4 p-4 rounded" style="background-color: var(--surface-color); box-shadow: var(--card-shadow);">
                <h4 class="related-title position-relative mb-4 pb-2">
                    <i class="mdi mdi-file-multiple-outline me-2"></i>相关阅读
                </h4>
                
                <div class="row g-3">
                    <?php foreach ($relatedNews as $related): ?>
                    <div class="col-md-6">
                        <div class="related-item d-flex">
                            <div class="related-image me-3">
                                <?php if (isset($related['coverImage']) && !empty($related['coverImage'])): ?>
                                    <img src="<?php echo htmlspecialchars($related['coverImage']); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>" class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="related-image-placeholder d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 60px; background-color: rgba(255,255,255,0.05);">
                                        <i class="mdi mdi-image-outline" style="color: rgba(255,255,255,0.2);"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="related-content">
                                <h6 class="related-title mb-1">
                                    <a href="/news.php?id=<?php echo $related['id']; ?>" class="text-decoration-none text-reset">
                                        <?php echo htmlspecialchars(mb_substr($related['title'], 0, 25) . (mb_strlen($related['title']) > 25 ? '...' : '')); ?>
                                    </a>
                                </h6>
                                <div class="related-meta text-white-50 small">
                                    <i class="mdi mdi-calendar-outline me-1"></i>
                                    <?php echo date('Y-m-d', strtotime($related['publishTime'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- 评论区（如果需要） -->
            <div class="comments-section p-4 rounded" style="background-color: var(--surface-color); box-shadow: var(--card-shadow);">
                <h4 class="comments-title position-relative mb-4 pb-2">
                    <i class="mdi mdi-comment-multiple-outline me-2"></i>评论
                </h4>
                
                <div class="comments-form mb-4">
                    <form id="commentForm">
                        <div class="mb-3">
                            <textarea class="form-control" rows="4" placeholder="发表您的评论..." style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: var(--text-primary);"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <input type="text" class="form-control" placeholder="您的昵称" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: var(--text-primary);">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="您的邮箱（不会公开）" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: var(--text-primary);">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary">
                            <i class="mdi mdi-send me-1"></i>提交评论
                        </button>
                    </form>
                </div>
                
                <div class="comments-list">
                    <div class="no-comments text-center text-white-50 py-4">
                        <i class="mdi mdi-comment-outline" style="font-size: 3rem;"></i>
                        <p class="mt-3">暂无评论，成为第一个评论的人吧！</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 侧边栏 -->
        <div class="col-lg-4">
            <!-- 热门文章 -->
            <div class="sidebar-widget mb-4">
                <h4 class="widget-title">
                    <i class="mdi mdi-fire-circle me-2"></i>热门文章
                </h4>
                
                <div class="hot-posts">
                    <?php if (isset($hotNews) && is_array($hotNews)): ?>
                        <?php foreach ($hotNews as $index => $hotItem): ?>
                            <div class="hot-post-item d-flex mb-3 pb-3 <?php echo $index < count($hotNews) - 1 ? 'border-bottom border-secondary' : ''; ?>">
                                <div class="hot-post-number me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; background-color: <?php echo $index < 3 ? 'var(--primary-color)' : 'rgba(255,255,255,0.1)'; ?>; color: var(--on-primary); font-weight: 700; font-size: 1.1rem;">
                                    <?php echo $index + 1; ?>
                                </div>
                                <div class="hot-post-content">
                                    <h6 class="mb-1">
                                        <a href="/news.php?id=<?php echo $hotItem['id']; ?>" class="text-decoration-none text-reset">
                                            <?php echo htmlspecialchars($hotItem['title']); ?>
                                        </a>
                                    </h6>
                                    <div class="hot-post-meta text-white-50 small">
                                        <i class="mdi mdi-eye-outline me-1"></i> <?php echo $hotItem['viewCount']; ?> 阅读
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-white-50 py-3">暂无热门文章</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- 标签云 -->
            <div class="sidebar-widget mb-4">
                <h4 class="widget-title">
                    <i class="mdi mdi-tag-multiple-outline me-2"></i>标签云
                </h4>
                
                <div class="tag-cloud">
                    <?php if (isset($tags) && is_array($tags)): ?>
                        <?php foreach (array_slice($tags, 0, 20) as $tag): ?>
                            <a href="/tag.php?name=<?php echo urlencode($tag['name']); ?>" class="tag-item">
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-white-50 py-3">暂无标签</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- 关注我们 -->
            <div class="sidebar-widget mb-4">
                <h4 class="widget-title">
                    <i class="mdi mdi-qrcode-scan me-2"></i>关注我们
                </h4>
                
                <div class="text-center">
                    <img src="/assets/images/qrcode.png" alt="扫码关注" class="img-fluid rounded qrcode-image" style="max-width: 180px;">
                    <p class="mt-2 text-white-50">扫描二维码关注我们</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 微信分享弹窗 -->
<div class="modal fade" id="wechatShareModal" tabindex="-1" aria-labelledby="wechatShareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--surface-color); color: var(--text-primary);">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="wechatShareModalLabel">分享到微信</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div id="wechatQRCode" class="mx-auto mb-3" style="width: 200px; height: 200px; background-color: rgba(255,255,255,0.1);">
                    <!-- 这里应该生成当前页面的二维码 -->
                    <img src="/assets/images/qrcode.png" alt="微信分享二维码" class="img-fluid">
                </div>
                <p class="text-white-50">使用微信扫描二维码分享</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* 文章详情页特定样式 */
    .news-title {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.3;
        color: var(--text-primary);
    }
    
    .news-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-primary);
    }
    
    .news-content p {
        margin-bottom: 1.5rem;
    }
    
    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .news-content h2, .news-content h3, .news-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .news-content blockquote {
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        border-left: 4px solid var(--primary-light);
        background-color: rgba(187, 134, 252, 0.1);
        border-radius: 4px;
    }
    
    .share-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: var(--text-secondary);
        background-color: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .share-button:hover {
        color: var(--on-primary);
        background-color: var(--primary-color);
        transform: translateY(-3px);
    }
    
    .share-button i {
        font-size: 1.25rem;
    }
    
    .related-title::after, .comments-title::after, .widget-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-light), var(--secondary-color));
    }
    
    .qrcode-image {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }
    
    .qrcode-image:hover {
        transform: scale(1.05);
    }
    
    @media (max-width: 992px) {
        .news-title {
            font-size: 1.75rem;
        }
        
        .news-content {
            font-size: 1rem;
        }
    }
</style>

<script>
    function copyLink() {
        navigator.clipboard.writeText(window.location.href)
            .then(() => {
                alert('链接已复制到剪贴板！');
            })
            .catch(err => {
                console.error('无法复制链接: ', err);
                alert('复制链接失败，请手动复制浏览器地址栏中的链接。');
            });
    }
    
    // 在这里可以添加生成微信分享二维码的代码
    // 例如使用QRCode.js等库动态生成当前页面的二维码
</script> 