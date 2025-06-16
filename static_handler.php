<?php
require_once 'config.php';
require_once 'generate_static.php';

/**
 * 静态页面处理器
 * 当静态页面不存在时，动态生成该页面
 */
class StaticHandler {
    private $generator;
    private $currentDomain;
    private $staticDir;
    
    public function __construct() {
        $this->currentDomain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
        $this->generator = new StaticGenerator();
        
        // 获取当前域名的配置
        $domains = $this->generator->getDomains();
        $domainConfig = null;
        
        foreach ($domains as $domain => $config) {
            if ($domain === $this->currentDomain || 
                parse_url($config['url'], PHP_URL_HOST) === $this->currentDomain) {
                $domainConfig = $config;
                break;
            }
        }
        
        // 设置静态文件目录
        if ($domainConfig) {
            $this->staticDir = 'static/' . $domainConfig['name'];
        } else {
            $this->staticDir = 'static/default';
        }
        
        // 确保静态目录存在
        if (!is_dir($this->staticDir)) {
            mkdir($this->staticDir, 0755, true);
        }
    }
    
    /**
     * 获取域名配置
     */
    public function getDomains() {
        return $this->generator->getDomains();
    }
    
    /**
     * 处理请求，检查静态页面是否存在，不存在则生成
     */
    public function handleRequest($requestUri) {
        // 清理请求URI
        $requestUri = $this->cleanRequestUri($requestUri);
        
        // 确定静态文件路径
        $staticFilePath = $this->getStaticFilePath($requestUri);
        
        // 检查静态文件是否存在且未过期
        if ($this->isStaticFileValid($staticFilePath)) {
            // 直接输出静态文件内容
            $this->outputStaticFile($staticFilePath);
            return;
        }
        
        // 静态文件不存在或已过期，生成新的静态页面
        $this->generateAndOutputPage($requestUri, $staticFilePath);
    }
    
    /**
     * 清理请求URI
     */
    private function cleanRequestUri($uri) {
        // 移除查询参数
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // 移除开头的斜杠
        $uri = ltrim($uri, '/');
        
        // 如果为空，则为首页
        if (empty($uri)) {
            $uri = 'index';
        }
        
        return $uri;
    }
    
    /**
     * 获取静态文件路径
     */
    private function getStaticFilePath($requestUri) {
        // 如果URI不以.html结尾，添加.html
        if (!preg_match('/\.html?$/', $requestUri)) {
            $requestUri .= '.html';
        }
        
        return $this->staticDir . '/' . $requestUri;
    }
    
    /**
     * 检查静态文件是否有效（存在且未过期）
     */
    private function isStaticFileValid($filePath) {
        if (!file_exists($filePath)) {
            return false;
        }
        
        // 检查文件是否过期（这里设置为1小时）
        $maxAge = 3600; // 1小时
        $fileTime = filemtime($filePath);
        
        return (time() - $fileTime) < $maxAge;
    }
    
    /**
     * 输出静态文件内容
     */
    private function outputStaticFile($filePath) {
        // 设置适当的头部
        $this->setHeaders();
        
        // 输出文件内容
        readfile($filePath);
        
        // 记录访问日志
        error_log("静态文件访问: {$filePath}");
    }
    
    /**
     * 生成并输出页面
     */
    private function generateAndOutputPage($requestUri, $staticFilePath) {
        try {
            // 确定原始PHP页面路径
            $phpPagePath = $this->getPhpPagePath($requestUri);
            
            if (!file_exists($phpPagePath)) {
                $this->output404();
                return;
            }
            
            // 生成页面内容
            $content = $this->generatePageContent($phpPagePath);
            
            if (empty($content)) {
                $this->output404();
                return;
            }
            
            // 保存静态文件
            $this->saveStaticFile($staticFilePath, $content);
            
            // 输出内容
            $this->setHeaders();
            echo $content;
            
            // 记录生成日志
            error_log("动态生成静态页面: {$staticFilePath}");
            
        } catch (Exception $e) {
            error_log("生成静态页面错误: " . $e->getMessage());
            $this->output500();
        }
    }
    
