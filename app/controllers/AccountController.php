<?php
require_once 'app/config/database.php';
require_once 'app/models/AccountModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/helpers/FileUploadHelper.php';

class AccountController {
    private $accountModel;

    public function __construct() {
        $db = Database::getConnection();
        $this->accountModel = new AccountModel($db);
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    /**
     * Chỉnh sửa hồ sơ cá nhân cho người dùng đã đăng nhập
     */
    public function profile() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit;
        }

        $username = $_SESSION['username'];
        $account = $this->accountModel->getAccountByUsername($username);

        if (!$account) {
            echo '<div class="alert alert-danger">Không thể tải thông tin tài khoản!</div>';
            header('Refresh: 3; URL=/webbanhang/product');
            return;
        }

        include_once 'app/views/account/profile.php';
    }

    /**
     * Cập nhật hồ sơ cá nhân cho người dùng đã đăng nhập
     */
    public function updateProfile() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_SESSION['username'];
            $account = $this->accountModel->getAccountByUsername($username);

            if (!$account) {
                echo '<div class="alert alert-danger">Không thể tải thông tin tài khoản!</div>';
                header('Refresh: 3; URL=/webbanhang/product');
                return;
            }

            $fullName = $_POST['fullname'] ?? '';
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';

            $errors = [];
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập họ tên!";

            if ($password && $password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            }

            // Kiểm tra định dạng email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không đúng định dạng!";
            }

            // Kiểm tra định dạng số điện thoại
            if (!empty($phone) && !preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors['phone'] = "Số điện thoại không đúng định dạng (10-11 số)!";
            }

            // Xử lý upload avatar mới nếu có
            $avatarPath = $account->avatar;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
                $uploadResult = FileUploadHelper::uploadAvatar($_FILES['avatar'], $username);
                if ($uploadResult['success']) {
                    // Xóa avatar cũ nếu có
                    if (!empty($account->avatar)) {
                        FileUploadHelper::deleteOldAvatar($account->avatar);
                    }
                    $avatarPath = $uploadResult['filename'];
                } else {
                    $errors['avatar'] = $uploadResult['error'];
                }
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/profile.php';
            } else {
                $result = $this->accountModel->updateAccount($account->id, $fullName, $account->role, $password, $email, $phone, $avatarPath);

                if ($result === true) {
                    header('Location: /webbanhang/account/profile?success=1');
                    exit;
                } else {
                    $errors['update'] = $result['error'] ?? "Có lỗi xảy ra khi cập nhật!";
                    include_once 'app/views/account/profile.php';
                }
            }
        }
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';

            $errors = [];
            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";

            // Kiểm tra định dạng email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không đúng định dạng!";
            }

            // Kiểm tra định dạng số điện thoại
            if (!empty($phone) && !preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors['phone'] = "Số điện thoại không đúng định dạng (10-11 số)!";
            }

            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            // Xử lý upload avatar nếu có
            $avatarPath = '';
            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
                $uploadResult = FileUploadHelper::uploadAvatar($_FILES['avatar'], $username);
                if ($uploadResult['success']) {
                    $avatarPath = $uploadResult['filename'];
                } else {
                    $errors['avatar'] = $uploadResult['error'];
                }
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $result = $this->accountModel->save($username, $fullName, $password, 'user', $email, $phone, $avatarPath);
                if ($result) {
                    header('Location: /webbanhang/account/login');
                    exit;
                }
            }
        }
    }

    public function logout() {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang/product');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account && password_verify($password, $account->password)) {
                session_start();
                if (!isset($_SESSION['username'])) {
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role;
                }
                header('Location: /webbanhang/product');
                exit;
            } else {
                $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
                include_once 'app/views/account/login.php';
                exit;
            }
        }
    }

    /**
     * Quản lý người dùng - Hiển thị danh sách người dùng
     */
    public function manageUsers() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=/webbanhang/product');
            return;
        }

        $accounts = $this->accountModel->getAllAccounts();
        include_once 'app/views/account/manage.php';
    }

    /**
     * Hiển thị form thêm người dùng mới (chỉ admin)
     */
    public function addUser() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
            return;
        }

        include_once 'app/views/account/add_user.php';
    }

    /**
     * Lưu người dùng mới (chỉ admin)
     */
    public function saveUser() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';

            $errors = [];
            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            if (!in_array($role, ['admin', 'user'])) $role = 'user';

            // Kiểm tra định dạng email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không đúng định dạng!";
            }

            // Kiểm tra định dạng số điện thoại
            if (!empty($phone) && !preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors['phone'] = "Số điện thoại không đúng định dạng (10-11 số)!";
            }

            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            // Xử lý upload avatar nếu có
            $avatarPath = '';
            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
                $uploadResult = FileUploadHelper::uploadAvatar($_FILES['avatar'], $username);
                if ($uploadResult['success']) {
                    $avatarPath = $uploadResult['filename'];
                } else {
                    $errors['avatar'] = $uploadResult['error'];
                }
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/add_user.php';
            } else {
                $result = $this->accountModel->save($username, $fullName, $password, $role, $email, $phone, $avatarPath);
                if ($result) {
                    header('Location: /webbanhang/account/manageUsers');
                    exit;
                }
            }
        }
    }

    /**
     * Hiển thị form chỉnh sửa người dùng (chỉ admin)
     */
    public function editUser($id) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
            return;
        }

        $account = $this->accountModel->getAccountById($id);
        if (!$account) {
            echo '<div class="alert alert-danger">Không tìm thấy người dùng!</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
            return;
        }

        include_once 'app/views/account/edit_user.php';
    }

    /**
     * Cập nhật thông tin người dùng (chỉ admin)
     */
    public function updateUser() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';

            $errors = [];
            if (empty($id)) $errors['id'] = "ID người dùng không hợp lệ!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (!in_array($role, ['admin', 'user'])) $role = 'user';

            if ($password && $password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            }

            // Kiểm tra định dạng email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không đúng định dạng!";
            }

            // Kiểm tra định dạng số điện thoại
            if (!empty($phone) && !preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors['phone'] = "Số điện thoại không đúng định dạng (10-11 số)!";
            }

            // Lấy thông tin tài khoản hiện tại
            $account = $this->accountModel->getAccountById($id);
            if (!$account) {
                echo '<div class="alert alert-danger">Không tìm thấy tài khoản!</div>';
                header('Refresh: 3; URL=/webbanhang/account/manageUsers');
                return;
            }

            // Xử lý upload avatar mới nếu có
            $avatarPath = $account->avatar;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
                $uploadResult = FileUploadHelper::uploadAvatar($_FILES['avatar'], $account->username);
                if ($uploadResult['success']) {
                    // Xóa avatar cũ nếu có
                    if (!empty($account->avatar)) {
                        FileUploadHelper::deleteOldAvatar($account->avatar);
                    }
                    $avatarPath = $uploadResult['filename'];
                } else {
                    $errors['avatar'] = $uploadResult['error'];
                }
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/edit_user.php';
            } else {
                $result = $this->accountModel->updateAccount($id, $fullName, $role, $password, $email, $phone, $avatarPath);

                if ($result === true) {
                    header('Location: /webbanhang/account/manageUsers');
                    exit;
                } else {
                    $errors['update'] = $result['error'] ?? "Có lỗi xảy ra khi cập nhật!";
                    include_once 'app/views/account/edit_user.php';
                }
            }
        }
    }

    /**
     * Xóa người dùng (chỉ admin)
     */
    public function deleteUser($id) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
            return;
        }

        $result = $this->accountModel->deleteAccount($id);

        if ($result === true) {
            header('Location: /webbanhang/account/manageUsers');
            exit;
        } else {
            echo '<div class="alert alert-danger">Lỗi: ' . $result . '</div>';
            header('Refresh: 3; URL=/webbanhang/account/manageUsers');
        }
    }

    /**
     * Tạo tài khoản admin trực tiếp trong code
     */
    public function setupAdmin() {
        $admin = $this->accountModel->getAccountByUsername('admin');
        if ($admin) {
            echo '<div class="alert alert-success">Tài khoản admin đã tồn tại!</div>';
            echo '<a href="/webbanhang/account/login">Đăng nhập</a>';
            return;
        }

        $username = 'admin';
        $fullName = 'Administrator';
        $password = 'admin123';
        $role = 'admin';
        $email = 'admin@webbanhang.com';
        $phone = '0123456789';

        $result = $this->accountModel->save($username, $fullName, $password, $role, $email, $phone);

        if ($result) {
            echo '<div class="alert alert-success">Tài khoản admin đã được tạo thành công!</div>';
            echo '<p>Username: admin</p>';
            echo '<p>Password: admin123</p>';
            echo '<p><a href="/webbanhang/account/login">Đăng nhập</a></p>';
        } else {
            echo '<div class="alert alert-danger">Có lỗi xảy ra khi tạo tài khoản admin!</div>';
        }
    }
}
?>