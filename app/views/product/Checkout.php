<?php include 'app/views/shares/header.php'; ?>

<?php
// Lấy tổng tiền trong giỏ hàng
$totalAmount = 0;
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
foreach ($cart as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}
?>

<div class="checkout-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light py-2 px-3">
            <li class="breadcrumb-item"><a href="/webbanhang/Product"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/webbanhang/Product/cart"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>

    <h1 class="page-title">
        <i class="fas fa-credit-card mr-2"></i> Thanh toán đơn hàng
    </h1>
    
    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-5 order-md-2 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-shopping-basket mr-2"></i> Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($cart)): ?>
                        <ul class="list-group list-group-flush checkout-items">
                            <?php foreach ($cart as $id => $item): ?>
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="my-0"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                            <small class="text-muted">Số lượng: <?php echo $item['quantity']; ?></small>
                                        </div>
                                        <span class="text-muted"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="font-weight-bold">Tổng tiền</span>
                                <span class="total-price"><?php echo number_format($totalAmount, 0, ',', '.'); ?> VND</span>
                            </li>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Giỏ hàng của bạn đang trống.
                            <a href="/webbanhang/Product" class="alert-link">Tiếp tục mua sắm</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form thanh toán -->
        <div class="col-md-7 order-md-1">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user mr-2"></i> Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/webbanhang/Product/processCheckout" class="checkout-form">
                        <div class="form-group">
                            <label for="name">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <small class="form-text text-muted">Chúng tôi sẽ gửi thông tin đơn hàng vào email của bạn</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Hình thức thanh toán <span class="text-danger">*</span></label>
                            
                            <div class="payment-methods">
                                <div class="custom-control custom-radio payment-method-item">
                                    <input type="radio" id="payment_cod" name="payment_method" value="cod" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="payment_cod">
                                        <i class="fas fa-money-bill-wave payment-icon"></i>
                                        Thanh toán khi nhận hàng (COD)
                                    </label>
                                </div>
                                
                                <div class="custom-control custom-radio payment-method-item">
                                    <input type="radio" id="payment_bank" name="payment_method" value="bank" class="custom-control-input">
                                    <label class="custom-control-label" for="payment_bank">
                                        <i class="fas fa-university payment-icon"></i>
                                        Chuyển khoản ngân hàng
                                    </label>
                                    <div class="payment-details bank-details">
                                        <p>Tên tài khoản: Trần Nguyễn Văn Thịnh</p>
                                        <p>Số tài khoản: 0337247371</p>
                                        <p>Ngân hàng: MB Bank - Ngân Hàng Quân Đội</p>
                                        <p>Nội dung: [Họ tên] - [Mã đơn hàng] thanh toán đơn hàng</p>
                                    </div>
                                </div>
                                
                                <div class="custom-control custom-radio payment-method-item">
                                    <input type="radio" id="payment_momo" name="payment_method" value="momo" class="custom-control-input">
                                    <label class="custom-control-label" for="payment_momo">
                                        <i class="fas fa-wallet payment-icon"></i>
                                        Ví điện tử MoMo
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="note">Ghi chú</label>
                            <textarea id="note" name="note" class="form-control" rows="3" placeholder="Nhập các yêu cầu đặc biệt cho đơn hàng..."></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <a href="/webbanhang/Product/cart" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg ml-2">
                                <i class="fas fa-check-circle mr-1"></i> Hoàn tất đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-container {
        max-width: 1100px;
        margin: 0 auto;
    }
    
    .card {
        margin-bottom: 1.5rem;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .card-header h5 {
        color: var(--primary-color);
    }
    
    .checkout-items .list-group-item {
        border-left: none;
        border-right: none;
    }
    
    .total-price {
        color: var(--accent-color);
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .payment-methods {
        margin-top: 0.5rem;
    }
    
    .payment-method-item {
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 0.25rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }
    
    .payment-method-item:hover {
        background-color: #f9f9f9;
    }
    
    .payment-icon {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }
    
    .payment-details {
        margin-top: 0.75rem;
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        font-size: 0.9rem;
        color: #555;
        display: none;
    }
    
    #payment_bank:checked ~ .bank-details {
        display: block;
    }
    
    .form-actions {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }
</style>

<script>
    // Hiển thị thông tin chi tiết khi chọn hình thức thanh toán ngân hàng
    document.addEventListener('DOMContentLoaded', function() {
        const bankPayment = document.getElementById('payment_bank');
        const bankDetails = document.querySelector('.bank-details');
        
        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (bankPayment.checked) {
                    bankDetails.style.display = 'block';
                } else {
                    bankDetails.style.display = 'none';
                }
            });
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>