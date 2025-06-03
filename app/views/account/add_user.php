<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Thêm người dùng mới</h1>
            <a href="/webbanhang/account/manageUsers" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-user-plus"></i> Thông tin người dùng mới
            </div>
            <div class="card-body">
                <form action="/webbanhang/account/saveUser" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                id="username" name="username" value="<?= $username ?? '' ?>" required>
                            <?php if (isset($errors['username'])): ?>
                                <div class="invalid-feedback"><?= $errors['username'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fullname">Họ tên <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            </div>
                            <input type="text" class="form-control <?= isset($errors['fullname']) ? 'is-invalid' : '' ?>" 
                                id="fullname" name="fullname" value="<?= $fullName ?? '' ?>" required>
                            <?php if (isset($errors['fullname'])): ?>
                                <div class="invalid-feedback"><?= $errors['fullname'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                id="password" name="password" required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmpassword">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control <?= isset($errors['confirmPass']) ? 'is-invalid' : '' ?>" 
                                id="confirmpassword" name="confirmpassword" required>
                            <?php if (isset($errors['confirmPass'])): ?>
                                <div class="invalid-feedback"><?= $errors['confirmPass'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                id="email" name="email" value="<?= $email ?? '' ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                                id="phone" name="phone" value="<?= $phone ?? '' ?>">
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar">Ảnh đại diện</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?= isset($errors['avatar']) ? 'is-invalid' : '' ?>" 
                                    id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif">
                                <label class="custom-file-label" for="avatar">Chọn file ảnh...</label>
                            </div>
                            <?php if (isset($errors['avatar'])): ?>
                                <div class="invalid-feedback d-block"><?= $errors['avatar'] ?></div>
                            <?php endif; ?>
                        </div>
                        <small class="form-text text-muted">Chấp nhận file: JPG, PNG, GIF. Kích thước tối đa: 2MB.</small>
                    </div>

                    <div class="form-group">
                        <label for="role">Vai trò <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                            </div>
                            <select class="form-control" id="role" name="role">
                                <option value="user" <?= (isset($role) && $role == 'user') ? 'selected' : '' ?>>Người dùng</option>
                                <option value="admin" <?= (isset($role) && $role == 'admin') ? 'selected' : '' ?>>Quản trị viên</option>
                            </select>
                        </div>
                    </div>

                    <?php if (isset($errors['account'])): ?>
                        <div class="alert alert-danger">
                            <?= $errors['account'] ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu
                        </button>
                        <a href="/webbanhang/account/manageUsers" class="btn btn-secondary ml-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
