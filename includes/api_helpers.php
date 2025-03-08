<?php
/**
 * API辅助函数
 * 提供调用API等公共函数
 * 注意：get_domain_config函数已移至functions.php，避免重复声明
 */

/**
 * 调用API
 * 
 * @param string $endpoint API端点
 * @param array $params 参数
 * @param string $method 请求方法
 * @return array|null 返回API结果数组或null
 */
function call_api($endpoint, $params = [], $method = 'GET') {
    // API基础URL
    $api_base_url = API_BASE_URL . '/api/';
    
    // 构建完整URL
    $url = $api_base_url . $endpoint;
    
    // 初始化cURL
    $ch = curl_init();
    
    // 设置cURL选项
    if ($method === 'GET' && !empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    }
    
    // 执行cURL请求
    $response = curl_exec($ch);
    $error = curl_error($ch);
    
    // 关闭cURL连接
    curl_close($ch);
    
    // 记录API请求日志
    error_log('API请求: ' . $url);
    error_log('请求参数: ' . json_encode($params));
    
    // 处理响应
    if ($error) {
        error_log('API请求错误: ' . $error);
        return ['code' => 500, 'message' => 'API请求失败: ' . $error];
    }
    
    // 解析JSON响应
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON解析错误: ' . json_last_error_msg());
        return ['code' => 500, 'message' => 'JSON解析失败: ' . json_last_error_msg()];
    }
    
    return $data;
} 