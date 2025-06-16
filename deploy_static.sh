#!/bin/bash

# 静态网站部署脚本

echo "=== 开始静态网站部署 ==="

# 配置
PHP_SERVER_PORT=8000
STATIC_DIR="static"
BACKUP_DIR="backup/$(date +%Y%m%d_%H%M%S)"

# 创建备份
if [ -d "$STATIC_DIR" ]; then
    echo "创建备份..."
    mkdir -p "$BACKUP_DIR"
    cp -r "$STATIC_DIR"/* "$BACKUP_DIR"/
fi

# 启动PHP开发服务器
echo "启动PHP服务器..."
php -S localhost:$PHP_SERVER_PORT > /dev/null 2>&1 &
PHP_PID=$!
echo "PHP服务器已启动 (PID: $PHP_PID)"

# 等待服务器启动
sleep 3

# 生成静态页面
echo "生成静态页面..."
php generate_static.php rebuild

# 停止PHP服务器
echo "停止PHP服务器..."
kill $PHP_PID

# 复制静态资源
echo "复制静态资源..."
cp -r assets/ "$STATIC_DIR"/
cp -r uploads/ "$STATIC_DIR"/ 2>/dev/null || true

# 生成.htaccess文件（用于Apache）
echo "生成.htaccess文件..."
cat > "$STATIC_DIR/.htaccess" << 'EOF'
# 开启重写引擎
RewriteEngine On

# 错误页面
ErrorDocument 404 /404.html

# 缓存设置
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/svg+xml "access plus 1 month"
</IfModule>

# Gzip压缩
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
EOF

# 生成nginx配置
echo "生成nginx配置..."
cat > "$STATIC_DIR/nginx.conf" << 'EOF'
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/static;
    index index.html;

    # Gzip压缩
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types
        text/plain
        text/css
        text/xml
        text/javascript
        application/json
        application/javascript
        application/xml+rss
        application/atom+xml
        image/svg+xml;

    # 缓存设置
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1M;
        add_header Cache-Control "public, immutable";
    }

    # HTML文件不缓存
    location ~* \.html$ {
        expires -1;
        add_header Cache-Control "no-cache, no-store, must-revalidate";
    }

    # 404处理
    error_page 404 /404.html;

    # 安全头
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
}
EOF

echo "=== 静态网站部署完成 ==="
echo "静态文件位置: $STATIC_DIR"
echo "备份位置: $BACKUP_DIR"
echo ""
echo "下一步："
echo "1. 将 $STATIC_DIR 目录内容上传到你的Web服务器"
echo "2. 配置Web服务器使用提供的配置文件"
echo "3. 设置定时任务定期重新生成静态页面" 