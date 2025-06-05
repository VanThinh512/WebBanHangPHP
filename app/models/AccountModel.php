<?php
class AccountModel {
    private $conn;
    private $table_name = "account";
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Lấy danh sách tất cả người dùng
     */
    public function getAllAccounts() {
        $query = "SELECT id, username, fullname, role, email, phone, avatar FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Lấy thông tin người dùng theo ID
     */
    public function getAccountById($id) {
        $query = "SELECT id, username, fullname, role, email, phone, avatar FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function getAccountByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username
        LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function save($username, $fullName, $password, $role = 'user', $email = '', $phone = '', $avatar = '') {
        if ($this->getAccountByUsername($username)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " SET username=:username,
        fullname=:fullname, password=:password, role=:role, email=:email, phone=:phone, avatar=:avatar";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $role = htmlspecialchars(strip_tags($role));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $avatar = htmlspecialchars(strip_tags($avatar));
        
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":avatar", $avatar);
        return $stmt->execute();
    }
    
    /**
     * Cập nhật thông tin người dùng
     */
    public function updateAccount($id, $fullName, $role, $password = null, $email = null, $phone = null, $avatar = null) {
        // Kiểm tra người dùng tồn tại
        if (!$this->getAccountById($id)) {
            return ["error" => "Người dùng không tồn tại"];
        }
        
        // Xây dựng câu truy vấn SQL động dựa trên các trường được cập nhật
        $queryFields = ["fullname=:fullname", "role=:role"];
        if ($password) $queryFields[] = "password=:password";
        if ($email !== null) $queryFields[] = "email=:email";
        if ($phone !== null) $queryFields[] = "phone=:phone";
        if ($avatar !== null) $queryFields[] = "avatar=:avatar";
        
        $query = "UPDATE " . $this->table_name . " SET " . implode(", ", $queryFields) . " WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $fullName = htmlspecialchars(strip_tags($fullName));
        $role = htmlspecialchars(strip_tags($role));
        
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id);
        
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $hashedPassword);
        }
        
        if ($email !== null) {
            $email = htmlspecialchars(strip_tags($email));
            $stmt->bindParam(":email", $email);
        }
        
        if ($phone !== null) {
            $phone = htmlspecialchars(strip_tags($phone));
            $stmt->bindParam(":phone", $phone);
        }
        
        if ($avatar !== null) {
            $avatar = htmlspecialchars(strip_tags($avatar));
            $stmt->bindParam(":avatar", $avatar);
        }
        
        try {
            if ($stmt->execute()) {
                return true;
            }
            return ["error" => "Có lỗi xảy ra khi cập nhật"];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    
    /**
     * Xóa người dùng
     */
    public function deleteAccount($id) {
        // Kiểm tra người dùng tồn tại
        if (!$this->getAccountById($id)) {
            return "Người dùng không tồn tại";
        }
        
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        try {
            if ($stmt->execute()) {
                return true;
            }
            return "Có lỗi xảy ra khi xóa người dùng";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>