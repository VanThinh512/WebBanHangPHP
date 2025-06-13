<?php include 'app/views/shares/header.php'; ?>

<div class="category-form-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light py-2 px-3">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>Category"><i class="fas fa-list"></i> Danh mục</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm danh mục mới</li>
        </ol>
    </nav>

    <h1 class="page-title">Thêm danh mục mới</h1>
    
    <?php if(isset($errors) && is_array($errors) && count($errors) > 0): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>Category/save" method="POST">
                <div class="form-group">
                    <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
                           required>
                    <small class="form-text text-muted">Nhập tên danh mục sản phẩm</small>
                </div>
                
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                    <small class="form-text text-muted">Mô tả ngắn gọn về danh mục sản phẩm (tùy chọn)</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Lưu danh mục
                    </button>
                    <a href="<?php echo BASE_URL; ?>Category" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .category-form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-actions {
        margin-top: 1.5rem;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
