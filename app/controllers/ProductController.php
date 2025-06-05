<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once 'app/helpers/SessionHelper.php';
class ProductController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    // Kiểm tra quyền Admin
    private function isAdmin() {
        return SessionHelper::isAdmin();
    }
    // Hiển thị danh sách sản phẩm (mở cho tất cả)
    public function index()
    {
        // Lấy tham số tìm kiếm từ URL nếu có
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;
        
        // Lấy tham số lọc và sắp xếp từ URL
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $minPrice = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? (float)$_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? (float)$_GET['max_price'] : null;
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'newest';
        $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'desc';
        
        // Cấu hình phân trang
        $itemsPerPage = 8; // Số sản phẩm trên một trang
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        
        // Tính toán offset cho truy vấn
        $offset = ($currentPage - 1) * $itemsPerPage;
        
        // Kiểm tra giá trị hợp lệ cho sortBy
        $validSortFields = ['name', 'price', 'newest'];
        if (!in_array($sortBy, $validSortFields)) {
            $sortBy = 'newest';
        }
        
        // Kiểm tra giá trị hợp lệ cho sortOrder
        $validSortOrders = ['asc', 'desc'];
        if (!in_array($sortOrder, $validSortOrders)) {
            $sortOrder = 'desc';
        }
        
        // Lấy danh sách danh mục để hiển thị trong form lọc
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        
        // Lấy tổng số sản phẩm để tính số trang
        $totalProducts = $this->productModel->getTotalProducts($search, $categoryId, $minPrice, $maxPrice);
        $totalPages = ceil($totalProducts / $itemsPerPage);
        
        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        if ($currentPage > $totalPages && $totalPages > 0) {
            $currentPage = $totalPages;
            $offset = ($currentPage - 1) * $itemsPerPage;
        }
        
        // Lấy danh sách sản phẩm với các tùy chọn lọc, sắp xếp và phân trang
        $products = $this->productModel->getProducts(
            $search, 
            $categoryId, 
            $minPrice, 
            $maxPrice, 
            $sortBy, 
            $sortOrder,
            $itemsPerPage,
            $offset
        );
        
        // Truyền dữ liệu phân trang cho view
        $pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
            'totalProducts' => $totalProducts
        ];
        
        include 'app/views/product/list.php';
    }
    // Xem chi tiết sản phẩm (mở cho tất cả)
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    // Thêm sản phẩm (chỉ Admin)
    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }
    // Lưu sản phẩm mới (chỉ Admin)
    public function save()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }
    // Sửa sản phẩm (chỉ Admin)
    public function edit($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    // Cập nhật sản phẩm (chỉ Admin)
    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }
    // Xóa sản phẩm (chỉ Admin)
    public function delete($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }
    private function uploadImage($file)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $target_dir = "uploads/";
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !="jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
            ];
        }
        header('Location: /webbanhang/Product/cart');
    }
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
        // Tính tổng giá trị giỏ hàng
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        include 'app/views/product/cart.php';
    }
    
    /**
     * Tăng số lượng sản phẩm trong giỏ hàng
     */
    public function increaseQuantity($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        }
        
        header('Location: /webbanhang/Product/cart');
    }
    
    /**
     * Giảm số lượng sản phẩm trong giỏ hàng
     */
    public function decreaseQuantity($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            if ($_SESSION['cart'][$id]['quantity'] > 1) {
                $_SESSION['cart'][$id]['quantity']--;
            } else {
                $this->removeFromCart($id);
                return;
            }
        }
        
        header('Location: /webbanhang/Product/cart');
    }
    
    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function updateQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $id = $_POST['product_id'];
            $quantity = intval($_POST['quantity']);
            
            if (isset($_SESSION['cart'][$id])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$id]['quantity'] = $quantity;
                } else {
                    $this->removeFromCart($id);
                    return;
                }
            }
        }
        
        header('Location: /webbanhang/Product/cart');
    }
    
    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        
        header('Location: /webbanhang/Product/cart');
    }
    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy thông tin đơn hàng từ form
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $payment_method = $_POST['payment_method'];
            $note = isset($_POST['note']) ? $_POST['note'] : '';
            
            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<div class='alert alert-danger'>Giỏ hàng trống.</div>";
                return;
            }
            
            // Tính tổng tiền đơn hàng
            $total_amount = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total_amount += $item['price'] * $item['quantity'];
            }
            
            // Bắt đầu giao dịch
            $this->db->beginTransaction();
            
            try {
                // Kiểm tra xem bảng orders đã có các trường mới chưa (email, payment_method, note, total_amount)
                // Nếu chưa, cần chạy câu lệnh SQL để thêm các trường này vào bảng
                
                // Lưu thông tin đơn hàng vào bảng orders với các trường mới
                $query = "INSERT INTO orders (name, email, phone, address, payment_method, note, total_amount, order_date) 
                          VALUES (:name, :email, :phone, :address, :payment_method, :note, :total_amount, NOW())";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':payment_method', $payment_method);
                $stmt->bindParam(':note', $note);
                $stmt->bindParam(':total_amount', $total_amount);
                $stmt->execute();
                
                $order_id = $this->db->lastInsertId();
                
                // Lưu thông tin chi tiết đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                
                foreach ($cart as $product_id => $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) 
                              VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";
                    
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->bindParam(':subtotal', $subtotal);
                    $stmt->execute();
                }
                
                // Lưu thông tin đơn hàng vào session để hiển thị trên trang xác nhận
                $_SESSION['last_order'] = [
                    'id' => $order_id,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'payment_method' => $payment_method,
                    'note' => $note,
                    'total_amount' => $total_amount,
                    'items' => $cart
                ];
                
                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);
                
                // Commit giao dịch
                $this->db->commit();
                
                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /webbanhang/Product/orderConfirmation');
                exit;
                
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                
                echo "<div class='alert alert-danger'><strong>Lỗi:</strong> Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage() . "</div>";
            }
        }
    }
    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

}
?>

