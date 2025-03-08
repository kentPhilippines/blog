<div class="container py-5">
    <div class="row justify-content-center fade-in">
        <div class="col-lg-8">
            <div class="error-page text-center p-5 rounded" style="background-color: var(--surface-color); box-shadow: var(--card-shadow);">
                <div class="error-icon mb-4">
                    <span class="text-gradient" style="font-size: 6rem; font-weight: 700;">404</span>
                </div>
                
                <h1 class="error-title mb-4">页面未找到</h1>
                
                <div class="error-message text-white-50 mb-5">
                    <p>抱歉，您尝试访问的页面不存在或已被移除。</p>
                    <p>请检查URL是否正确，或尝试使用下方的选项继续浏览我们的网站。</p>
                </div>
                
                <div class="error-actions d-flex flex-column flex-md-row justify-content-center gap-3 mb-4">
                    <a href="/" class="btn btn-primary">
                        <i class="mdi mdi-home-outline me-2"></i>返回首页
                    </a>
                    <button onclick="history.back()" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left me-2"></i>返回上一页
                    </button>
                </div>
                
                <div class="error-search mt-4 mb-5">
                    <p class="text-white-50 mb-3">您也可以尝试搜索：</p>
                    <form action="/search.php" method="get" class="mx-auto" style="max-width: 500px;">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="搜索内容..." style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="error-help text-white-50 small">
                    <p>如果您认为这是一个错误，请联系我们的管理员。</p>
                    <?php if (isset($domainConfig['contactEmail'])): ?>
                        <p><i class="mdi mdi-email-outline me-1"></i> <?php echo htmlspecialchars($domainConfig['contactEmail']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-page {
        position: relative;
        overflow: hidden;
    }
    
    .error-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-light), var(--secondary-color));
    }
    
    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: 1px;
    }
    
    .error-actions .btn {
        min-width: 150px;
    }
    
    .btn-outline-secondary {
        color: var(--text-primary);
        border-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-outline-secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: var(--primary-light);
        color: var(--primary-light);
    }
    
    @media (max-width: 576px) {
        .error-icon span {
            font-size: 4rem;
        }
        
        .error-title {
            font-size: 1.75rem;
        }
    }
</style> 