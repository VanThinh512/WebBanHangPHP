<?php include 'app/views/shares/header.php'; ?>

<div class="cart-container">
    <h1 class="page-title">
        <i class="fas fa-shopping-cart mr-2"></i> Giỏ hàng của bạn
    </h1>
    
    <?php if (empty($cart)): ?>
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Giỏ hàng của bạn đang trống</h3>
            <p>Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua sắm.</p>
            <a href="/webbanhang/Product" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-store mr-2"></i> Tiếp tục mua sắm
            </a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover cart-table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width: 100px;">Ảnh</th>
                                <th>Sản phẩm</th>
                                <th class="text-center" style="width: 150px;">Giá</th>
                                <th class="text-center" style="width: 180px;">Số lượng</th>
                                <th class="text-center" style="width: 150px;">Thành tiền</th>
                                <th class="text-center" style="width: 80px;">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $item): ?>
                                <tr>
                                    <!-- Ảnh sản phẩm -->
                                    <td class="text-center">
                                        <?php if ($item['image']): ?>
                                            <img src="/webbanhang/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" class="cart-product-image">
                                        <?php else: ?>
                                            <div class="no-image-placeholder-small">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Tên sản phẩm -->
                                    <td>
                                        <a href="/webbanhang/Product/show/<?php echo $id; ?>" class="product-name">
                                            <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </td>
                                    
                                    <!-- Giá sản phẩm -->
                                    <td class="text-center">
                                        <span class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</span>
                                    </td>
                                    
                                    <!-- Số lượng -->
                                    <td>
                                        <div class="quantity-control">
                                            <a href="/webbanhang/Product/decreaseQuantity/<?php echo $id; ?>" class="quantity-btn decrease">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            
                                            <form action="/webbanhang/Product/updateQuantity" method="POST" class="quantity-form">
                                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" onchange="this.form.submit()">
                                            </form>
                                            
                                            <a href="/webbanhang/Product/increaseQuantity/<?php echo $id; ?>" class="quantity-btn increase">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                    
                                    <!-- Thành tiền -->
                                    <td class="text-center">
                                        <span class="subtotal"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</span>
                                    </td>
                                    
                                    <!-- Xóa -->
                                    <td class="text-center">
                                        <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Tổng tiền:</td>
                                <td class="text-center">
                                    <span class="total-amount"><?php echo number_format($totalAmount, 0, ',', '.'); ?> VND</span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="cart-actions mt-4 d-flex justify-content-between">
            <a href="/webbanhang/Product" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Tiếp tục mua sắm
            </a>
            <a href="/webbanhang/Product/checkout" class="btn btn-primary btn-lg">
                <i class="fas fa-check-circle mr-1"></i> Tiến hành thanh toán
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
    .cart-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .empty-cart {
        text-align: center;
        padding: 3rem 1rem;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin-top: 2rem;
    }
    
    .empty-cart-icon {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    
    .empty-cart h3 {
        color: #555;
        margin-bottom: 1rem;
    }
    
    .empty-cart p {
        color: #777;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .cart-table td {
        vertical-align: middle;
    }
    
    .cart-product-image {
        max-width: 70px;
        max-height: 70px;
        object-fit: cover;
    }
    
    .no-image-placeholder-small {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        color: #ccc;
        font-size: 1.5rem;
        margin: 0 auto;
    }
    
    .product-name {
        color: var(--text-color);
        font-weight: 600;
        text-decoration: none;
        display: block;
    }
    
    .product-name:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .price, .subtotal {
        color: #555;
        font-weight: 600;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .quantity-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background-color: #f0f0f0;
        border-radius: 4px;
        color: #555;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .quantity-btn:hover {
        background-color: var(--primary-color);
        color: white;
        text-decoration: none;
    }
    
    .decrease {
        border-radius: 4px 0 0 4px;
    }
    
    .increase {
        border-radius: 0 4px 4px 0;
    }
    
    .quantity-input {
        width: 50px;
        height: 32px;
        text-align: center;
        border: 1px solid #f0f0f0;
        border-left: none;
        border-right: none;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    
    .quantity-form {
        margin: 0;
    }
    
    .delete-btn {
        color: #dc3545;
        font-size: 1.2rem;
    }
    
    .delete-btn:hover {
        color: #c82333;
    }
    
    .total-amount {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--accent-color);
    }
    
    /* Hide input number arrows */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
