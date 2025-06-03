<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    /**
     * Lấy tất cả danh mục
     */
    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Lấy thông tin danh mục theo ID
     */
    public function getCategoryById($id)
    {
        $query = "SELECT id, name, description FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Thêm danh mục mới
     */
    public function addCategory($name, $description)
    {
        // Kiểm tra thông tin đầu vào
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống';
        }
        
        if (count($errors) > 0) {
            return $errors;
        }
        
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        // Bind dữ liệu
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    /**
     * Cập nhật danh mục
     */
    public function updateCategory($id, $name, $description)
    {
        // Kiểm tra thông tin đầu vào
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống';
        }
        
        if (count($errors) > 0) {
            return $errors;
        }
        
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $id = htmlspecialchars(strip_tags($id));
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        // Bind dữ liệu
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    /**
     * Xóa danh mục
     */
    public function deleteCategory($id)
    {
        // Kiểm tra xem danh mục có sản phẩm không
        $query = "SELECT COUNT(*) as count FROM product WHERE category_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row['count'] > 0) {
            return "Không thể xóa danh mục này vì có " . $row['count'] . " sản phẩm thuộc danh mục này";
        }
        
        // Thực hiện xóa nếu không có sản phẩm
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>