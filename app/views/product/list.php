<?php include 'app/views/shares/header.php'; ?>
<div class="product-list-container">
    <h1 class="page-title">Danh sách sản phẩm</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <?php if (SessionHelper::isAdmin()): ?>
            <a href="/webbanhang/Product/add" class="btn btn-success"><i class="fas fa-plus-circle mr-1"></i> Thêm sản phẩm mới</a>
        <?php endif; ?>
        <!-- Có thể thêm tính năng tìm kiếm ở đây sau này -->
    </div>
    
    <div class="row">
        <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Chưa có sản phẩm nào. Hãy thêm sản phẩm mới!
                </div>
            </div>
        <?php endif; ?>
        
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100">
                    <div class="product-image-container">
                        <?php if ($product->image): ?>
                            <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top product-image" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="product-title">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        
                        <div class="category-badge">
                            <i class="fas fa-tag mr-1"></i> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        
                        <p class="card-text product-description">
                            <?php 
                            $desc = htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                            echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc; 
                            ?>
                        </p>
                        
                        <div class="product-price">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-cart-plus mr-1"></i> Thêm vào giỏ
                            </a>
                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye mr-1"></i> Chi tiết
                            </a>
                        </div>
                        
                        <div class="admin-actions mt-2">
                            <?php if (SessionHelper::isAdmin()): ?>
                                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                                class="btn btn-danger btn-sm" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .product-image-container {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
        font-size: 3rem;
    }
    
    .product-title {
        color: var(--text-color);
        text-decoration: none;
        font-weight: 600;
    }
    
    .product-title:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .category-badge {
        display: inline-block;
        background-color: #f0f0f0;
        color: #666;
        padding: 0.2rem 0.6rem;
        border-radius: 30px;
        font-size: 0.8rem;
        margin-bottom: 0.8rem;
    }
    
    .product-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        min-height: 50px;
    }
    
    .product-price {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--accent-color);
        margin-top: auto;
    }
    
    .admin-actions {
        display: flex;
        justify-content: space-between;
    }
    
    .btn-group .btn {
        flex: 1;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>