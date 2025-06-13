<?php include 'app/views/shares/header.php'; ?>

<?php
// Lấy thông tin đơn hàng từ session nếu có
$order = isset($_SESSION['last_order']) ? $_SESSION['last_order'] : null;

// Nếu không có thông tin đơn hàng, chuyển hướng về trang sản phẩm
if (!$order) {
    header('Location: <?php echo BASE_URL; ?>Product');
    exit;
}

// Chuyển đổi phương thức thanh toán sang dạng hiển thị
$payment_methods = [
    'cod' => 'Thanh toán khi nhận hàng',
    'bank' => 'Chuyển khoản ngân hàng',
    'momo' => 'Ví điện tử MoMo'
];

$payment_method_text = isset($payment_methods[$order['payment_method']]) ? $payment_methods[$order['payment_method']] : $order['payment_method'];
?>

<div class="order-confirmation-container">
    <div class="success-message">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="success-title">Cảm ơn bạn đã đặt hàng!</h1>
        <p class="success-text">Đơn hàng của bạn đã được xử lý thành công.</p>
    </div>
    
    <div class="order-info-card">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-check mr-2"></i> Chi tiết đơn hàng #<?php echo $order['id']; ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Thông tin khách hàng -->
                    <div class="col-md-6">
                        <div class="customer-info">
                            <h6><i class="fas fa-user mr-2"></i> Thông tin khách hàng</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Họ tên:</th>
                                    <td><?php echo htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?php echo htmlspecialchars($order['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại:</th>
                                    <td><?php echo htmlspecialchars($order['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ:</th>
                                    <td><?php echo htmlspecialchars($order['address'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Thông tin thanh toán -->
                    <div class="col-md-6">
                        <div class="payment-info">
                            <h6><i class="fas fa-credit-card mr-2"></i> Thông tin thanh toán</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Mã đơn hàng:</th>
                                    <td>#<?php echo $order['id']; ?></td>
                                </tr>
                                <tr>
                                    <th>Hình thức thanh toán:</th>
                                    <td><?php echo htmlspecialchars($payment_method_text, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền:</th>
                                    <td class="total-price"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                                </tr>
                                <?php if (!empty($order['note'])): ?>
                                <tr>
                                    <th>Ghi chú:</th>
                                    <td><?php echo htmlspecialchars($order['note'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Chi tiết sản phẩm -->
                <div class="order-items mt-4">
                    <h6><i class="fas fa-shopping-bag mr-2"></i> Sản phẩm đã đặt</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order['items'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-right"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Tổng cộng:</th>
                                    <th class="text-right"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Hướng dẫn -->
                <div class="order-instructions mt-4">
                    <?php if ($order['payment_method'] == 'cod'): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i> Đơn hàng của bạn sẽ được giao trong vòng 3-5 ngày làm việc. Vui lòng chuẩn bị số tiền <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND để thanh toán khi nhận hàng.
                    </div>
                    <?php elseif ($order['payment_method'] == 'bank'): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i> Vui lòng chuyển khoản với nội dung <strong>"#<?php echo $order['id']; ?> <?php echo htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8'); ?>"</strong> đến tài khoản ngân hàng sau:
                        <ul class="mb-0 mt-2">
                            <li>Ngân hàng: Vietcombank</li>
                            <li>Số tài khoản: 123456789</li>
                            <li>Chủ tài khoản: Công ty ABC</li>
                        </ul>
                    </div>
                    <?php elseif ($order['payment_method'] == 'momo'): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i> Vui lòng thanh toán qua MoMo với nội dung <strong>"#<?php echo $order['id']; ?> <?php echo htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8'); ?>"</strong> đến số điện thoại: 0987654321
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="next-actions text-center mt-4">
        <p>Chúng tôi đã gửi thông tin đơn hàng đến <?php echo htmlspecialchars($order['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="<?php echo BASE_URL; ?>Product" class="btn btn-primary btn-lg">
            <i class="fas fa-store mr-2"></i> Tiếp tục mua sắm
        </a>
    </div>
</div>

<style>
    .order-confirmation-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .success-message {
        text-align: center;
        margin-bottom: 2rem;
        padding: 2rem 0;
    }
    
    .success-icon {
        font-size: 5rem;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .success-title {
        color: #333;
        margin-bottom: 1rem;
    }
    
    .success-text {
        color: #666;
        font-size: 1.1rem;
    }
    
    .order-info-card {
        margin-bottom: 2rem;
    }
    
    .customer-info, .payment-info {
        margin-bottom: 1.5rem;
    }
    
    .customer-info h6, .payment-info h6, .order-items h6 {
        color: var(--primary-color);
        border-bottom: 1px solid #eee;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .customer-info th, .payment-info th {
        width: 40%;
        font-weight: 600;
        color: #555;
    }
    
    .total-price {
        font-weight: 700;
        color: var(--accent-color);
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,123,255,0.05);
    }
    
    .order-instructions {
        margin-top: 1rem;
    }
    
    .next-actions {
        margin: 2rem 0;
    }
</style>

<?php 
// Xóa thông tin đơn hàng khỏi session sau khi đã hiển thị
// Chú ý: Đoạn code này có thể được để lại hoặc xóa tùy thuộc vào yêu cầu
// unset($_SESSION['last_order']);
?>

<?php include 'app/views/shares/footer.php'; ?>