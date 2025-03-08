<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">所有标签</h1>
            
            <?php if (empty($tags)): ?>
                <div class="alert alert-info">暂无标签</div>
            <?php else: ?>
                <!-- 标签云 -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="card-title mb-4">标签云</h5>
                        <div class="tag-cloud">
                            <?php foreach ($tags as $tag): ?>
                                <?php 
                                    $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : $tag;
                                    $tagFrequency = is_array($tag) && isset($tag['frequency']) ? $tag['frequency'] : 1;
                                ?>
                                <a href="/tag.php?name=<?php echo urlencode($tagName); ?>" 
                                   class="tag-item" 
                                   style="font-size: <?php echo (0.8 + ($tagFrequency / 50) * 0.7); ?>rem;
                                          opacity: <?php echo (0.6 + ($tagFrequency / 50) * 0.4); ?>;">
                                    <?php echo htmlspecialchars($tagName); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- 按字母排序的标签列表 -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">按字母排序</h5>
                        
                        <?php
                        // 按名称排序
                        $sortedTags = $tags;
                        usort($sortedTags, function($a, $b) {
                            $nameA = is_array($a) && isset($a['name']) ? $a['name'] : $a;
                            $nameB = is_array($b) && isset($b['name']) ? $b['name'] : $b;
                            return strcmp($nameA, $nameB);
                        });
                        
                        // 按首字母分组
                        $groupedTags = [];
                        foreach ($sortedTags as $tag) {
                            $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : $tag;
                            if (!empty($tagName)) {
                                $firstChar = mb_strtoupper(mb_substr($tagName, 0, 1, 'UTF-8'), 'UTF-8');
                                if (!isset($groupedTags[$firstChar])) {
                                    $groupedTags[$firstChar] = [];
                                }
                                $groupedTags[$firstChar][] = $tag;
                            }
                        }
                        
                        // 显示分组标签
                        ksort($groupedTags);
                        foreach ($groupedTags as $char => $charTags):
                        ?>
                            <div class="tag-group mb-4">
                                <h3 class="tag-group-title"><?php echo htmlspecialchars($char); ?></h3>
                                <div class="tag-group-items">
                                    <?php foreach ($charTags as $tag): ?>
                                        <?php 
                                            $tagName = is_array($tag) && isset($tag['name']) ? $tag['name'] : $tag;
                                            $tagFrequency = is_array($tag) && isset($tag['frequency']) ? $tag['frequency'] : 0;
                                        ?>
                                        <a href="/tag.php?name=<?php echo urlencode($tagName); ?>" class="btn btn-outline-primary me-2 mb-2">
                                            <?php echo htmlspecialchars($tagName); ?>
                                            <span class="badge bg-secondary"><?php echo $tagFrequency; ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <?php include 'views/partials/sidebar.php'; ?>
        </div>
    </div>
</div>

<style>
.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.tag-item {
    display: inline-block;
    margin: 5px;
    padding: 5px 10px;
    text-decoration: none;
    color: #0d6efd;
    transition: all 0.3s ease;
}

.tag-item:hover {
    color: #fff;
    background-color: #0d6efd;
    border-radius: 20px;
    transform: scale(1.1);
}

.tag-group-title {
    font-size: 1.5rem;
    padding-bottom: 10px;
    border-bottom: 2px solid #0d6efd;
    margin-bottom: 15px;
}

.tag-group-items {
    padding-left: 10px;
}
</style> 