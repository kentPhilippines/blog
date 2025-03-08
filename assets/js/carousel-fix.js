/**
 * 轮播图修复 - 确保轮播图片正常显示
 */

document.addEventListener('DOMContentLoaded', function() {
    // 获取所有轮播组件
    const carousels = document.querySelectorAll('.carousel');
    
    carousels.forEach(function(carousel) {
        // 预加载所有轮播图片
        const preloadCarouselImages = function() {
            const images = carousel.querySelectorAll('.carousel-item img');
            images.forEach(function(img) {
                // 确保图片有效
                if (img.getAttribute('src')) {
                    // 创建新图片对象进行预加载
                    const image = new Image();
                    image.src = img.getAttribute('src');
                    
                    // 图片加载错误时使用默认图片
                    image.onerror = function() {
                        img.src = '/assets/images/default-news.jpg';
                    };
                }
            });
        };
        
        // 调用预加载
        preloadCarouselImages();
        
        // 监听轮播事件
        carousel.addEventListener('slide.bs.carousel', function(event) {
            // 获取即将显示的轮播项
            const nextSlide = event.relatedTarget;
            if (nextSlide) {
                // 检查轮播项中的图片并确保它已加载
                const img = nextSlide.querySelector('img');
                if (img && (!img.complete || img.naturalHeight === 0)) {
                    // 如果图片未完成加载，尝试重新加载
                    img.src = img.src;
                }
            }
        });
    });
    
    // 主轮播功能增强
    const featuredCarousel = document.getElementById('featuredCarousel');
    if (featuredCarousel) {
        // 设置合适的轮播间隔
        const carouselInstance = new bootstrap.Carousel(featuredCarousel, {
            interval: 5000,
            pause: 'hover',
            wrap: true,
            touch: true
        });
        
        // 为移动设备优化轮播触摸体验
        let touchStartX = 0;
        let touchEndX = 0;
        
        featuredCarousel.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        featuredCarousel.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });
        
        function handleSwipe() {
            const threshold = 50; // 最小滑动距离
            
            if (touchEndX < touchStartX - threshold) {
                // 向左滑动，下一张
                carouselInstance.next();
            } else if (touchEndX > touchStartX + threshold) {
                // 向右滑动，上一张
                carouselInstance.prev();
            }
        }
    }
}); 