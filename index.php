<?php
session_start();
// Thêm định nghĩa BASE_PATH
define('BASE_PATH', __DIR__);

// Determine BASE_URL dynamically
$scriptName = $_SERVER['SCRIPT_NAME'];
$baseDir = str_replace('\\', '/', dirname($scriptName));
// Ensure baseDir ends with a slash if it's not the root
$baseUrl = $baseDir === '/' ? '/' : $baseDir . '/';
define('BASE_URL', $baseUrl);

require_once BASE_PATH . '/app/models/ProductModel.php';
require_once BASE_PATH . '/app/helpers/SessionHelper.php';
// Product/add
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);
// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'ProductController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';
// die ("controller=$controllerName - action=$action");
// Kiểm tra xem controller và action có tồn tại không
// Sửa phần kiểm tra file_exists
if (!file_exists(BASE_PATH . '/app/controllers/' . $controllerName . '.php')) {
    die('Controller not found');
}

require_once BASE_PATH . '/app/controllers/' . $controllerName . '.php';
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    die('Action not found');
}

call_user_func_array([$controller, $action], array_slice($url, 2));