<?php
require_once 'app/views/shares/header.php';
$edit_mode = isset($_GET['edit']) && $_GET['edit'] == 1;
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <?php if (!empty($account->avatar)): ?>
                        <img src="/webbanhang/<?php echo $account->avatar; ?>" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <img src="/webbanhang/assets/images/default-avatar.png" alt="Default Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php endif; ?>
                    <h5 class="card-title"><?php echo $account->fullname; ?></h5>
                    <p class="card-text">
                        <small class="text-muted">@<?php echo $account->username; ?></small>
                    </p>
                    <p class="card-text">
                        <span class="badge bg-<?php echo ($account->role === 'admin') ? 'danger' : 'primary'; ?>">
                            <?php echo ($account->role === 'admin') ? 'Admin' : 'Người dùng'; ?>
                        </span>
                    </p>
                    <?php if (!$edit_mode): ?>
                        <div class="mt-3">
                            <a href="/webbanhang/account/profile?edit=1" class="btn btn-primary btn-block">Chỉnh sửa thông tin cá nhân</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $edit_mode ? 'Chỉnh sửa thông tin cá nhân' : 'Thông tin cá nhân'; ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                        <div class="alert alert-success">Cập nhật thông tin thành công!</div>
                    <?php endif; ?>

                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($edit_mode): ?>
                        <!-- Form chỉnh sửa thông tin -->
                        <form action="/webbanhang/account/updateProfile" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" value="<?php echo $account->username; ?>" readonly>
                                <small class="form-text text-muted">Tên đăng nhập không thể thay đổi</small>
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $account->fullname; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $account->email ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $account->phone ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Ảnh đại diện</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif">
                                <small class="form-text text-muted">Chấp nhận file: JPG, PNG, GIF. Kích thước tối đa: 2MB.</small>
                            </div>
                            <hr>
                            <h5>Đổi mật khẩu</h5>
                            <small class="form-text text-muted mb-3 d-block">Để trống nếu không muốn thay đổi mật khẩu</small>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="confirmpassword" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                                <a href="/webbanhang/account/profile" class="btn btn-secondary">Hủy chỉnh sửa</a>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- Hiển thị thông tin cá nhân -->
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tên đăng nhập:</div>
                            <div class="col-md-8"><?php echo $account->username; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Họ và tên:</div>
                            <div class="col-md-8"><?php echo $account->fullname; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Email:</div>
                            <div class="col-md-8"><?php echo $account->email ?? 'Chưa cập nhật'; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Số điện thoại:</div>
                            <div class="col-md-8"><?php echo $account->phone ?? 'Chưa cập nhật'; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Vai trò:</div>
                            <div class="col-md-8"><?php echo ($account->role === 'admin') ? 'Admin' : 'Người dùng'; ?></div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <a href="/webbanhang/product" class="btn btn-secondary">Quay lại</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'app/views/shares/footer.php';
?>
