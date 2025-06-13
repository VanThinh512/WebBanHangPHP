<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Hero Section -->
            <div class="login-hero-section mb-5">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8 mb-4 mb-lg-0">
                                <h1 class="display-4 font-weight-bold mb-3">Đăng nhập</h1>
                                <p class="lead text-muted mb-4">Đăng nhập để truy cập tài khoản và quản lý thông tin cá nhân của bạn.</p>
                                <div class="d-flex">
                                    <a href="<?php echo BASE_URL; ?>account/register" class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-user-plus mr-2"></i> Đăng ký tài khoản mới
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <img src="<?php echo BASE_URL; ?>public/images/login-illustration.svg" alt="Login" class="img-fluid" onerror="this.src='<?php echo BASE_URL; ?>public/images/login.png'; this.onerror='';"> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm border-0 animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0 font-weight-bold text-center">
                                <i class="fas fa-sign-in-alt mr-2 text-primary"></i> Đăng nhập hệ thống
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            
                            <form action="<?php echo BASE_URL; ?>account/checklogin" method="post">
                                <div class="mb-4">
                                    <label for="username" class="form-label font-weight-bold">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập" required autofocus />
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label font-weight-bold">Mật khẩu</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required />
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="remember-me" id="remember-me">
                                        <label class="form-check-label" for="remember-me">
                                            Ghi nhớ đăng nhập
                                        </label>
                                    </div>
                                    <a href="#" class="text-primary">Quên mật khẩu?</a>
                                </div>
                                
                                <button class="btn btn-primary btn-lg btn-block" type="submit">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
                                </button>
                                
                                <div class="text-center mt-4">
                                    <p class="mb-2">Hoặc đăng nhập với</p>
                                    <div class="social-login">
                                        <a href="#" class="btn btn-outline-primary mx-1">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-info mx-1">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger mx-1">
                                            <i class="fab fa-google"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-white text-center py-3">
                            <p class="mb-0">Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>account/register" class="font-weight-bold">Đăng ký ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>