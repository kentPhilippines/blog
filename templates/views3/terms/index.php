<?php
$pageTitle = ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '服务条款';
$pageDescription = ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '的服务条款和使用协议，包括用户权利和义务等重要信息。';
$pageKeywords = '服务条款,使用协议,用户协议,' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME);
?>

<div class="ne-terms">
    <div class="ne-terms-header">
        <h1>服务条款</h1>
        <nav class="ne-breadcrumb" aria-label="面包屑导航">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item"><span itemprop="name">首页</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">服务条款</span>
                    <meta itemprop="position" content="2" />
                </li>
            </ol>
        </nav>
    </div>

    <article class="ne-terms-content">
        <section class="ne-terms-section">
            <h2>服务说明</h2>
            <p>欢迎使用<?php echo htmlspecialchars($domainConfig['title'] ?? DYNAMIC_SITE_NAME); ?>提供的服务。本服务条款是您与我们之间的协议，请仔细阅读。</p>
        </section>

        <section class="ne-terms-section">
            <h2>用户义务</h2>
            <ul>
                <li>遵守国家相关法律法规</li>
                <li>不得发布违法、违规内容</li>
                <li>尊重他人知识产权</li>
                <li>维护网站良好秩序</li>
            </ul>
        </section>

        <section class="ne-terms-section">
            <h2>内容规范</h2>
            <ul>
                <li>确保发布内容的真实性和准确性</li>
                <li>不得发布垃圾广告和营销信息</li>
                <li>遵守网站评论规则</li>
                <li>尊重其他用户的权利</li>
            </ul>
        </section>

        <section class="ne-terms-section">
            <h2>知识产权</h2>
            <ul>
                <li>网站内容的知识产权归本站所有</li>
                <li>用户发布的内容需确保拥有相应权利</li>
                <li>未经许可不得转载或使用本站内容</li>
                <li>举报侵权内容的渠道和处理方式</li>
            </ul>
        </section>

        <section class="ne-terms-section">
            <h2>免责声明</h2>
            <ul>
                <li>不对用户发布的内容负责</li>
                <li>服务中断或故障的免责说明</li>
                <li>第三方链接的免责声明</li>
                <li>不可抗力因素导致的损失免责</li>
            </ul>
        </section>

        <section class="ne-terms-section">
            <h2>协议修改</h2>
            <p>我们保留随时修改本协议的权利，修改后的协议将在网站上公布。</p>
            <p>最后更新时间：<?php echo date('Y-m-d'); ?></p>
        </section>
    </article>
</div>

<style>
.ne-terms {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.ne-terms-header {
    margin-bottom: 30px;
    text-align: center;
}

.ne-terms-header h1 {
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

.ne-terms-section {
    margin-bottom: 40px;
}

.ne-terms-section h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.ne-terms-section p {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    margin-bottom: 15px;
}

.ne-terms-section ul {
    list-style: none;
    padding-left: 20px;
    margin-bottom: 15px;
}

.ne-terms-section li {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 8px;
    position: relative;
}

.ne-terms-section li::before {
    content: '•';
    color: #1a73e8;
    position: absolute;
    left: -15px;
}

@media (max-width: 768px) {
    .ne-terms {
        padding: 15px;
    }

    .ne-terms-header h1 {
        font-size: 24px;
    }

    .ne-terms-section h2 {
        font-size: 20px;
    }

    .ne-terms-section p,
    .ne-terms-section li {
        font-size: 15px;
    }
}
</style> 