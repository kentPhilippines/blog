/**
 * 新闻博客主JavaScript文件
 */
document.addEventListener('DOMContentLoaded', function() {
    // 初始化Bootstrap工具提示
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // 图片延迟加载
    lazyLoadImages();
    
    // 平滑滚动
    setupSmoothScroll();
    
    // 返回顶部按钮
    setupBackToTop();
    
    // 移动设备菜单关闭
    setupMobileMenuClose();
});

/**
 * 图片延迟加载
 */
function lazyLoadImages() {
    // 检查浏览器是否支持IntersectionObserver
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const image = entry.target;
                    const src = image.getAttribute('data-src');
                    
                    if (src) {
                        image.src = src;
                        image.removeAttribute('data-src');
                    }
                    
                    imageObserver.unobserve(image);
                }
            });
        });
        
        // 获取所有带有data-src属性的图片
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(image => {
            imageObserver.observe(image);
        });
    } else {
        // 如果浏览器不支持IntersectionObserver，则立即加载所有图片
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(image => {
            const src = image.getAttribute('data-src');
            if (src) {
                image.src = src;
                image.removeAttribute('data-src');
            }
        });
    }
}

/**
 * 设置平滑滚动
 */
function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * 设置返回顶部按钮
 */
function setupBackToTop() {
    // 创建返回顶部按钮
    const backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopButton.className = 'back-to-top';
    backToTopButton.title = '返回顶部';
    document.body.appendChild(backToTopButton);
    
    // 添加样式
    const style = document.createElement('style');
    style.textContent = `
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #0d6efd;
            color: white;
            border: none;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .back-to-top:hover {
            background-color: #0a58ca;
            transform: translateY(-3px);
        }
        
        .back-to-top.visible {
            display: flex;
        }
    `;
    document.head.appendChild(style);
    
    // 监听滚动事件
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });
    
    // 点击事件
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * 移动设备菜单自动关闭
 */
function setupMobileMenuClose() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navbarToggler = document.querySelector('.navbar-toggler');
    
    if (navLinks && navbarCollapse && navbarToggler) {
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            });
        });
    }
}

/**
 * 分享到社交媒体
 * 
 * @param {string} platform 平台名称
 * @param {string} url 要分享的URL
 * @param {string} title 要分享的标题
 */
function shareToSocial(platform, url, title) {
    let shareUrl = '';
    
    switch (platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + url)}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
} 