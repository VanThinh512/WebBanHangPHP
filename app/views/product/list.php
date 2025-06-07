<?php include 'app/views/shares/header.php'; ?>

<div class="product-list-container">
    <!-- Hero Section -->
    <div class="hero-section mb-5 animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 font-weight-bold mb-3">Khám phá sản phẩm chất lượng</h1>
                <p class="lead text-muted mb-4">Tìm kiếm những sản phẩm tốt nhất với giá cả phải chăng. Chúng tôi cam kết mang đến trải nghiệm mua sắm tuyệt vời.</p>
                <div class="d-flex">
                    <a href="#product-grid" class="btn btn-primary btn-lg mr-3">
                        <i class="fas fa-shopping-bag mr-2"></i> Mua sắm ngay
                    </a>
                    <?php if (SessionHelper::isAdmin()): ?>
                        <a href="/webbanhang/Product/add" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-plus-circle mr-2"></i> Thêm sản phẩm
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="/WEBBANHANG/uploads/avatars/thinh1_1748938690.jpg" alt="Hero Image" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
    
    <!-- Search and Filter Section -->
    <div class="search-filter-section mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <form action="/webbanhang/Product" method="GET" class="search-form">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-left-0" placeholder="Tìm kiếm sản phẩm..." 
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-lg-end">
                        <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#filterCollapse">
                            <i class="fas fa-filter mr-2"></i> Lọc & Sắp xếp
                        </button>
                    </div>
                </div>
                
                <?php if ($hasFilter): ?>
                <div class="filter-tags mt-3">
                    <div class="d-flex flex-wrap align-items-center">
                        <span class="mr-2 text-muted"><i class="fas fa-tag mr-1"></i> Bộ lọc:</span>
                        
                        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                            <span class="filter-tag">
                                Tìm kiếm: <?php echo htmlspecialchars($_GET['search']); ?>
                                <a href="<?php echo removeQueryParam('search'); ?>" class="filter-tag-remove"><i class="fas fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['category']) && !empty($_GET['category'])): 
                            foreach ($categories as $cat): 
                                if ($cat->id == $_GET['category']): ?>
                                    <span class="filter-tag">
                                        Danh mục: <?php echo htmlspecialchars($cat->name); ?>
                                        <a href="<?php echo removeQueryParam('category'); ?>" class="filter-tag-remove"><i class="fas fa-times"></i></a>
                                    </span>
                                <?php break; endif;
                            endforeach;
                        endif; ?>
                        
                        <?php if (isset($_GET['min_price']) && !empty($_GET['min_price'])): ?>
                            <span class="filter-tag">
                                Giá từ: <?php echo number_format($_GET['min_price'], 0, ',', '.'); ?> VND
                                <a href="<?php echo removeQueryParam('min_price'); ?>" class="filter-tag-remove"><i class="fas fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['max_price']) && !empty($_GET['max_price'])): ?>
                            <span class="filter-tag">
                                Giá đến: <?php echo number_format($_GET['max_price'], 0, ',', '.'); ?> VND
                                <a href="<?php echo removeQueryParam('max_price'); ?>" class="filter-tag-remove"><i class="fas fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ((isset($_GET['sort_by']) && $_GET['sort_by'] != 'newest') || (isset($_GET['sort_order']) && $_GET['sort_order'] != 'desc')): ?>
                            <span class="filter-tag">
                                Sắp xếp: 
                                <?php 
                                $sortByText = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'newest';
                                $sortOrderText = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'desc';
                                
                                if ($sortByText == 'newest') echo 'Mới nhất';
                                else if ($sortByText == 'name') echo 'Tên';
                                else if ($sortByText == 'price') echo 'Giá';
                                
                                echo ' - ';
                                
                                if ($sortOrderText == 'desc') echo 'Giảm dần';
                                else if ($sortOrderText == 'asc') echo 'Tăng dần';
                                ?>
                                <a href="<?php echo removeQueryParam(['sort_by', 'sort_order']); ?>" class="filter-tag-remove"><i class="fas fa-times"></i></a>
                            </span>
                        <?php endif; ?>
                        
                        <a href="/webbanhang/Product" class="btn btn-sm btn-outline-secondary ml-auto">
                            <i class="fas fa-times mr-1"></i> Xóa tất cả
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Advanced Filter Collapse -->
                <div class="collapse <?php echo $hasFilter ? 'show' : ''; ?>" id="filterCollapse">
                    <hr>
                    <form action="/webbanhang/Product" method="GET" class="filter-form">
                        <!-- Giữ lại giá trị tìm kiếm nếu có -->
                        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                        <?php endif; ?>
                        
                        <div class="row">
                            <!-- Lọc theo danh mục -->
                            <div class="col-md-3 mb-3">
                                <label for="category" class="font-weight-bold">Danh mục sản phẩm</label>
                                <select name="category" id="category" class="form-control custom-select">
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
                                <label for="min_price" class="font-weight-bold">Giá từ</label>
                                <div class="input-group">
                                    <input type="number" name="min_price" id="min_price" class="form-control" placeholder="VND" 
                                           value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">VND</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="max_price" class="font-weight-bold">Giá đến</label>
                                <div class="input-group">
                                    <input type="number" name="max_price" id="max_price" class="form-control" placeholder="VND" 
                                           value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">VND</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sắp xếp -->
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Sắp xếp theo</label>
                                <div class="d-flex">
                                    <select name="sort_by" class="form-control custom-select mr-2">
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
                                    <select name="sort_order" class="form-control custom-select">
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
                        
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-filter mr-2"></i> Áp dụng bộ lọc
                            </button>
                            <a href="/webbanhang/Product" class="btn btn-outline-secondary ml-2">
                                <i class="fas fa-times mr-2"></i> Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Grid -->
    <div id="product-grid" class="mb-5">
        <?php if (empty($products)): ?>
            <div class="alert alert-info shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x mr-3 text-primary"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Không tìm thấy sản phẩm</h5>
                        <p class="mb-0">Hiện chưa có sản phẩm nào trong hệ thống hoặc không có sản phẩm phù hợp với bộ lọc của bạn.</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h2 class="section-title mb-4">Sản phẩm của chúng tôi</h2>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            <div class="product-image-container">
                                <?php if ($product->image): ?>
                                    <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top product-image" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="product-overlay">
                                    <div class="product-actions">
                                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="btn btn-light btn-sm rounded-circle" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-light btn-sm rounded-circle" title="Thêm vào giỏ">
                                            <i class="fas fa-cart-plus"></i>
                                        </a>
                                        <?php if (SessionHelper::isAdmin()): ?>
                                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-light btn-sm rounded-circle" title="Sửa sản phẩm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="category-badge">
                                    <i class="fas fa-tag mr-1"></i> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                
                                <h5 class="card-title">
                                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="product-title">
                                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h5>
                                
                                <p class="card-text product-description">
                                    <?php 
                                    $desc = htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                                    echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc; 
                                    ?>
                                </p>
                            </div>
                            
                            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                <div class="product-price">
                                    <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                                </div>
                                
                                <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-cart-plus mr-1"></i> Thêm vào giỏ
                                </a>
                            </div>
                            
                            <?php if (SessionHelper::isAdmin()): ?>
                                <div class="admin-actions p-2 bg-light border-top">
                                    <div class="d-flex justify-content-between">
                                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($pagination['totalPages'] > 1): ?>
    <div class="pagination-container">
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
                        <i class="fas fa-chevron-left"></i>
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
                        <i class="fas fa-chevron-right"></i>
                        <span class="sr-only">Tiếp</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <div class="text-center mt-3 text-muted">
            <small>Hiển thị <?php echo count($products); ?> trên tổng số <?php echo $pagination['totalProducts']; ?> sản phẩm</small>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    /* Hero Section */
    .hero-section {
        padding: 3rem 0;
        background: linear-gradient(135deg, rgba(78, 115, 223, 0.05), rgba(246, 84, 106, 0.05));
        border-radius: var(--border-radius);
        margin-bottom: 3rem;
    }
    
    /* Section Title */
    .section-title {
        position: relative;
        font-weight: 700;
        margin-bottom: 2rem;
        padding-bottom: 0.8rem;
        color: var(--text-color);
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        border-radius: 3px;
    }
    
    /* Filter Tags */
    .filter-tags {
        margin-top: 1rem;
    }
    
    .filter-tag {
        display: inline-flex;
        align-items: center;
        background-color: rgba(78, 115, 223, 0.1);
        color: var(--primary-color);
        padding: 0.3rem 0.8rem;
        border-radius: 30px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }
    
    .filter-tag-remove {
        margin-left: 0.5rem;
        color: var(--primary-color);
        opacity: 0.7;
        transition: all 0.2s ease;
    }
    
    .filter-tag-remove:hover {
        opacity: 1;
        color: var(--accent-color);
    }
    
    /* Product Card */
    .product-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .product-image-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.1);
    }
    
    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .product-overlay {
        opacity: 1;
    }
    
    .product-actions {
        display: flex;
        gap: 10px;
    }
    
    .product-actions .btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: var(--primary-color);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .product-actions .btn {
        transform: translateY(0);
        opacity: 1;
    }
    
    .product-actions .btn:hover {
        background: var(--primary-color);
        color: white;
    }
    
    .product-actions .btn:nth-child(1) {
        transition-delay: 0.1s;
    }
    
    .product-actions .btn:nth-child(2) {
        transition-delay: 0.2s;
    }
    
    .product-actions .btn:nth-child(3) {
        transition-delay: 0.3s;
    }
    
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fc;
        color: #d1d3e2;
        font-size: 3rem;
    }
    
    .category-badge {
        display: inline-block;
        background-color: rgba(78, 115, 223, 0.1);
        color: var(--primary-color);
        padding: 0.2rem 0.6rem;
        border-radius: 30px;
        font-size: 0.75rem;
        margin-bottom: 0.8rem;
        font-weight: 500;
    }
    
    .product-title {
        color: var(--text-color);
        text-decoration: none;
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .product-title:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .product-description {
        color: var(--dark-gray);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        min-height: 50px;
    }
    
    .product-price {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--accent-color);
    }
    
    /* Pagination */
    .pagination-container {
        margin-top: 3rem;
    }
    
    .pagination .page-link {
        border-radius: 50%;
        margin: 0 3px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        border: none;
        background-color: rgba(78, 115, 223, 0.1);
        transition: all 0.3s ease;
    }
    
    .pagination .page-link:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
    }
    
    /* Helper function for removing query parameters */
    <?php
    function removeQueryParam($param) {
        $params = $_GET;
        if (is_array($param)) {
            foreach ($param as $p) {
                unset($params[$p]);
            }
        } else {
            unset($params[$param]);
        }
        return '?' . http_build_query($params);
    }
    ?>
</style>

<?php include 'app/views/shares/footer.php'; ?>