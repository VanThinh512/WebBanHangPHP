<?php
require_once 'app/views/shares/header.php';
$edit_mode = isset($_GET['edit']) && $_GET['edit'] == 1;
?>

<div class="container mt-5 animate__animated animate__fadeIn">
    <!-- Hero Section -->
    <div class="profile-hero-section mb-5">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h1 class="display-4 font-weight-bold mb-3">Thông tin cá nhân</h1>
                        <p class="lead text-muted mb-4">Quản lý thông tin cá nhân và cập nhật tài khoản của bạn.</p>
                        <?php if (!$edit_mode): ?>
                            <a href="<?php echo BASE_URL; ?>account/profile?edit=1" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-edit mr-2"></i> Chỉnh sửa thông tin
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4 text-center">
                        <?php if (!empty($account->avatar)): ?>
                            <img src="<?php echo BASE_URL; ?><?php echo $account->avatar; ?>" alt="Avatar" class="img-fluid rounded-circle shadow-lg" style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white;">
                        <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>public/images/default-avatar.png" alt="Default Avatar" class="img-fluid rounded-circle shadow-lg" style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Thông tin cơ bản -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 animate__animated animate__fadeInLeft animate__delay-1s">
                <div class="card-body text-center">
                    <div class="py-3">
                        <?php if (!empty($account->avatar)): ?>
                            <img src="<?php echo BASE_URL; ?><?php echo $account->avatar; ?>" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #f8f9fa;">
                        <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>public/images/default-avatar.png" alt="Default Avatar" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #f8f9fa;">
                        <?php endif; ?>
                        <h5 class="card-title font-weight-bold"><?php echo $account->fullname; ?></h5>
                        <p class="card-text">
                            <small class="text-muted">@<?php echo $account->username; ?></small>
                        </p>
                        <p class="card-text">
                            <span class="badge <?php echo ($account->role === 'admin') ? 'bg-danger' : 'bg-primary'; ?> text-white px-3 py-2 rounded-pill">
                                <i class="fas <?php echo ($account->role === 'admin') ? 'fa-user-shield' : 'fa-user'; ?> mr-1"></i>
                                <?php echo ($account->role === 'admin') ? 'Admin' : 'Người dùng'; ?>
                            </span>
                        </p>
                    </div>
                    
                    <div class="border-top pt-3">
                        <div class="row text-center">
                            <div class="col">
                                <i class="fas fa-envelope text-primary mb-2"></i>
                                <p class="small mb-0"><?php echo $account->email ?? 'Chưa cập nhật'; ?></p>
                            </div>
                            <div class="col">
                                <i class="fas fa-phone text-primary mb-2"></i>
                                <p class="small mb-0"><?php echo $account->phone ?? 'Chưa cập nhật'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Thông tin chi tiết / Form chỉnh sửa -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInRight animate__delay-1s">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 font-weight-bold">
                        <i class="fas <?php echo $edit_mode ? 'fa-user-edit' : 'fa-user-circle'; ?> mr-2 text-primary"></i>
                        <?php echo $edit_mode ? 'Chỉnh sửa thông tin cá nhân' : 'Thông tin cá nhân'; ?>
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> Cập nhật thông tin thành công!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i> Vui lòng kiểm tra lại thông tin:
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if ($edit_mode): ?>
                        <!-- Form chỉnh sửa thông tin -->
                        <form action="<?php echo BASE_URL; ?>account/updateProfile" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label font-weight-bold">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="username" value="<?php echo $account->username; ?>" readonly>
                                    </div>
                                    <small class="form-text text-muted">Tên đăng nhập không thể thay đổi</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fullname" class="form-label font-weight-bold">Họ và tên</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $account->fullname; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label font-weight-bold">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $account->email ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label font-weight-bold">Số điện thoại</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $account->phone ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="avatar" class="form-label font-weight-bold">Ảnh đại diện</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif">
                                    <label class="custom-file-label" for="avatar">Chọn file...</label>
                                </div>
                                <small class="form-text text-muted">Chấp nhận file: JPG, PNG, GIF. Kích thước tối đa: 2MB.</small>
                            </div>
                            
                            <div class="card mb-4 border-light bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-lock mr-2 text-primary"></i> Đổi mật khẩu
                                    </h5>
                                    <small class="form-text text-muted mb-3 d-block">Để trống nếu không muốn thay đổi mật khẩu</small>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label font-weight-bold">Mật khẩu mới</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white"><i class="fas fa-key"></i></span>
                                                </div>
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="confirmpassword" class="form-label font-weight-bold">Xác nhận mật khẩu mới</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white"><i class="fas fa-check-double"></i></span>
                                                </div>
                                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?php echo BASE_URL; ?>account/profile" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-2"></i> Hủy chỉnh sửa
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i> Cập nhật thông tin
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- Hiển thị thông tin cá nhân -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%" class="border-top-0">
                                            <i class="fas fa-user text-primary mr-2"></i> Tên đăng nhập
                                        </th>
                                        <td class="border-top-0"><?php echo $account->username; ?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <i class="fas fa-id-card text-primary mr-2"></i> Họ và tên
                                        </th>
                                        <td><?php echo $account->fullname; ?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <i class="fas fa-envelope text-primary mr-2"></i> Email
                                        </th>
                                        <td><?php echo $account->email ?? '<span class="text-muted">Chưa cập nhật</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <i class="fas fa-phone text-primary mr-2"></i> Số điện thoại
                                        </th>
                                        <td><?php echo $account->phone ?? '<span class="text-muted">Chưa cập nhật</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <i class="fas fa-user-tag text-primary mr-2"></i> Vai trò
                                        </th>
                                        <td>
                                            <span class="badge <?php echo ($account->role === 'admin') ? 'bg-danger' : 'bg-primary'; ?> text-white px-3 py-2 rounded-pill">
                                                <i class="fas <?php echo ($account->role === 'admin') ? 'fa-user-shield' : 'fa-user'; ?> mr-1"></i>
                                                <?php echo ($account->role === 'admin') ? 'Admin' : 'Người dùng'; ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?php echo BASE_URL; ?>product" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Quay lại
                            </a>
                            <a href="<?php echo BASE_URL; ?>account/profile?edit=1" class="btn btn-primary">
                                <i class="fas fa-user-edit mr-2"></i> Chỉnh sửa thông tin
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Hiển thị tên file khi chọn ảnh đại diện
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<?php
require_once 'app/views/shares/footer.php';
?>
