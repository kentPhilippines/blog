<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container p-5 bg-white rounded shadow-sm">
                <div class="error-icon mb-4">
                    <i class="fas fa-exclamation-circle text-danger" style="font-size: 5rem;"></i>
                </div>
                <h1 class="error-title mb-4">页面未找到</h1>
                <div class="error-description mb-4">
                    <p class="text-muted">抱歉，您请求的页面不存在或已被移除。</p>
                    <p class="text-muted">您可能输入了错误的地址，或者该页面已被移动到其他位置。</p>
                </div>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary px-4">
                        <i class="fas fa-home me-2"></i>返回首页
                    </a>
                    <a href="javascript:history.back();" class="btn btn-outline-secondary ms-2 px-4">
                        <i class="fas fa-arrow-left me-2"></i>返回上一页
                    </a>
                </div>
            </div>
            
            <div class="mt-4">
                <p class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>如果您认为这是网站错误，请联系管理员。
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .error-container {
        transition: all 0.3s ease;
    }
    .error-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .error-icon {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% {
            transform: scale(0.95);
            opacity: 0.7;
        }
        50% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(0.95);
            opacity: 0.7;
        }
    }
</style> 