<?php
require_once 'app/models/AccountModel.php';
require_once 'app/helpers/SessionHelper.php';

class AdminController {
    private $accountModel;
    
    public function __construct() {
        // Kết nối database
        $host = "localhost";
        $dbname = "webbanhang";
        $username = "root";
        $password = "";
        
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->accountModel = new AccountModel($conn);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    // Phương thức tạo tài khoản admin
    public function setupAdmin() {
        // Thông tin tài khoản admin mặc định
        $admin_username = "admin";
        $admin_fullname = "Administrator";
        $admin_password = "admin123"; // Nên đổi mật khẩu này sau khi đăng nhập lần đầu
        $admin_role = "admin";
        
        // Kiểm tra xem tài khoản admin đã tồn tại chưa
        $existingAdmin = $this->accountModel->getAccountByUsername($admin_username);
        
        if ($existingAdmin) {
            echo '<div class="alert alert-info">Tài khoản admin đã tồn tại. Hãy đăng nhập với username: admin và mật khẩu đã đặt.</div>';
        } else {
            // Tạo tài khoản admin mới
            $result = $this->accountModel->save($admin_username, $admin_fullname, $admin_password, $admin_role);
            
            if ($result) {
                echo '<div class="alert alert-success">Tài khoản admin đã được tạo thành công!<br>';
                echo 'Username: admin<br>';
                echo 'Mật khẩu: admin123<br>';
                echo 'Hãy đăng nhập và đổi mật khẩu ngay để bảo mật tài khoản.</div>';
            } else {
                echo '<div class="alert alert-danger">Có lỗi xảy ra khi tạo tài khoản admin.</div>';
            }
        }
        
        // Hiển thị form đăng nhập
        $this->showLoginForm();
    }
    
    // Hiển thị form đăng nhập
    private function showLoginForm() {
        echo '<!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Đăng nhập Admin</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
            <style>
                .login-container {
                    max-width: 400px;
                    margin: 100px auto;
                    padding: 20px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    border-radius: 5px;
                }
                .btn-primary {
                    background-color: #007bff;
                    border-color: #007bff;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="login-container">
                    <h2 class="text-center mb-4">Đăng nhập</h2>
                    <form action="index.php?url=Account/login" method="post">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="index.php" class="btn btn-link">Quay lại trang chủ</a>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>';
    }
}
?>
