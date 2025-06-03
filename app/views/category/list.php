<?php include 'app/views/shares/header.php'; ?>

<div class="category-list-container">
    <h1 class="page-title">Quản lý danh mục sản phẩm</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php if (SessionHelper::isAdmin()): ?>
            <a href="/webbanhang/Category/add" class="btn btn-success">
                <i class="fas fa-plus-circle mr-1"></i> Thêm danh mục mới
            </a>
        <?php endif; ?>
    </div>
    
    <?php if (empty($categories)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i> Chưa có danh mục nào. Hãy thêm danh mục mới!
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4">ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td class="pl-4"><?php echo $category->id; ?></td>
                                    <td>
                                        <a href="/webbanhang/Category/show/<?php echo $category->id; ?>" class="category-name">
                                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php 
                                        $desc = htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8');
                                        echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc; 
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <?php if (SessionHelper::isAdmin()): ?>
                                            <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-warning mr-1">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Các sản phẩm thuộc danh mục này sẽ không bị xóa.');">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .category-name {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }
    
    .category-name:hover {
        text-decoration: none;
        color: var(--secondary-color);
    }
    
    .table th {
        font-weight: 600;
        color: #555;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
