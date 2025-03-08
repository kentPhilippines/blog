<footer class="site-footer mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title"><?php echo defined('DYNAMIC_SITE_NAME') ? DYNAMIC_SITE_NAME : SITE_NAME; ?></h5>
                    <p class="footer-desc"><?php echo defined('DYNAMIC_SITE_DESCRIPTION') ? DYNAMIC_SITE_DESCRIPTION : SITE_DESCRIPTION; ?></p>
                    <div class="social-links mt-3">
                        <a href="#" class="social-link" title="微信"><i class="fab fa-weixin"></i></a>
                        <a href="#" class="social-link" title="微博"><i class="fab fa-weibo"></i></a>
                        <a href="#" class="social-link" title="QQ"><i class="fab fa-qq"></i></a>
                        <a href="#" class="social-link" title="抖音"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title">热门标签</h5>
                    <div class="tag-cloud">
                        <?php if (isset($tags) && is_array($tags)): ?>
                            <?php foreach (array_slice($tags, 0, 10) as $tag): ?>
                                <?php 
                                    $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : $tag;
                                    $tagFreq = is_array($tag) && isset($tag['frequency']) ? $tag['frequency'] : 10;
                                ?>
                                <a href="/tag.php?name=<?php echo urlencode($tagName); ?>" class="tag-item" style="font-size: <?php echo 0.8 + ($tagFreq / 50) * 0.5; ?>rem;">
                                    <?php echo htmlspecialchars($tagName); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title">联系我们</h5>
                    <ul class="footer-contact">
                        <?php if (isset($domainConfig['contactAddress'])): ?>
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($domainConfig['contactAddress']); ?></li>
                        <?php endif; ?>
                        <?php if (isset($domainConfig['contactPhone'])): ?>
                            <li><i class="fas fa-phone"></i> <?php echo htmlspecialchars($domainConfig['contactPhone']); ?></li>
                        <?php endif; ?>
                        <?php if (isset($domainConfig['contactEmail'])): ?>
                            <li><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($domainConfig['contactEmail']); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <?php if (isset($domainConfig['friendlyLinks']) && is_array($domainConfig['friendlyLinks']) && !empty($domainConfig['friendlyLinks'])): ?>
        <div class="friendly-links mt-4 pt-3 border-top">
            <h5 class="footer-title">友情链接</h5>
            <div class="row">
                <?php foreach ($domainConfig['friendlyLinks'] as $link): ?>
                <div class="col-lg-3 col-md-4 col-6 mb-2">
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" title="<?php echo htmlspecialchars($link['description'] ?? ''); ?>" class="friendly-link">
                        <?php echo htmlspecialchars($link['name']); ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="footer-bottom mt-4 pt-4 border-top">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright mb-0">
                        <?php if (isset($domainConfig['copyright'])): ?>
                            <?php echo htmlspecialchars($domainConfig['copyright']); ?>
                        <?php else: ?>
                            &copy; <?php echo date('Y'); ?> <?php echo defined('DYNAMIC_SITE_NAME') ? DYNAMIC_SITE_NAME : SITE_NAME; ?>. 保留所有权利。
                        <?php endif; ?>
                        <?php if (isset($domainConfig['icp'])): ?>
                            <br><small><?php echo htmlspecialchars($domainConfig['icp']); ?></small>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="footer-bottom-links text-md-end mb-0">
                        <li><a href="#">回到顶部</a></li>
                        <li><a href="/sitemap.php">网站地图</a></li>
                        <li><a href="/rss.php">RSS订阅</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer> 