// 网易新闻模板交互脚本
document.addEventListener('DOMContentLoaded', function() {
    // 返回顶部按钮
    const backToTop = document.querySelector('.ne-back-to-top');
    
    // 监听滚动事件
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
    
    // 图片懒加载
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
    
    // 移动端导航菜单
    const menuToggle = document.querySelector('.ne-menu-toggle');
    const navList = document.querySelector('.ne-nav-list');
    
    if (menuToggle && navList) {
        menuToggle.addEventListener('click', function() {
            navList.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }
    
    // 搜索框交互
    const searchInput = document.querySelector('.ne-search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    }
    
    // 新闻列表项悬停效果
    const newsItems = document.querySelectorAll('.ne-news-item');
    newsItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // 导航栏滚动提示
    const nav = document.querySelector('.ne-nav');
    
    function updateScrollIndicators() {
        if (!navList || !nav) return;
        
        const hasLeftContent = navList.scrollLeft > 0;
        const hasRightContent = navList.scrollLeft < (navList.scrollWidth - navList.clientWidth);
        
        nav.classList.toggle('show-left-indicator', hasLeftContent);
        nav.classList.toggle('show-right-indicator', hasRightContent);
    }
    
    if (navList) {
        navList.addEventListener('scroll', updateScrollIndicators);
        window.addEventListener('resize', updateScrollIndicators);
        // 初始化时检查
        updateScrollIndicators();
    }
}); 