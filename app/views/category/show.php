<?php include 'app/views/shares/header.php'; ?>

<div class="category-detail-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light py-2 px-3">
            <li class="breadcrumb-item"><a href="/webbanhang/Category"><i class="fas fa-list"></i> Danh mục</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h1 class="card-title h4 mb-0">
                <i class="fas fa-tag mr-2"></i> <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
            </h1>
        </div>
        <div class="card-body">
            <div class="category-info">
                <div class="category-id">
                    <strong>ID Danh mục:</strong> <?php echo $category->id; ?>
                </div>
                
                <div class="category-description mt-3">
                    <h5>Mô tả:</h5>
                    <p><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            
            <div class="category-actions mt-4">
                <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="btn btn-warning mr-2">
                    <i class="fas fa-edit mr-1"></i> Sửa danh mục
                </a>
                <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Các sản phẩm thuộc danh mục này sẽ không bị xóa.');">
                    <i class="fas fa-trash-alt mr-1"></i> Xóa danh mục
                </a>
                <a href="/webbanhang/Category" class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
    
    <!-- Phần hiển thị sản phẩm thuộc danh mục này -->
    <div class="related-products mt-4">
        <h4 class="mb-3">Sản phẩm thuộc danh mục này</h4>
        <a href="/webbanhang/Product?category=<?php echo $category->id; ?>" class="btn btn-primary mb-3">
            <i class="fas fa-shopping-bag mr-1"></i> Xem tất cả sản phẩm thuộc danh mục này
        </a>
    </div>
</div>

<style>
    .category-detail-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .card-title {
        color: var(--primary-color);
    }
    
    .category-description p {
        color: #555;
        line-height: 1.6;
    }
    
    .category-actions {
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
