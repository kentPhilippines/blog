<div class="search-form mb-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">搜索新闻</h5>
        </div>
        <div class="card-body">
            <form action="/search.php" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="keyword" placeholder="输入关键词..." value="<?php echo isset($keyword) ? htmlspecialchars($keyword) : ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>搜索
                        </button>
                    </div>
                </div>
                
                <?php if (isset($categories) && !empty($categories)): ?>
                <div class="mt-3">
                    <label class="form-label">按分类筛选（可选）</label>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($categories as $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $category; ?>" id="category-<?php echo md5($category); ?>" <?php echo isset($_GET['categories']) && in_array($category, $_GET['categories']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="category-<?php echo md5($category); ?>">
                                <?php echo htmlspecialchars($category); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="mt-3">
                    <label class="form-label">高级选项</label>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <select name="sort" class="form-select">
                                <option value="relevance" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'relevance') ? 'selected' : ''; ?>>按相关度排序</option>
                                <option value="date_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_desc') ? 'selected' : ''; ?>>按日期降序</option>
                                <option value="date_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_asc') ? 'selected' : ''; ?>>按日期升序</option>
                                <option value="views" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'views') ? 'selected' : ''; ?>>按浏览量</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="time" class="form-select">
                                <option value="all" <?php echo (!isset($_GET['time']) || $_GET['time'] == 'all') ? 'selected' : ''; ?>>所有时间</option>
                                <option value="day" <?php echo (isset($_GET['time']) && $_GET['time'] == 'day') ? 'selected' : ''; ?>>最近24小时</option>
                                <option value="week" <?php echo (isset($_GET['time']) && $_GET['time'] == 'week') ? 'selected' : ''; ?>>最近一周</option>
                                <option value="month" <?php echo (isset($_GET['time']) && $_GET['time'] == 'month') ? 'selected' : ''; ?>>最近一个月</option>
                                <option value="year" <?php echo (isset($_GET['time']) && $_GET['time'] == 'year') ? 'selected' : ''; ?>>最近一年</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 