    /**
     * 获取PHP页面路径
     */
    private function getPhpPagePath($requestUri) {
        // 处理特殊路径映射
        $pathMappings = [
            'index' => 'index.php',
            'news/(\d+)' => 'news.php?id=$1',
            'category/([^/]+)' => 'category.php?name=$1',
            'category/([^/]+)/page-(\d+)' => 'category.php?name=$1&page=$2',
            'about' => 'about.php',
            'contact' => 'contact.php',
            'privacy' => 'privacy.php',
            'terms' => 'terms.php',
            'tags' => 'tags.php',
        ];
        
        foreach ($pathMappings as $pattern => $phpPath) {
            if (preg_match("#^{$pattern}$#", $requestUri, $matches)) {
                // 处理参数替换
                for ($i = 1; $i < count($matches); $i++) {
                    $phpPath = str_replace('$' . $i, $matches[$i], $phpPath);
                }
                
                // 如果包含查询参数，需要设置$_GET变量
                if (strpos($phpPath, '?') !== false) {
                    list($file, $query) = explode('?', $phpPath, 2);
                    parse_str($query, $params);
                    foreach ($params as $key => $value) {
                        $_GET[$key] = $value;
                    }
                    return $file;
                }
                
                return $phpPath;
            }
        }
        
        return null;
    }
    
    /**
     * 生成页面内容
     */
    private function generatePageContent($phpPagePath) {
        // 开启输出缓冲
        ob_start();
        
        try {
            // 包含PHP页面
            include $phpPagePath;
            
            // 获取输出内容
            $content = ob_get_contents();
            
            // 处理链接，转换为静态链接
            $content = $this->processLinksForStatic($content);
            
            return $content;
            
        } catch (Exception $e) {
            error_log("生成页面内容错误: " . $e->getMessage());
            return '';
        } finally {
            ob_end_clean();
        }
    }
    
    /**
     * 处理链接，转换为静态链接
     */
    private function processLinksForStatic($content) {
        // 转换新闻链接
        $content = preg_replace('/\/news\.php\?id=(\d+)/', '/news/$1.html', $content);
        
        // 转换分类链接
        $content = preg_replace_callback('/\/category\.php\?name=([^"&]+)/', function($matches) {
            return '/category/' . urldecode($matches[1]) . '.html';
        }, $content);
        
        // 转换分页链接
        $content = preg_replace_callback('/\/category\.php\?name=([^"&]+)&page=(\d+)/', function($matches) {
            return '/category/' . urldecode($matches[1]) . '/page-' . $matches[2] . '.html';
        }, $content);
        
        // 转换其他页面链接
        $content = str_replace('/about.php', '/about.html', $content);
        $content = str_replace('/contact.php', '/contact.html', $content);
        $content = str_replace('/privacy.php', '/privacy.html', $content);
        $content = str_replace('/terms.php', '/terms.html', $content);
        $content = str_replace('/tags.php', '/tags.html', $content);
        
        return $content;
    }
    
    /**
     * 保存静态文件
     */
    private function saveStaticFile($filePath, $content) {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents($filePath, $content);
    }
    
    /**
     * 设置HTTP头部
     */
    private function setHeaders() {
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: public, max-age=3600');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    }
    
    /**
     * 输出404页面
     */
    private function output404() {
        http_response_code(404);
        
        // 尝试包含404页面
        if (file_exists('404.php')) {
            include '404.php';
        } else {
            echo '<h1>404 - 页面未找到</h1>';
        }
    }
    
    /**
     * 输出500错误页面
     */
    private function output500() {
        http_response_code(500);
        echo '<h1>500 - 服务器内部错误</h1>';
    }
}

// 如果直接访问此文件，处理请求
if (basename($_SERVER['SCRIPT_NAME']) === 'static_handler.php') {
    $handler = new StaticHandler();
    $requestUri = $_SERVER['REQUEST_URI'];
    $handler->handleRequest($requestUri);
}
?> 