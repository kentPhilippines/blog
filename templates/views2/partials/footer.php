<footer class="site-footer pt-5">
    <!-- 主要页脚区域 -->
    <div class="main-footer pb-4" style="background-color: var(--surface-color);">
        <div class="container">
            <div class="row fade-in">
                <!-- 网站信息 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title position-relative pb-2 mb-4 text-white">
                            <i class="mdi mdi-information-outline me-2"></i>关于我们
                        </h4>
                        <div class="about-widget">
                            <a href="/" class="footer-logo d-block mb-4">
                                <?php if (isset($domainConfig['logoUrl']) && !empty($domainConfig['logoUrl'])): ?>
                                    <img src="<?php echo htmlspecialchars($domainConfig['logoUrl']); ?>" alt="<?php echo isset($domainConfig['title']) ? htmlspecialchars($domainConfig['title']) : '网站标志'; ?>" height="40" class="img-fluid">
                                <?php else: ?>
                                    <span class="h4 fw-bold text-gradient">
                                        <i class="mdi mdi-newspaper-variant-outline me-2"></i>
                                        <?php echo isset($domainConfig['title']) ? htmlspecialchars($domainConfig['title']) : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <p class="text-white-50 mb-4">
                                <?php echo isset($domainConfig['description']) ? htmlspecialchars($domainConfig['description']) : '提供最新的新闻资讯、深度报道和权威分析，让您轻松了解世界和本地发生的重要事件。'; ?>
                            </p>
                            <!-- 联系信息 -->
                            <div class="contact-info">
                                <?php if (isset($domainConfig['contactEmail'])): ?>
                                <p class="d-flex align-items-center mb-2">
                                    <i class="mdi mdi-email-outline me-3 text-primary-light"></i>
                                    <span class="text-white-50"><?php echo htmlspecialchars($domainConfig['contactEmail']); ?></span>
                                </p>
                                <?php endif; ?>
                                
                                <?php if (isset($domainConfig['contactPhone'])): ?>
                                <p class="d-flex align-items-center mb-2">
                                    <i class="mdi mdi-phone-outline me-3 text-primary-light"></i>
                                    <span class="text-white-50"><?php echo htmlspecialchars($domainConfig['contactPhone']); ?></span>
                                </p>
                                <?php endif; ?>
                                
                                <?php if (isset($domainConfig['contactAddress'])): ?>
                                <p class="d-flex align-items-center mb-2">
                                    <i class="mdi mdi-map-marker-outline me-3 text-primary-light"></i>
                                    <span class="text-white-50"><?php echo htmlspecialchars($domainConfig['contactAddress']); ?></span>
                                </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- 社交媒体 -->
                            <div class="social-links mt-4">
                                <a href="#" class="social-icon me-2" title="微博">
                                    <i class="mdi mdi-sina-weibo"></i>
                                </a>
                                <a href="#" class="social-icon me-2" title="微信">
                                    <i class="mdi mdi-wechat"></i>
                                </a>
                                <a href="#" class="social-icon me-2" title="QQ">
                                    <i class="mdi mdi-qqchat"></i>
                                </a>
                                <a href="#" class="social-icon" title="知乎">
                                    <i class="mdi mdi-alpha-z-box"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 栏目分类 -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title position-relative pb-2 mb-4 text-white">
                            <i class="mdi mdi-shape-outline me-2"></i>栏目分类
                        </h4>
                        <ul class="footer-links list-unstyled">
                            <?php if (isset($categories) && is_array($categories)): ?>
                                <?php 
                                // 只显示有文章的分类，最多6个
                                $displayCategories = array_filter($categories, function($cat) {
                                    return isset($cat['newsCount']) && $cat['newsCount'] > 0;
                                });
                                $displayCategories = array_slice($displayCategories, 0, 6);
                                ?>
                                
                                <?php foreach ($displayCategories as $category): ?>
                                    <li class="mb-2">
                                        <a href="/category.php?name=<?php echo urlencode($category['name']); ?>" class="text-white-50 text-decoration-none category-link">
                                            <i class="mdi mdi-chevron-right me-2 small"></i><?php echo htmlspecialchars($category['name']); ?>
                                            <?php if (isset($category['newsCount'])): ?>
                                                <span class="badge bg-primary-light rounded-pill ms-1"><?php echo $category['newsCount']; ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- 快速链接 -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title position-relative pb-2 mb-4 text-white">
                            <i class="mdi mdi-link-variant me-2"></i>快速链接
                        </h4>
                        <ul class="footer-links list-unstyled">
                            <li class="mb-2">
                                <a href="/category.php?name=科技" class="text-white-50 text-decoration-none category-link">
                                    <i class="mdi mdi-chevron-right me-2 small"></i>推荐阅读
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/tags.php" class="text-white-50 text-decoration-none category-link">
                                    <i class="mdi mdi-chevron-right me-2 small"></i>热门标签
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/about.php" class="text-white-50 text-decoration-none category-link">
                                    <i class="mdi mdi-chevron-right me-2 small"></i>关于我们
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/privacy.php" class="text-white-50 text-decoration-none category-link">
                                    <i class="mdi mdi-chevron-right me-2 small"></i>隐私政策
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/sitemap.php" class="text-white-50 text-decoration-none category-link">
                                    <i class="mdi mdi-chevron-right me-2 small"></i>网站地图
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- 热门标签和订阅 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title position-relative pb-2 mb-4 text-white">
                            <i class="mdi mdi-tag-multiple-outline me-2"></i>热门标签
                        </h4>
                        <div class="tag-cloud mb-4">
                            <?php if (isset($tags) && is_array($tags)): ?>
                                <?php foreach (array_slice($tags, 0, 15) as $tag): ?>
                                    <a href="/tag.php?name=<?php echo urlencode($tag['name']); ?>" class="tag-item">
                                        <?php echo htmlspecialchars($tag['name']); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- 订阅表单 -->
                        <h4 class="widget-title position-relative pb-2 mb-4 text-white">
                            <i class="mdi mdi-bell-ring-outline me-2"></i>订阅新闻
                        </h4>
                        <form class="subscribe-form">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="您的邮箱地址" aria-label="订阅邮箱" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: var(--text-primary);">
                                <button class="btn btn-primary" type="submit">订阅</button>
                            </div>
                            <small class="form-text text-white-50">我们尊重您的隐私，不会发送垃圾邮件。</small>
                        </form>
                        
                        <!-- 二维码 -->
                        <div class="qrcode-container mt-4 text-center">
                            <img src="/assets/images/qrcode.png" alt="扫码关注" class="img-fluid rounded qrcode-image" style="max-width: 120px;">
                            <p class="mt-2 text-white-50 small">扫码关注我们</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 友情链接 -->
            <?php if (isset($domainConfig['friendlyLinks']) && is_array($domainConfig['friendlyLinks']) && !empty($domainConfig['friendlyLinks'])): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="friendly-links-wrapper p-3" style="background-color: rgba(255,255,255,0.03); border-radius: 8px;">
                        <h5 class="text-white mb-3">
                            <i class="mdi mdi-web me-2"></i>友情链接
                        </h5>
                        <div class="d-flex flex-wrap">
                            <?php foreach ($domainConfig['friendlyLinks'] as $link): ?>
                                <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" class="friendly-link me-3 mb-2" title="<?php echo isset($link['description']) ? htmlspecialchars($link['description']) : ''; ?>">
                                    <?php echo htmlspecialchars($link['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- 版权信息 -->
    <div class="footer-bottom py-3" style="background-color: rgba(0,0,0,0.3);">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="copyright mb-0 text-white-50">
                        &copy; <?php echo date('Y'); ?> 
                        <?php echo isset($domainConfig['title']) ? htmlspecialchars($domainConfig['title']) : (defined('SITE_NAME') ? SITE_NAME : '信息资讯网'); ?>. 
                        保留所有权利
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="icp mb-0 text-white-50">
                        <?php echo isset($domainConfig['icp']) ? htmlspecialchars($domainConfig['icp']) : ''; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background-color: var(--background-color);
    }
    
    .widget-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-light), var(--secondary-color));
    }
    
    .text-gradient {
        background: linear-gradient(90deg, var(--primary-light), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
    }
    
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: var(--text-secondary);
        background-color: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        color: var(--on-primary);
        background-color: var(--primary-color);
        transform: translateY(-3px);
    }
    
    .category-link {
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .category-link:hover {
        color: var(--primary-light) !important;
        transform: translateX(5px);
    }
    
    .tag-item {
        display: inline-block;
        padding: 4px 10px;
        margin: 0 5px 8px 0;
        border-radius: 15px;
        font-size: 0.85rem;
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }
    
    .tag-item:hover {
        background-color: rgba(187, 134, 252, 0.1);
        color: var(--primary-light);
        transform: translateY(-2px);
    }
    
    .qrcode-image {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }
    
    .qrcode-image:hover {
        transform: scale(1.05);
    }
    
    .friendly-link {
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }
    
    .friendly-link:hover {
        color: var(--primary-light);
    }
    
    @media (max-width: 768px) {
        .footer-widget {
            text-align: center;
        }
        
        .widget-title::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .contact-info p {
            justify-content: center;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
        }
    }
</style> 