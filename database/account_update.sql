-- Thêm các trường mới vào bảng account
ALTER TABLE account 
ADD COLUMN email VARCHAR(255) NULL,
ADD COLUMN phone VARCHAR(20) NULL,
ADD COLUMN avatar VARCHAR(255) NULL;

-- Cập nhật bảng hiện có để thêm các giá trị mặc định cho email và phone
UPDATE account SET email = CONCAT(username, '@example.com'), phone = '';
