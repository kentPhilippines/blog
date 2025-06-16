        </div>
    </main>
    <footer class="site-footer mt-5 py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><?php echo SITE_NAME; ?></h5>
                    <p><?php echo SITE_DESCRIPTION; ?></p>
                </div>
                <div class="col-md-4">
                    <h5>热门标签</h5>
                    <div class="tag-cloud">
                        <?php if (isset($tags) && is_array($tags)): ?>
                            <?php foreach (array_slice($tags, 0, 10) as $tag): ?>
                                <a href="/tag.html?name=<?php echo urlencode($tag['name']); ?>" class="tag-item" style="font-size: <?php echo 0.8 + ($tag['frequency'] / 50) * 0.5; ?>rem;">
                                    <?php echo $tag['name']; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>关于我们</h5>
                    <ul class="list-unstyled">
                        <li><a href="/about.html">关于我们</a></li>
                        <li><a href="/contact.html">联系我们</a></li>
                        <li><a href="/privacy.html">隐私政策</a></li>
                        <li><a href="/terms.html">使用条款</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. 保留所有权利。</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <?php if (isset($extraScripts)) echo $extraScripts; ?>
</body>
</html> 