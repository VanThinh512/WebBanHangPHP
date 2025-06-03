<?php
class FileUploadHelper {
    /**
     * Tải lên và xử lý file avatar
     * 
     * @param array $file File từ $_FILES
     * @param string $username Username dùng để tạo tên file duy nhất
     * @return array ['success' => bool, 'filename' => string, 'error' => string]
     */
    public static function uploadAvatar($file, $username) {
        // Thư mục lưu trữ avatar
        $targetDir = "uploads/avatars/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Kiểm tra file hợp lệ
        $result = [
            'success' => false,
            'filename' => '',
            'error' => ''
        ];
        
        // Kiểm tra có lỗi khi upload không
        if ($file['error'] !== UPLOAD_ERR_OK) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $result['error'] = 'File quá lớn.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $result['error'] = 'File upload không hoàn tất.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $result['error'] = 'Không có file nào được upload.';
                    break;
                default:
                    $result['error'] = 'Có lỗi xảy ra khi upload file.';
            }
            return $result;
        }
        
        // Kiểm tra file là ảnh
        $fileType = exif_imagetype($file['tmp_name']);
        if (!$fileType) {
            $result['error'] = 'File không phải là ảnh.';
            return $result;
        }
        
        // Chỉ cho phép một số định dạng ảnh
        $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
        if (!in_array($fileType, $allowedTypes)) {
            $result['error'] = 'Chỉ chấp nhận ảnh JPG, PNG hoặc GIF.';
            return $result;
        }
        
        // Kiểm tra kích thước file (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            $result['error'] = 'Ảnh không được vượt quá 2MB.';
            return $result;
        }
        
        // Tạo tên file duy nhất
        $filename = $username . '_' . time();
        
        // Thêm phần mở rộng phù hợp
        switch ($fileType) {
            case IMAGETYPE_JPEG:
                $filename .= '.jpg';
                break;
            case IMAGETYPE_PNG:
                $filename .= '.png';
                break;
            case IMAGETYPE_GIF:
                $filename .= '.gif';
                break;
        }
        
        $targetFile = $targetDir . $filename;
        
        // Di chuyển file từ thư mục tạm sang thư mục đích
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $result['success'] = true;
            $result['filename'] = $targetFile;
        } else {
            $result['error'] = 'Có lỗi xảy ra khi lưu file.';
        }
        
        return $result;
    }
    
    /**
     * Xóa avatar cũ khi cập nhật avatar mới
     * 
     * @param string $oldAvatarPath Đường dẫn đến avatar cũ
     * @return bool
     */
    public static function deleteOldAvatar($oldAvatarPath) {
        if (empty($oldAvatarPath) || !file_exists($oldAvatarPath)) {
            return false;
        }
        
        return unlink($oldAvatarPath);
    }
}
