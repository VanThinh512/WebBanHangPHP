</div> <!-- End of main container -->

<footer class="footer mt-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-uppercase mb-4">Shop<span style="color: var(--accent-color);">Mart</span></h5>
                <p class="text-muted">Cung cấp các sản phẩm chất lượng cao với giá cả hợp lý. Chúng tôi cam kết mang đến trải nghiệm mua sắm tốt nhất cho khách hàng.</p>
                <div class="social-icons mt-4">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h6 class="text-uppercase mb-4">Danh mục</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>Product" class="footer-link">Tất cả sản phẩm</a></li>
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>Category" class="footer-link">Danh mục</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Sản phẩm mới</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Khuyến mãi</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h6 class="text-uppercase mb-4">Tài khoản</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>account/login" class="footer-link">Đăng nhập</a></li>
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>account/profile" class="footer-link">Tài khoản của tôi</a></li>
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>Product/cart" class="footer-link">Giỏ hàng</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Lịch sử đơn hàng</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h6 class="text-uppercase mb-4">Liên hệ</h6>
                <p class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> 123 Đường ABC, Quận XYZ, TP. HCM</p>
                <p class="mb-2"><i class="fas fa-phone-alt mr-2"></i> (028) 1234 5678</p>
                <p class="mb-2"><i class="fas fa-envelope mr-2"></i> info@shopmart.com</p>
                <form class="mt-4">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email của bạn" aria-label="Email của bạn">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">Đăng ký</button>
                        </div>
                    </div>
                    <small class="form-text text-muted">Đăng ký nhận thông tin khuyến mãi mới nhất.</small>
                </form>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left">
                <p class="mb-0 text-muted">© 2023 ShopMart. Tất cả quyền được bảo lưu.</p>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <img src="https://via.placeholder.com/50x30" alt="Payment Method" class="payment-icon">
                <img src="https://via.placeholder.com/50x30" alt="Payment Method" class="payment-icon">
                <img src="https://via.placeholder.com/50x30" alt="Payment Method" class="payment-icon">
                <img src="https://via.placeholder.com/50x30" alt="Payment Method" class="payment-icon">
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #f8f9fc;
        border-top: 1px solid rgba(0,0,0,0.05);
        color: var(--text-color);
    }
    
    .footer h5, .footer h6 {
        font-weight: 700;
        position: relative;
        padding-bottom: 0.8rem;
        margin-bottom: 1.2rem;
    }
    
    .footer h5::after, .footer h6::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
    }
    
    .footer-link {
        color: var(--dark-gray);
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .footer-link:hover {
        color: var(--primary-color);
        text-decoration: none;
        transform: translateX(5px);
    }
    
    .social-icons {
        display: flex;
        gap: 10px;
    }
    
    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(78, 115, 223, 0.1);
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
    }
    
    .payment-icon {
        margin-left: 5px;
        transition: all 0.3s ease;
    }
    
    .payment-icon:hover {
        transform: translateY(-2px);
    }
    
    hr {
        border-color: rgba(0,0,0,0.05);
    }
</style>

<!-- Back to top button -->
<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button">
    <i class="fas fa-arrow-up"></i>
</a>

<style>
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        padding: 0;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        z-index: 1000;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    
    $('#back-to-top').click(function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    
    // Add animation to elements when they come into view
    $(document).ready(function() {
        // Add animation classes to elements
        $('.product-card').addClass('animate__animated animate__fadeIn');
        $('.page-title').addClass('animate__animated animate__fadeInDown');
        
        // Add active class to current nav item
        $('.nav-link').each(function() {
            if (window.location.href.indexOf($(this).attr('href')) > -1) {
                $(this).addClass('active');
            }
        });
    });
</script>
</body>
</html>