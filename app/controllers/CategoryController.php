<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class CategoryController
{
    private $categoryModel;
    private $db;
    
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    
    /**
     * Hiển thị danh sách danh mục
     */
    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }
    
    /**
     * Hiển thị form thêm danh mục mới
     */
    public function add()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=' . BASE_URL . 'Category');
            return;
        }
        
        include 'app/views/category/add.php';
    }
    
    /**
     * Xử lý lưu danh mục mới
     */
    public function save()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=' . BASE_URL . 'Category');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'category');
            return;
        }
        
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        $result = $this->categoryModel->addCategory($name, $description);
        
        if (is_array($result)) {
            // Có lỗi xảy ra
            $errors = $result;
            include 'app/views/category/add.php';
        } else {
            // Thêm thành công
            header('Location: ' . BASE_URL . 'category');
        }
    }
    
    /**
     * Hiển thị form chỉnh sửa danh mục
     */
    public function edit($id)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=' . BASE_URL . 'Category');
            return;
        }
        
        $category = $this->categoryModel->getCategoryById($id);
        
        if (!$category) {
            echo "Không tìm thấy danh mục.";
            return;
        }
        
        include 'app/views/category/edit.php';
    }
    
    /**
     * Xử lý cập nhật danh mục
     */
    public function update()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=' . BASE_URL . 'Category');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'category');
            return;
        }
        
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (empty($id)) {
            echo "ID danh mục không hợp lệ.";
            return;
        }
        
        $result = $this->categoryModel->updateCategory($id, $name, $description);
        
        if (is_array($result)) {
            // Có lỗi xảy ra
            $errors = $result;
            $category = (object) [
                'id' => $id,
                'name' => $name,
                'description' => $description
            ];
            include 'app/views/category/edit.php';
        } else {
            // Cập nhật thành công
            header('Location: ' . BASE_URL . 'Category');
        }
    }
    
    /**
     * Xử lý xóa danh mục
     */
    public function delete($id)
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            echo '<div class="alert alert-danger">Bạn không có quyền thực hiện chức năng này!</div>';
            header('Refresh: 3; URL=' . BASE_URL . 'Category');
            return;
        }
        
        $result = $this->categoryModel->deleteCategory($id);
        
        if ($result === true) {
            // Xóa thành công
            header('Location: ' . BASE_URL . 'Category');
        } else {
            // Xóa thất bại hoặc có lỗi
            echo $result; // Hiển thị thông báo lỗi
        }
    }
    
    /**
     * Hiển thị chi tiết danh mục
     */
    public function show($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        
        if (!$category) {
            echo "Không tìm thấy danh mục.";
            return;
        }
        
        include 'app/views/category/show.php';
    }
}
?>