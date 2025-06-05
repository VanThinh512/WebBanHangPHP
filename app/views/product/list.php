<?php include 'app/views/shares/header.php'; ?>
<div class="product-list-container">
    <h1 class="page-title">Danh sách sản phẩm</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex">
            <?php if (SessionHelper::isAdmin()): ?>
                <a href="/webbanhang/Product/add" class="btn btn-success mr-2"><i class="fas fa-plus-circle mr-1"></i> Thêm sản phẩm mới</a>
            <?php endif; ?>
        </div>
        
        <form action="/webbanhang/Product" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <?php 
    // Hiển thị thông báo nếu có tìm kiếm hoặc lọc đang áp dụng
    $hasFilter = isset($_GET['search']) || isset($_GET['category']) || isset($_GET['min_price']) || isset($_GET['max_price']) ||
              (isset($_GET['sort_by']) && $_GET['sort_by'] != 'newest') || (isset($_GET['sort_order']) && $_GET['sort_order'] != 'desc');
    
    if ($hasFilter): 
    ?>
    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle mr-2"></i>
        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
            Tìm kiếm: <strong><?php echo htmlspecialchars($_GET['search']); ?></strong>
        <?php endif; ?>
        
        <?php if (isset($_GET['category']) && !empty($_GET['category'])): 
            foreach ($categories as $cat): 
                if ($cat->id == $_GET['category']): ?>
                    | Danh mục: <strong><?php echo htmlspecialchars($cat->name); ?></strong>
                <?php break; endif;
            endforeach;
        endif; ?>
        
        <?php if (isset($_GET['min_price']) || isset($_GET['max_price'])): ?>
            | Giá: <strong>
            <?php 
            if (isset($_GET['min_price']) && !empty($_GET['min_price'])) {
                echo 'Từ ' . number_format($_GET['min_price'], 0, ',', '.') . ' VND';
            }
            if (isset($_GET['max_price']) && !empty($_GET['max_price'])) {
                echo (isset($_GET['min_price']) && !empty($_GET['min_price'])) ? ' đến ' : 'Dưới ';
                echo number_format($_GET['max_price'], 0, ',', '.') . ' VND';
            }
            ?>
            </strong>
        <?php endif; ?>
        
        <a href="/webbanhang/Product" class="ml-2 btn btn-sm btn-outline-secondary">Xóa bộ lọc</a>
    </div>
    <?php endif; ?>
    
    <!-- Filter and Sort Options -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <a class="btn btn-link text-dark" data-toggle="collapse" href="#filterCollapse" role="button">
                <i class="fas fa-filter mr-1"></i> Lọc & Sắp xếp
            </a>
        </div>
        <div class="collapse <?php echo $hasFilter ? 'show' : ''; ?>" id="filterCollapse">
            <div class="card-body">
                <form action="/webbanhang/Product" method="GET" class="filter-form">
                    <!-- Giữ lại giá trị tìm kiếm nếu có -->
                    <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <!-- Lọc theo danh mục -->
                        <div class="col-md-3 mb-3">
                            <label for="category">Danh mục sản phẩm</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">-- Tất cả danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $category->id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Lọc theo khoảng giá -->
                        <div class="col-md-3 mb-3">
                            <label for="min_price">Giá từ</label>
                            <input type="number" name="min_price" id="min_price" class="form-control" placeholder="VND" 
                                   value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="max_price">Giá đến</label>
                            <input type="number" name="max_price" id="max_price" class="form-control" placeholder="VND" 
                                   value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                        </div>
                        
                        <!-- Sắp xếp -->
                        <div class="col-md-3 mb-3">
                            <label>Sắp xếp theo</label>
                            <div class="d-flex">
                                <select name="sort_by" class="form-control mr-2">
                                    <option value="newest" <?php echo (!isset($_GET['sort_by']) || $_GET['sort_by'] == 'newest') ? 'selected' : ''; ?>>
                                        Mới nhất
                                    </option>
                                    <option value="name" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name') ? 'selected' : ''; ?>>
                                        Tên sản phẩm
                                    </option>
                                    <option value="price" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price') ? 'selected' : ''; ?>>
                                        Giá
                                    </option>
                                </select>
                                <select name="sort_order" class="form-control">
                                    <option value="desc" <?php echo (!isset($_GET['sort_order']) || $_GET['sort_order'] == 'desc') ? 'selected' : ''; ?>>
                                        Giảm dần
                                    </option>
                                    <option value="asc" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc') ? 'selected' : ''; ?>>
                                        Tăng dần
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter mr-1"></i> Áp dụng
                        </button>
                        <a href="/webbanhang/Product" class="btn btn-outline-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Xóa bộ lọc
                        </a>
                    </div>
                </form>
            </div>
        </div>
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
    
    <?php if ($pagination['totalPages'] > 1): ?>
    <!-- Phân trang -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Phân trang">
                <ul class="pagination justify-content-center">
                    <?php 
                    // Nút quay lại trang trước
                    if ($pagination['currentPage'] > 1): 
                        $prevPageUrl = '?page=' . ($pagination['currentPage'] - 1);
                        // Giữ lại các tham số lọc và sắp xếp
                        if (isset($_GET['search'])) $prevPageUrl .= '&search=' . urlencode($_GET['search']);
                        if (isset($_GET['category'])) $prevPageUrl .= '&category=' . $_GET['category'];
                        if (isset($_GET['min_price'])) $prevPageUrl .= '&min_price=' . $_GET['min_price'];
                        if (isset($_GET['max_price'])) $prevPageUrl .= '&max_price=' . $_GET['max_price'];
                        if (isset($_GET['sort_by'])) $prevPageUrl .= '&sort_by=' . $_GET['sort_by'];
                        if (isset($_GET['sort_order'])) $prevPageUrl .= '&sort_order=' . $_GET['sort_order'];
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="/webbanhang/Product<?php echo $prevPageUrl; ?>" aria-label="Trang trước">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Trước</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php 
                    // Hiển thị các số trang
                    $startPage = max(1, $pagination['currentPage'] - 2);
                    $endPage = min($pagination['totalPages'], $pagination['currentPage'] + 2);
                    
                    // Đảm bảo hiển thị ít nhất 5 trang nếu có thể
                    if ($endPage - $startPage + 1 < 5 && $pagination['totalPages'] >= 5) {
                        if ($startPage == 1) {
                            $endPage = min(5, $pagination['totalPages']);
                        } else if ($endPage == $pagination['totalPages']) {
                            $startPage = max(1, $pagination['totalPages'] - 4);
                        }
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++):
                        $pageUrl = '?page=' . $i;
                        // Giữ lại các tham số lọc và sắp xếp
                        if (isset($_GET['search'])) $pageUrl .= '&search=' . urlencode($_GET['search']);
                        if (isset($_GET['category'])) $pageUrl .= '&category=' . $_GET['category'];
                        if (isset($_GET['min_price'])) $pageUrl .= '&min_price=' . $_GET['min_price'];
                        if (isset($_GET['max_price'])) $pageUrl .= '&max_price=' . $_GET['max_price'];
                        if (isset($_GET['sort_by'])) $pageUrl .= '&sort_by=' . $_GET['sort_by'];
                        if (isset($_GET['sort_order'])) $pageUrl .= '&sort_order=' . $_GET['sort_order'];
                    ?>
                    <li class="page-item <?php echo ($i == $pagination['currentPage']) ? 'active' : ''; ?>">
                        <a class="page-link" href="/webbanhang/Product<?php echo $pageUrl; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php 
                    // Nút tiếp trang sau
                    if ($pagination['currentPage'] < $pagination['totalPages']): 
                        $nextPageUrl = '?page=' . ($pagination['currentPage'] + 1);
                        // Giữ lại các tham số lọc và sắp xếp
                        if (isset($_GET['search'])) $nextPageUrl .= '&search=' . urlencode($_GET['search']);
                        if (isset($_GET['category'])) $nextPageUrl .= '&category=' . $_GET['category'];
                        if (isset($_GET['min_price'])) $nextPageUrl .= '&min_price=' . $_GET['min_price'];
                        if (isset($_GET['max_price'])) $nextPageUrl .= '&max_price=' . $_GET['max_price'];
                        if (isset($_GET['sort_by'])) $nextPageUrl .= '&sort_by=' . $_GET['sort_by'];
                        if (isset($_GET['sort_order'])) $nextPageUrl .= '&sort_order=' . $_GET['sort_order'];
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="/webbanhang/Product<?php echo $nextPageUrl; ?>" aria-label="Trang tiếp">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Tiếp</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div class="text-center mt-2 text-muted">
                <small>Hiển thị <?php echo count($products); ?> trên tổng số <?php echo $pagination['totalProducts']; ?> sản phẩm</small>
            </div>
        </div>
    </div>
    <?php endif; ?>
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