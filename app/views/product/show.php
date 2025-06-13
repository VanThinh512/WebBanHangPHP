<?php include 'app/views/shares/header.php'; ?>

<div class="product-detail-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light py-2 px-3">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>Product"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-5 mb-4">
            <div class="product-image-gallery">
                <?php if ($product->image): ?>
                    <img src="<?php echo BASE_URL; ?><?php echo $product->image; ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid main-product-image">
                <?php else: ?>
                    <div class="no-image-placeholder">
                        <i class="fas fa-image"></i>
                        <p>Không có hình ảnh</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-7">
            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h1>
                
                <div class="product-meta">
                    <span class="product-category"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="product-id"><i class="fas fa-barcode"></i> Mã SP: <?php echo $product->id; ?></span>
                </div>
                
                <div class="product-price-container">
                    <span class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</span>
                </div>
                
                <div class="product-description">
                    <h5><i class="fas fa-info-circle"></i> Mô tả sản phẩm</h5>
                    <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                
                <div class="product-actions mt-4">
                    <a href="<?php echo BASE_URL; ?>Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-lg add-to-cart-btn">
                        <i class="fas fa-cart-plus mr-2"></i> Thêm vào giỏ hàng
                    </a>
                    <a href="<?php echo BASE_URL; ?>Product" class="btn btn-outline-secondary btn-lg ml-2">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại
                    </a>
                </div>
                
                <div class="admin-actions mt-4">
                    <a href="<?php echo BASE_URL; ?>Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Sửa sản phẩm
                    </a>
                    <a href="<?php echo BASE_URL; ?>Product/delete/<?php echo $product->id; ?>" class="btn btn-danger" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                        <i class="fas fa-trash-alt mr-1"></i> Xóa sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-detail-container {
        padding: 20px 0;
    }
    
    .product-image-gallery {
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        position: relative;
    }
    
    .main-product-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s;
    }
    
    .product-image-gallery:hover .main-product-image {
        transform: scale(1.03);
    }
    
    .no-image-placeholder {
        width: 100%;
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #ccc;
        font-size: 2.5rem;
        background-color: #f9f9f9;
    }
    
    .no-image-placeholder p {
        font-size: 1rem;
        margin-top: 10px;
        color: #999;
    }
    
    .product-info {
        padding: 0 15px;
    }
    
    .product-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 15px;
    }
    
    .product-meta {
        display: flex;
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: #666;
    }
    
    .product-category, .product-id {
        margin-right: 20px;
        display: inline-flex;
        align-items: center;
    }
    
    .product-category i, .product-id i {
        margin-right: 5px;
        color: #999;
    }
    
    .product-price-container {
        margin-bottom: 25px;
    }
    
    .product-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--accent-color);
        display: block;
    }
    
    .product-description {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    
    .product-description h5 {
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.1rem;
        color: var(--primary-color);
    }
    
    .product-description p {
        color: #555;
        line-height: 1.6;
    }
    
    .add-to-cart-btn {
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .add-to-cart-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Định dạng cho breadcrumb */
    .breadcrumb {
        border-radius: 4px;
        margin-bottom: 25px;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: #666;
        font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .product-title {
            font-size: 1.5rem;
        }
        
        .product-price {
            font-size: 1.5rem;
        }
        
        .product-actions {
            flex-direction: column;
        }
        
        .add-to-cart-btn, .product-actions .btn-outline-secondary {
            width: 100%;
            margin-bottom: 10px;
            margin-left: 0 !important;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>