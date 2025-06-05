<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    /**
     * Lấy danh sách sản phẩm với các tùy chọn lọc, sắp xếp và phân trang
     * 
     * @param string|null $search Từ khóa tìm kiếm
     * @param int|null $categoryId Lọc theo ID danh mục
     * @param float|null $minPrice Giá tối thiểu
     * @param float|null $maxPrice Giá tối đa
     * @param string $sortBy Trường để sắp xếp (name, price, newest)
     * @param string $sortOrder Thứ tự sắp xếp (asc, desc)
     * @param int $limit Số sản phẩm trên một trang
     * @param int $offset Vị trí bắt đầu
     * @return array Danh sách sản phẩm
     */
    public function getProducts($search = null, $categoryId = null, $minPrice = null, $maxPrice = null, $sortBy = 'newest', $sortOrder = 'desc', $limit = null, $offset = null)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name, p.category_id
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
        
        $conditions = [];
        $params = [];
        
        // Xây dựng điều kiện WHERE
        if ($search) {
            $conditions[] = "(p.name LIKE :search OR p.description LIKE :search)";
            $params[':search'] = "%" . $search . "%";
        }
        
        if ($categoryId) {
            $conditions[] = "p.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }
        
        if ($minPrice !== null) {
            $conditions[] = "p.price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        
        if ($maxPrice !== null) {
            $conditions[] = "p.price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }
        
        // Kết hợp các điều kiện với WHERE nếu có
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        // Xác định trường sắp xếp
        $orderField = "p.id";
        switch ($sortBy) {
            case 'name':
                $orderField = "p.name";
                break;
            case 'price':
                $orderField = "p.price";
                break;
            case 'newest':
            default:
                $orderField = "p.id"; // Sắp xếp theo ID (giả định ID cao hơn = sản phẩm mới hơn)
                $order = 'DESC'; // Luôn sắp xếp giảm dần với sản phẩm mới nhất
                break;
        }
        
        // Xác định thứ tự sắp xếp
        $order = strtolower($sortOrder) === 'asc' ? 'ASC' : 'DESC';
        
        // Thêm phần ORDER BY
        $query .= " ORDER BY {$orderField} {$order}";
        
        // Thêm phần LIMIT và OFFSET cho phân trang
        if ($limit !== null) {
            $query .= " LIMIT :limit";
            if ($offset !== null) {
                $query .= " OFFSET :offset";
            }
        }
        
        $stmt = $this->conn->prepare($query);
        
        // Bind các tham số
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        // Bind tham số phân trang
        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            if ($offset !== null) {
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            }
        }
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Lấy tổng số sản phẩm
     * 
     * @param string|null $search Từ khóa tìm kiếm
     * @param int|null $categoryId Lọc theo ID danh mục
     * @param float|null $minPrice Giá tối thiểu
     * @param float|null $maxPrice Giá tối đa
     * @return int Tổng số sản phẩm
     */
    public function getTotalProducts($search = null, $categoryId = null, $minPrice = null, $maxPrice = null)
    {
        $query = "SELECT COUNT(p.id) as total
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
        
        $conditions = [];
        $params = [];
        
        // Xây dựng điều kiện WHERE
        if ($search) {
            $conditions[] = "(p.name LIKE :search OR p.description LIKE :search)";
            $params[':search'] = "%" . $search . "%";
        }
        
        if ($categoryId) {
            $conditions[] = "p.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }
        
        if ($minPrice !== null) {
            $conditions[] = "p.price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        
        if ($maxPrice !== null) {
            $conditions[] = "p.price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }
        
        // Kết hợp các điều kiện với WHERE nếu có
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $stmt = $this->conn->prepare($query);
        
        // Bind các tham số
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }
    public function getProductById($id)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, p.category_id, c.name as category_name
        FROM " . $this->table_name . " p
        LEFT JOIN category c ON p.category_id = c.id
        WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
         $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateProduct($id, $name, $description, $price, $category_id, $image)
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, price=:price, category_id=:category_id, image=:image WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>