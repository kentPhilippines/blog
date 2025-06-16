<?php
$pageTitle = '联系' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME);
$pageDescription = '联系' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME) . '，获取帮助和支持，或提供您的反馈和建议。';
$pageKeywords = '联系我们,客户服务,反馈建议,' . ($domainConfig['title'] ?? DYNAMIC_SITE_NAME);
?>

<div class="ne-contact">
    <div class="ne-contact-header">
        <h1>联系我们</h1>
        <nav class="ne-breadcrumb" aria-label="面包屑导航">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item"><span itemprop="name">首页</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">联系我们</span>
                    <meta itemprop="position" content="2" />
                </li>
            </ol>
        </nav>
    </div>

    <div class="ne-contact-content">
        <div class="ne-contact-info" itemscope itemtype="https://schema.org/Organization">
            <meta itemprop="name" content="<?php echo htmlspecialchars($domainConfig['title'] ?? DYNAMIC_SITE_NAME); ?>" />
            
            <section class="ne-contact-section">
                <h2><i class="fas fa-map-marker-alt"></i> 公司地址</h2>
                <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                    <?php if (!empty($domainConfig['address'])): ?>
                    <p itemprop="streetAddress"><?php echo htmlspecialchars($domainConfig['address']); ?></p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="ne-contact-section">
                <h2><i class="fas fa-envelope"></i> 电子邮件</h2>
                <?php if (!empty($domainConfig['email'])): ?>
                <p><a href="mailto:<?php echo htmlspecialchars($domainConfig['email']); ?>" itemprop="email"><?php echo htmlspecialchars($domainConfig['email']); ?></a></p>
                <?php endif; ?>
            </section>

            <section class="ne-contact-section">
                <h2><i class="fas fa-phone"></i> 联系电话</h2>
                <?php if (!empty($domainConfig['phone'])): ?>
                <p itemprop="telephone"><?php echo htmlspecialchars($domainConfig['phone']); ?></p>
                <?php endif; ?>
            </section>
        </div>

        <div class="ne-contact-form">
            <h2>在线留言</h2>
            <form action="/api/contact.html" method="post" class="ne-form">
                <div class="ne-form-group">
                    <label for="name">姓名</label>
                    <input type="text" id="name" name="name" required 
                           placeholder="请输入您的姓名" 
                           aria-label="姓名">
                </div>

                <div class="ne-form-group">
                    <label for="email">邮箱</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="请输入您的邮箱地址" 
                           aria-label="邮箱">
                </div>

                <div class="ne-form-group">
                    <label for="subject">主题</label>
                    <input type="text" id="subject" name="subject" required 
                           placeholder="请输入留言主题" 
                           aria-label="主题">
                </div>

                <div class="ne-form-group">
                    <label for="message">留言内容</label>
                    <textarea id="message" name="message" required 
                              placeholder="请输入您的留言内容" 
                              aria-label="留言内容"
                              rows="5"></textarea>
                </div>

                <button type="submit" class="ne-submit-btn">
                    <i class="fas fa-paper-plane"></i> 提交留言
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.ne-contact {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.ne-contact-header {
    margin-bottom: 30px;
    text-align: center;
}

.ne-contact-header h1 {
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

.ne-contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.ne-contact-section {
    margin-bottom: 30px;
}

.ne-contact-section h2 {
    font-size: 20px;
    color: #333;
    margin-bottom: 15px;
}

.ne-contact-section i {
    color: #1a73e8;
    margin-right: 10px;
}

.ne-contact-section p {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
    margin: 10px 0;
}

.ne-contact-section a {
    color: #1a73e8;
    text-decoration: none;
}

.ne-contact-section a:hover {
    text-decoration: underline;
}

.ne-contact-form {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
}

.ne-contact-form h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 20px;
}

.ne-form-group {
    margin-bottom: 20px;
}

.ne-form-group label {
    display: block;
    font-size: 16px;
    color: #333;
    margin-bottom: 8px;
}

.ne-form-group input,
.ne-form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    color: #333;
}

.ne-form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.ne-submit-btn {
    background: #1a73e8;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    transition: background-color 0.3s;
}

.ne-submit-btn i {
    margin-right: 8px;
}

.ne-submit-btn:hover {
    background: #1557b0;
}

@media (max-width: 768px) {
    .ne-contact {
        padding: 15px;
    }

    .ne-contact-header h1 {
        font-size: 24px;
    }

    .ne-contact-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .ne-contact-section h2 {
        font-size: 18px;
    }

    .ne-contact-form {
        padding: 20px;
    }

    .ne-form-group input,
    .ne-form-group textarea {
        font-size: 15px;
    }

    .ne-submit-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>