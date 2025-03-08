<footer class="site-footer">
    <div class="footer-main py-5">
        <div class="container">
            <div class="row gy-4">
                <!-- 网站信息 -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo mb-4">
                        <?php if (isset($siteLogo)): ?>
                            <img src="<?php echo htmlspecialchars($siteLogo); ?>" alt="<?php echo defined('SITE_NAME') ? SITE_NAME : '新闻博客'; ?>" height="40" class="img-fluid">
                        <?php else: ?>
                            <h4 class="text-white fw-bold mb-0"><i class="fas fa-newspaper me-2"></i><?php echo defined('SITE_NAME') ? SITE_NAME : '新闻博客'; ?></h4>
                        <?php endif; ?>
                    </div>
                    <p class="text-white-50 mb-4 footer-desc"><?php echo defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '提供最新的国内外新闻资讯、时事政策解读，热点评论，军事、科技、文化、体育、财经、生活等全方位的新闻资讯服务。'; ?></p>
                    
                    <!-- 社交媒体图标 -->
                    <div class="social-icons mb-4 d-flex">
                        <a href="javascript:void(0);" class="social-icon-link" title="微信" aria-label="微信">
                            <i class="fab fa-weixin"></i>
                        </a>
                        <a href="javascript:void(0);" class="social-icon-link" title="微博" aria-label="微博">
                            <i class="fab fa-weibo"></i>
                        </a>
                        <a href="javascript:void(0);" class="social-icon-link" title="抖音" aria-label="抖音">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="/rss.php" class="social-icon-link" title="RSS订阅" aria-label="RSS订阅" target="_blank">
                            <i class="fas fa-rss"></i>
                        </a>
                    </div>
                    
                    <!-- 二维码 -->
                    <div class="qrcode-container d-flex align-items-center p-3 rounded bg-dark-subtle">
                        <div class="qrcode me-3 bg-white p-1 rounded" style="width: 80px; height: 80px;">
                            <img src="/assets/images/qrcode.png" alt="扫码关注我们" class="img-fluid" width="80" height="80">
                        </div>
                        <div class="qrcode-text text-white">
                            <p class="mb-1 fw-medium">扫码关注我们</p>
                            <p class="mb-0 text-white-50 small">获取最新资讯推送</p>
                        </div>
                    </div>
                </div>
                
                <!-- 快速链接 -->
                <div class="col-6 col-md-4 col-lg-2 mb-4 mb-lg-0">
                    <h5 class="text-white mb-4 footer-heading">快速链接</h5>
                    <ul class="list-unstyled footer-links mb-0">
                        <li class="footer-link-item">
                            <a href="/" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>首页
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/news.php?type=hot" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>热门新闻
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/category.php?name=科技" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>推荐阅读
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/topics.php" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>专题报道
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/tags.php" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>热门标签
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/rss.php" class="footer-link">
                                <i class="fas fa-rss me-2 small"></i>RSS订阅
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/sitemap.php" class="footer-link">
                                <i class="fas fa-sitemap me-2 small"></i>网站地图
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- 栏目分类 -->
                <div class="col-6 col-md-4 col-lg-2 mb-4 mb-lg-0">
                    <h5 class="text-white mb-4 footer-heading">栏目分类</h5>
                    <ul class="list-unstyled footer-links mb-0">
                        <li class="footer-link-item">
                            <a href="/category.php?name=国内" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>国内
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/category.php?name=国际" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>国际
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/category.php?name=财经" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>财经
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/category.php?name=科技" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>科技
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/category.php?name=体育" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>体育
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="/category.php?name=娱乐" class="footer-link">
                                <i class="fas fa-angle-right me-2 small"></i>娱乐
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- 联系我们 -->
                <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-white mb-4 footer-heading">联系我们</h5>
                    <ul class="list-unstyled footer-contact mb-0">
                        <?php if (isset($domainConfig['contactAddress'])): ?>
                        <li class="footer-contact-item">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i> 
                            <span class="text-white-50"><?php echo htmlspecialchars($domainConfig['contactAddress']); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($domainConfig['contactPhone'])): ?>
                        <li class="footer-contact-item">
                            <i class="fas fa-phone-alt me-2 text-primary"></i> 
                            <span class="text-white-50"><?php echo htmlspecialchars($domainConfig['contactPhone']); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($domainConfig['contactEmail'])): ?>
                        <li class="footer-contact-item">
                            <i class="fas fa-envelope me-2 text-primary"></i> 
                            <span class="text-white-50"><?php echo htmlspecialchars($domainConfig['contactEmail']); ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 友情链接 -->
    <div class="footer-links py-3 bg-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <span class="text-white-50 fw-medium">友情链接：</span>
                </div>
                <div class="col-md-10">
                    <ul class="list-inline mb-0 small friendly-links">
                        <?php if (isset($domainConfig) && isset($domainConfig['friendlyLinks']) && is_array($domainConfig['friendlyLinks'])): ?>
                            <?php foreach ($domainConfig['friendlyLinks'] as $link): ?>
                                <li class="list-inline-item me-3 mb-2">
                                    <a href="<?php echo htmlspecialchars($link['url']); ?>" 
                                       class="friendly-link" 
                                       target="_blank" 
                                       rel="nofollow" 
                                       title="<?php echo htmlspecialchars($link['description'] ?? $link['name']); ?>">
                                        <?php echo htmlspecialchars($link['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- 默认友情链接 -->
                            <li class="list-inline-item me-3 mb-2">
                                <a href="https://www.xinhuanet.com/" class="friendly-link" target="_blank" rel="nofollow">新华网</a>
                            </li>
                            <li class="list-inline-item me-3 mb-2">
                                <a href="https://www.people.com.cn/" class="friendly-link" target="_blank" rel="nofollow">人民网</a>
                            </li>
                            <li class="list-inline-item me-3 mb-2">
                                <a href="https://www.chinanews.com.cn/" class="friendly-link" target="_blank" rel="nofollow">中国新闻网</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 底部版权 -->
    <div class="footer-bottom py-3 bg-darker">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white-50 small">
                        <?php echo isset($domainConfig['copyright']) ? htmlspecialchars($domainConfig['copyright']) : '&copy; ' . date('Y') . ' ' . (defined('SITE_NAME') ? SITE_NAME : '新闻博客') . '. 保留所有权利.'; ?>
                        <?php if (isset($domainConfig['icp'])): ?>
                            <br>
                            <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow" class="text-white-50 icp-link"><?php echo htmlspecialchars($domainConfig['icp']); ?></a>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <ul class="list-inline mb-0 small footer-bottom-links">
                        <li class="list-inline-item">
                            <a href="/about.php" class="footer-bottom-link">关于我们</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="/contact.php" class="footer-bottom-link">联系我们</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="/privacy.php" class="footer-bottom-link">隐私政策</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="/terms.php" class="footer-bottom-link">使用条款</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="/sitemap.php" class="footer-bottom-link">网站地图</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 回到顶部按钮 -->
    <a href="#" class="back-to-top position-fixed">
        <i class="fas fa-arrow-up"></i>
    </a>
</footer>

<style>
/* 页脚专用样式 */
.site-footer {
    background-color: #212529;
    color: #f8f9fa;
    margin-top: 3rem;
    position: relative;
}

.footer-desc {
    line-height: 1.7;
    font-size: 0.95rem;
}

.footer-heading {
    position: relative;
    padding-bottom: 12px;
    font-weight: 600;
}

.footer-heading:after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 60px;
    height: 3px;
    background-color: var(--primary-color, #2766d8);
    border-radius: 10px;
}

.footer-links {
    margin-bottom: 1rem;
}

.footer-link-item {
    margin-bottom: 12px;
}

.footer-link {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    display: block;
    font-size: 0.95rem;
}

.footer-link:hover {
    color: white;
    transform: translateX(5px);
}

.footer-contact-item {
    margin-bottom: 16px;
    display: flex;
    align-items: flex-start;
}

.footer-contact-item i {
    margin-top: 3px;
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icon-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon-link:hover {
    background-color: var(--primary-color, #2766d8);
    color: white;
    transform: translateY(-5px);
}

.social-icon-link i {
    font-size: 1.2rem;
}

.friendly-link {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: color 0.3s ease;
}

.friendly-link:hover {
    color: white;
    text-decoration: underline;
}

.footer-bottom-link {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    margin: 0 8px;
    transition: color 0.3s ease;
}

.footer-bottom-link:hover {
    color: white;
}

.icp-link:hover {
    text-decoration: underline;
}

.bg-dark-subtle {
    background-color: rgba(255, 255, 255, 0.05);
}

.bg-darker {
    background-color: #1a1d20;
}

.back-to-top {
    bottom: 30px;
    right: 30px;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    background-color: var(--primary-color, #2766d8);
    color: white;
    opacity: 0.7;
    transition: all 0.3s ease;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.back-to-top:hover {
    opacity: 1;
    transform: translateY(-5px);
    color: white;
}

@media (max-width: 767px) {
    .footer-heading {
        margin-top: 1rem;
    }
    
    .social-icons {
        justify-content: center;
    }
    
    .qrcode-container {
        max-width: 300px;
        margin: 0 auto;
    }
    
    .footer-bottom-links {
        margin-top: 15px;
    }
    
    .footer-bottom-link {
        margin: 0 5px;
        font-size: 0.85rem;
    }
}
</style> 