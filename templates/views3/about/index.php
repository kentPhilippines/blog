<?php
$pageTitle = ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '关于我们';
$pageDescription = '了解' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '，我们致力于为用户提供最新、最全面的体育资讯。';
$pageKeywords = '关于我们,公司介绍,体育资讯,' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME);
?>

<div class="ne-about">
    <div class="ne-about-header">
        <h1>关于我们</h1>
        <nav class="ne-breadcrumb" aria-label="面包屑导航">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item"><span itemprop="name">首页</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">关于我们</span>
                    <meta itemprop="position" content="2" />
                </li>
            </ol>
        </nav>
    </div>

    <article class="ne-about-content">
        <section class="ne-about-section">
            <h2>公司简介</h2>
            <div class="ne-about-intro" itemscope itemtype="https://schema.org/Organization">
                <meta itemprop="name" content="<?php echo htmlspecialchars($domainConfig['title'] ?? DYNAMIC_SITE_NAME); ?>" />
                <p itemprop="description"><?php echo htmlspecialchars($domainConfig['title'] ?? DYNAMIC_SITE_NAME); ?>是一家专注于体育资讯的网络媒体平台，致力于为用户提供最新、最全面的体育新闻和赛事信息。</p>
            </div>
        </section>

        <section class="ne-about-section">
            <h2>我们的使命</h2>
            <ul class="ne-about-mission">
                <li>
                    <i class="fas fa-chart-line"></i>
                    <h3>专业性</h3>
                    <p>提供专业、准确的体育资讯服务</p>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <h3>时效性</h3>
                    <p>第一时间发布最新体育新闻</p>
                </li>
                <li>
                    <i class="fas fa-users"></i>
                    <h3>互动性</h3>
                    <p>打造优质的体育社区平台</p>
                </li>
            </ul>
        </section>

        <section class="ne-about-section">
            <h2>我们的优势</h2>
            <div class="ne-about-advantages">
                <div class="ne-advantage-item">
                    <h3>资讯全面</h3>
                    <p>覆盖NBA、CBA、足球等多个体育项目</p>
                </div>
                <div class="ne-advantage-item">
                    <h3>更新及时</h3>
                    <p>24小时不间断更新体育资讯</p>
                </div>
                <div class="ne-advantage-item">
                    <h3>原创内容</h3>
                    <p>专业团队提供深度原创报道</p>
                </div>
                <div class="ne-advantage-item">
                    <h3>用户至上</h3>
                    <p>持续优化用户体验和服务质量</p>
                </div>
            </div>
        </section>

        <section class="ne-about-section">
            <h2>联系我们</h2>
            <div class="ne-about-contact">
                <?php if (!empty($domainConfig['email'])): ?>
                <p><i class="fas fa-envelope"></i> 邮箱：<a href="mailto:<?php echo htmlspecialchars($domainConfig['email']); ?>"><?php echo htmlspecialchars($domainConfig['email']); ?></a></p>
                <?php endif; ?>
                <?php if (!empty($domainConfig['address'])): ?>
                <p><i class="fas fa-map-marker-alt"></i> 地址：<?php echo htmlspecialchars($domainConfig['address']); ?></p>
                <?php endif; ?>
            </div>
        </section>
    </article>
</div>

<style>
.ne-about {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.ne-about-header {
    margin-bottom: 30px;
    text-align: center;
}

.ne-about-header h1 {
    font-size: 28px;
    color: #333;
    margin-bottom: 15px;
}

.ne-breadcrumb {
    color: #666;
    font-size: 14px;
}

.ne-breadcrumb ol {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

.ne-breadcrumb li {
    display: inline;
}

.ne-breadcrumb li:not(:last-child)::after {
    content: '>';
    margin: 0 8px;
    color: #999;
}

.ne-breadcrumb a {
    color: #666;
    text-decoration: none;
}

.ne-breadcrumb a:hover {
    color: #1a73e8;
}

.ne-about-section {
    margin-bottom: 40px;
}

.ne-about-section h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.ne-about-intro p {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
}

.ne-about-mission {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    padding: 0;
    list-style: none;
}

.ne-about-mission li {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: transform 0.3s;
}

.ne-about-mission li:hover {
    transform: translateY(-5px);
}

.ne-about-mission i {
    font-size: 32px;
    color: #1a73e8;
    margin-bottom: 15px;
}

.ne-about-mission h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.ne-about-mission p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
}

.ne-about-advantages {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.ne-advantage-item {
    padding: 20px;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 8px;
}

.ne-advantage-item h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.ne-advantage-item p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
}

.ne-about-contact {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.ne-about-contact p {
    font-size: 16px;
    color: #666;
    margin: 10px 0;
    display: flex;
    align-items: center;
}

.ne-about-contact i {
    color: #1a73e8;
    margin-right: 10px;
    width: 20px;
}

.ne-about-contact a {
    color: #1a73e8;
    text-decoration: none;
}

.ne-about-contact a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .ne-about {
        padding: 15px;
    }

    .ne-about-header h1 {
        font-size: 24px;
    }

    .ne-about-mission {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .ne-about-advantages {
        grid-template-columns: 1fr;
    }

    .ne-about-section h2 {
        font-size: 20px;
    }

    .ne-about-intro p {
        font-size: 15px;
    }
}
</style> 