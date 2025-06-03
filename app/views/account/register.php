<?php include 'app/views/shares/header.php'; ?>
<?php
if (isset($errors)) {
    echo "<ul>";
    foreach ($errors as $err) {
        echo "<li class='text-danger'>$err</li>";
    }
    echo "</ul>";
}
?>
<div class="card-body p-5 text-center">
    <h2 class="mb-4">Đăng ký tài khoản</h2>
    <form class="user" action="/webbanhang/account/save" method="post" enctype="multipart/form-data">
        <div class="form-group row mb-3">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-user"
                id="username" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div class="col-sm-6">
                <label for="fullname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-user"
                id="fullname" name="fullname" placeholder="Họ và tên" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control form-control-user"
                id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="col-sm-6">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control form-control-user"
                id="phone" name="phone" placeholder="Số điện thoại" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif">
            <small class="form-text text-muted">Chấp nhận file: JPG, PNG, GIF. Kích thước tối đa: 2MB.</small>
        </div>
        <div class="form-group row mb-3">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-user"
                id="password" name="password" placeholder="Mật khẩu">
            </div>
            <div class="col-sm-6">
                <label for="confirmpassword" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-user"
                id="confirmpassword" name="confirmpassword" placeholder="Xác nhận mật khẩu">
            </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-icon-split p-3">
                Đăng ký
            </button>
            <div class="mt-3">
                <a href="/webbanhang/account/login" class="text-decoration-none">Đã có tài khoản? Đăng nhập ngay</a>
            </div>
        </div>
    </form>
</div>
<?php include 'app/views/shares/footer.php'; ?>