# 新闻博客系统

## 项目概述

这是一个基于PHP开发的新闻博客系统，通过API获取新闻数据并展示。系统采用MVC架构设计，视图层使用模板文件组织，使得项目结构清晰，便于扩展和维护。适用于需要快速搭建新闻资讯类网站的开发者或企业。

## 功能特点

- ✅ 响应式设计，完美适配手机、平板和桌面设备
- 📰 新闻列表展示，支持分页浏览
- 📝 新闻详情页，完整展示内容和相关信息
- 📂 分类浏览，按不同主题快速筛选内容
- 🔖 标签系统，通过标签关联相似内容
- 🔍 搜索功能，快速查找感兴趣的新闻
- 🔥 热门新闻推荐，展示最受欢迎的内容
- 📡 RSS订阅功能，方便用户订阅内容
- 🗺️ 自动生成网站地图，优化SEO

## 系统要求

- PHP 7.4 或更高版本
- 服务器支持 cURL 扩展（用于API请求）
- 服务器支持 JSON 扩展（用于数据解析）
- 网络服务器（Apache/Nginx）
- 可写的缓存目录权限

## 安装步骤

1. 将所有文件上传到您的Web服务器根目录
2. 确保 `cache` 目录具有可写权限：
   ```bash
   chmod 775 cache
   ```
3. 修改 `config.php` 中的API基础URL为您的实际API地址：
   ```php
   define('API_BASE_URL', 'http://你的API服务器地址');
   ```
4. 根据需要调整其他配置参数（网站名称、缓存等）
5. 访问网站首页，验证安装是否成功

## 目录结构

```
├── api/                # API相关类
│   └── ApiClient.php   # API客户端
├── assets/             # 静态资源
│   ├── css/            # CSS样式
│   └── js/             # JavaScript脚本
├── cache/              # 缓存目录
├── includes/           # 包含文件
│   └── Utils.php       # 工具类
├── templates/          # 模板文件
│   ├── views1      # 模版1
│   └── views2      # 模版2
├── views/              # 默认模版
│   ├── errors/         # 错误页面模板
│   ├── home/           # 首页相关模板
│   ├── layouts/        # 布局模板
│   ├── news/           # 新闻相关模板
│   ├── partials/       # 公共部分模板
│   ├── search/         # 搜索相关模板
│   ├── category/       # 分类页面模板
│   └── tag/            # 标签页面模板
├── 404.php             # 404错误页
├── api_proxy.php       # API代理
├── category.php        # 分类页
├── config.php          # 配置文件
├── index.php           # 首页
├── news.php            # 新闻详情页
├── rss.php             # RSS订阅页
├── search.php          # 搜索页
├── sitemap.php         # 站点地图
├── tag.php             # 标签页
├── tags.php            # 标签列表页
└── README.md           # 说明文档
```

## 视图结构

系统使用模板文件组织视图层，便于扩展和维护：

- `views/layouts/main.php` - 主布局模板，包含HTML基本结构
- `views/partials/` - 公共部分模板，如页头、页脚、侧边栏等
- `views/home/` - 首页相关模板，包含特色新闻、分类新闻等
- `views/news/` - 新闻相关模板，包含新闻列表、新闻详情等
- `views/search/` - 搜索相关模板
- `views/errors/` - 错误页面模板

## 添加新模板

要添加新的模板，只需按照以下步骤操作：

1. 在相应的目录下创建新的PHP文件，例如：
   ```php
   // views/news/custom_layout.php
   <div class="custom-container">
       <?php if (isset($news)): ?>
           <h1><?php echo htmlspecialchars($news['title']); ?></h1>
           <!-- 其他自定义内容 -->
       <?php endif; ?>
   </div>
   ```

2. 在控制器中设置视图路径：
   ```php
   $viewPath = 'views/news/custom_layout.php';
   ```

3. 包含主布局模板：
   ```php
   include 'views/layouts/main.php';
   ```

## API接口

系统使用以下API接口获取数据：

| 接口 | 描述 | 参数 |
|------|------|------|
| `/api/news/list` | 获取新闻列表 | `page`, `pageSize`, `category` |
| `/api/news/detail/{id}` | 获取新闻详情 | `id` |
| `/api/news/hot` | 获取热门新闻 | `limit` |
| `/api/news/search` | 搜索新闻 | `keyword`, `page`, `pageSize` |
| `/api/tag/list` | 获取标签列表 | 无 |
| `/api/category/list` | 获取分类列表 | 无 |

## 自定义配置

您可以在 `config.php` 文件中修改以下配置：

```php
// API配置
define('API_BASE_URL', 'http://你的API服务器地址');

// 网站基本配置
define('SITE_NAME', '新闻博客');
define('SITE_DESCRIPTION', '提供最新、最热门的新闻资讯');
define('SITE_KEYWORDS', '新闻,博客,资讯,热点');

// 分页配置
define('DEFAULT_PAGE_SIZE', 10);

// 缓存配置
define('ENABLE_CACHE', true); // 启用或禁用缓存
define('CACHE_EXPIRATION', 3600); // 缓存过期时间（秒）

// 时区设置
date_default_timezone_set('Asia/Shanghai');
```

## 缓存机制

系统使用文件缓存来提高性能，减少API请求次数。缓存文件存储在 `cache` 目录中，默认过期时间为1小时。

您可以通过清空 `cache` 目录手动刷新缓存：

```bash
rm -rf cache/*
```

## 多域名支持

系统支持多域名配置，可以根据不同域名加载不同的模板和配置。只需在API中为不同域名设置对应的配置信息即可。

## 常见问题

### 安装后页面显示空白
- 检查PHP版本是否满足要求
- 确认API服务器地址配置正确
- 查看服务器错误日志

### 如何更改网站主题？
修改 `assets/css` 目录下的CSS文件，或者创建新的主题文件并在模板中引用。

### 如何添加自定义功能？
1. 在适当的目录创建相应的PHP文件
2. 添加必要的视图模板
3. 如需新的API接口，在ApiClient.php中添加相应方法

## 性能优化建议

1. 启用PHP缓存扩展（如OPcache）
2. 使用CDN加速静态资源
3. 调整缓存过期时间，根据内容更新频率设置
4. 考虑使用数据库缓存热门内容

## 许可证

本项目采用 [MIT许可证](https://opensource.org/licenses/MIT) 发布，详情请查看LICENSE文件。

## 联系与支持

如有问题或建议，请通过以下方式联系我们：
- 提交GitHub Issue
- 发送邮件至：support@example.com

---

感谢您使用新闻博客系统！