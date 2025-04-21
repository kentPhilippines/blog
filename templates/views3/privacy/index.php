<?php
$pageTitle = ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '隐私政策';
$pageDescription = ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '的隐私政策说明，包括用户数据收集、使用和保护等信息。';
$pageKeywords = '隐私政策,用户协议,数据保护,' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME);
?>

<div class="ne-privacy">
    <div class="ne-privacy-header">
        <h1>隐私政策</h1>
        <nav class="ne-breadcrumb" aria-label="面包屑导航">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item"><span itemprop="name">首页</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">隐私政策</span>
                    <meta itemprop="position" content="2" />
                </li>
            </ol>
        </nav>
    </div>

    <article class="ne-privacy-content">
        <section class="ne-privacy-section">
            <h2>信息收集</h2>
            <p>我们收集的信息包括：</p>
            <ul>
                <li>基本用户信息（如用户名、邮箱地址）</li>
                <li>浏览记录和使用数据</li>
                <li>设备信息和IP地址</li>
                <li>Cookie和类似技术收集的信息</li>
            </ul>
        </section>

        <section class="ne-privacy-section">
            <h2>信息使用</h2>
            <p>我们使用收集的信息用于：</p>
            <ul>
                <li>提供、维护和改进我们的服务</li>
                <li>发送服务通知和更新</li>
                <li>防止欺诈和滥用</li>
                <li>进行数据分析和研究</li>
            </ul>
        </section>

        <section class="ne-privacy-section">
            <h2>信息保护</h2>
            <p>我们采取多种安全措施保护您的个人信息：</p>
            <ul>
                <li>数据加密传输和存储</li>
                <li>访问控制和认证</li>
                <li>定期安全审计</li>
                <li>员工培训和保密协议</li>
            </ul>
        </section>

        <section class="ne-privacy-section">
            <h2>Cookie使用</h2>
            <p>我们使用Cookie来：</p>
            <ul>
                <li>记住您的登录状态</li>
                <li>分析网站使用情况</li>
                <li>优化用户体验</li>
                <li>提供个性化服务</li>
            </ul>
        </section>

        <section class="ne-privacy-section">
            <h2>更新时间</h2>
            <p>本隐私政策最后更新时间：<?php echo date('Y-m-d'); ?></p>
        </section>
    </article>
</div>

<style>
.ne-privacy {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.ne-privacy-header {
    margin-bottom: 30px;
    text-align: center;
}

.ne-privacy-header h1 {
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

.ne-privacy-section {
    margin-bottom: 40px;
}

.ne-privacy-section h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.ne-privacy-section p {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    margin-bottom: 15px;
}

.ne-privacy-section ul {
    list-style: none;
    padding-left: 20px;
    margin-bottom: 15px;
}

.ne-privacy-section li {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 8px;
    position: relative;
}

.ne-privacy-section li::before {
    content: '•';
    color: #1a73e8;
    position: absolute;
    left: -15px;
}

@media (max-width: 768px) {
    .ne-privacy {
        padding: 15px;
    }

    .ne-privacy-header h1 {
        font-size: 24px;
    }

    .ne-privacy-section h2 {
        font-size: 20px;
    }

    .ne-privacy-section p,
    .ne-privacy-section li {
        font-size: 15px;
    }
}
</style>