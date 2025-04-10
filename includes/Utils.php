<?php
class Utils {
    /**
     * 格式化日期时间
     * 
     * @param string $dateTime 日期时间字符串
     * @param string $format 输出格式
     * @return string 格式化后的日期时间
     */
    public static function formatDateTime($dateTime, $format = 'Y-m-d H:i') {
        $timestamp = strtotime($dateTime);
        return date($format, $timestamp);
    }
    
    /**
     * 计算相对时间（例如：3小时前）
     * 
     * @param string $dateTime 日期时间字符串
     * @return string 相对时间
     */
    public static function getRelativeTime($dateTime) {
        $timestamp = strtotime($dateTime);
        $difference = time() - $timestamp;
        
        if ($difference < 60) {
            return $difference . '秒前';
        } elseif ($difference < 3600) {
            return floor($difference / 60) . '分钟前';
        } elseif ($difference < 86400) {
            return floor($difference / 3600) . '小时前';
        } elseif ($difference < 2592000) {
            return floor($difference / 86400) . '天前';
        } elseif ($difference < 31536000) {
            return floor($difference / 2592000) . '个月前';
        } else {
            return floor($difference / 31536000) . '年前';
        }
    }
    
    /**
     * 截取字符串并添加省略号
     * 
     * @param string $text 原始文本
     * @param int $length 截取长度
     * @param string $suffix 后缀
     * @return string 截取后的文本
     */
    public static function truncateText($text, $length = 100, $suffix = '...') {
        // 添加参数检查
        if (empty($text) || !is_string($text)) {
            return '';
        }
        
        if (mb_strlen($text, 'UTF-8') <= $length) {
            return $text;
        }
        
        return mb_substr($text, 0, $length, 'UTF-8') . $suffix;
    }
    
    /**
     * 生成分页HTML
     * 
     * @param int $currentPage 当前页码
     * @param int $totalPages 总页数
     * @param string $urlPattern URL模式，使用{page}作为页码占位符
     * @return string 分页HTML
     */
    public static function generatePagination($currentPage, $totalPages, $urlPattern) {
        if ($totalPages <= 1) {
            return '';
        }
        
        $html = '<div class="ne-pagination">';
        
        // 上一页
        if ($currentPage > 1) {
            $prevUrl = str_replace('{page}', $currentPage - 1, $urlPattern);
            $html .= '<a href="' . $prevUrl . '" class="prev">上一页</a>';
        } else {
            $html .= '<span class="prev disabled">上一页</span>';
        }
        
        // 第一页
        if ($currentPage > 3) {
            $html .= '<a href="' . str_replace('{page}', 1, $urlPattern) . '">1</a>';
            if ($currentPage > 4) {
                $html .= '<span class="ellipsis">...</span>';
            }
        }
        
        // 页码
        for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++) {
            if ($i == $currentPage) {
                $html .= '<span class="current">' . $i . '</span>';
            } else {
                $html .= '<a href="' . str_replace('{page}', $i, $urlPattern) . '">' . $i . '</a>';
            }
        }
        
        // 最后一页
        if ($currentPage < $totalPages - 2) {
            if ($currentPage < $totalPages - 3) {
                $html .= '<span class="ellipsis">...</span>';
            }
            $html .= '<a href="' . str_replace('{page}', $totalPages, $urlPattern) . '">' . $totalPages . '</a>';
        }
        
        // 下一页
        if ($currentPage < $totalPages) {
            $nextUrl = str_replace('{page}', $currentPage + 1, $urlPattern);
            $html .= '<a href="' . $nextUrl . '" class="next">下一页</a>';
        } else {
            $html .= '<span class="next disabled">下一页</span>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * 获取当前页面URL
     * 
     * @return string 当前页面URL
     */
    public static function getCurrentUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    /**
     * 生成SEO友好的URL
     * 
     * @param string $title 标题
     * @param int $id ID
     * @return string SEO友好的URL
     */
    public static function generateSeoUrl($title, $id) {
        // 将标题转换为拼音或其他SEO友好的格式
        // 这里简化处理，实际可能需要更复杂的转换
        $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $title);
        $slug = trim($slug, '-');
        $slug = strtolower($slug);
        
        return $slug . '-' . $id;
    }
    
    /**
     * 获取视图路径
     * 
     * @param object $apiClient API客户端实例
     * @param string $domain 域名
     * @return string 视图路径
     */
    public static function getViewsPath($apiClient, $domain = 'default') {
        // 获取域名配置
        $domainConfigResponse = $apiClient->getDomainConfig($domain);
        $domainConfig = isset($domainConfigResponse['data']) ? $domainConfigResponse['data'] : null;
        
        // 如果已经定义了VIEWS_PATH常量，直接返回
        if (defined('VIEWS_PATH')) {
            error_log("VIEWS_PATH已定义: " . VIEWS_PATH);
            return VIEWS_PATH;
        }
        
        // 设置视图路径
        if ($domainConfig && isset($domainConfig['views'])) {
            $viewsPath = $domainConfig['views'];
            error_log("从域名配置获取视图路径: " . $viewsPath);
            
            // 检查视图路径是否存在
            if (is_dir($viewsPath)) {
                define('VIEWS_PATH', $viewsPath);
            } else {
                error_log("视图路径不存在: " . $viewsPath . "，使用默认路径");
                define('VIEWS_PATH', 'views');
            }
        } else {
            error_log("未找到域名配置或视图路径，使用默认路径");
            define('VIEWS_PATH', 'views');
        }
        
        return VIEWS_PATH;
    }
} 