<?php
require_once 'app/config/database.php';

// Đọc nội dung file SQL
$sql = file_get_contents('database_update.sql');

try {
    // Kết nối đến cơ sở dữ liệu
    $conn = Database::getConnection();
    
    // Thực thi câu lệnh SQL
    $result = $conn->exec($sql);
    
    echo "Cập nhật cơ sở dữ liệu thành công!";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
