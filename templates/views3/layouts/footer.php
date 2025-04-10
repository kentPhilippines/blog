<!-- 页脚区域 -->
<footer class="ne-footer">
    <div class="ne-footer-inner">
        <!-- 友情链接 -->
        <div class="ne-footer-links">
            <a href="/about.php">关于我们</a>
            <a href="/contact.php">联系我们</a>
            <a href="/privacy.php">隐私政策</a>
            <a href="/terms.php">服务条款</a>
            <a href="/sitemap.php">网站地图</a>
            <a href="/rss.php">RSS订阅</a>
        </div>
        
        <!-- 版权信息 -->
        <div class="ne-footer-copyright">
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_NAME); ?>. All Rights Reserved.</p>
            <p>本站内容均来自互联网，如有侵权请联系我们删除。</p>
        </div>
        
        <!-- 备案信息 -->
        <?php if (defined('ICP_NUMBER')): ?>
        <div class="ne-footer-icp">
            <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow">
                <?php echo htmlspecialchars(ICP_NUMBER); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</footer>

<!-- 返回顶部按钮的JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTop = document.getElementById('backToTop');
    
    // 显示/隐藏返回顶部按钮
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
    
    // 点击返回顶部
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});</script> 