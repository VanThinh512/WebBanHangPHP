-- =====================================================
-- COMMENT SYSTEM DATABASE TABLES
-- Tạo các bảng cho hệ thống bình luận và đánh giá
-- Tương thích với cơ sở dữ liệu my_store hiện tại
-- =====================================================

-- Bảng comments (3NF) - Lưu trữ bình luận và đánh giá sản phẩm
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(1) DEFAULT NULL,
  `status` enum('pending','approved','rejected','spam') DEFAULT 'pending',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Bảng comment_moderation - Lưu trữ lịch sử kiểm duyệt bình luận
CREATE TABLE IF NOT EXISTS `comment_moderation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL,
  `moderator_id` int NOT NULL,
  `action` enum('approve','reject','edit','delete','mark_spam') NOT NULL,
  `reason` text,
  `old_content` text,
  `new_content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `moderator_id` (`moderator_id`),
  CONSTRAINT `comment_moderation_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_moderation_ibfk_2` FOREIGN KEY (`moderator_id`) REFERENCES `account` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Bảng comment_reports - Báo cáo spam và vi phạm
CREATE TABLE IF NOT EXISTS `comment_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL,
  `reporter_id` int NOT NULL,
  `report_type` enum('spam','inappropriate','offensive','fake','other') NOT NULL,
  `reason` text,
  `status` enum('pending','reviewed','resolved','dismissed') DEFAULT 'pending',
  `reviewed_by` int DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `reporter_id` (`reporter_id`),
  KEY `reviewed_by` (`reviewed_by`),
  CONSTRAINT `comment_reports_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_reports_ibfk_2` FOREIGN KEY (`reporter_id`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_reports_ibfk_3` FOREIGN KEY (`reviewed_by`) REFERENCES `account` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Bảng banned_words - Danh sách từ cấm để lọc nội dung
CREATE TABLE IF NOT EXISTS `banned_words` (
  `id` int NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `severity` enum('low','medium','high','critical') DEFAULT 'medium',
  `action` enum('filter','block','flag') DEFAULT 'filter',
  `is_active` tinyint(1) DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `banned_words_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `account` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- =====================================================
-- INDEXES BỔ SUNG ĐỂ TỐI ƯU HIỆU SUẤT
-- (Các indexes cơ bản đã được tạo cùng với bảng)
-- =====================================================

-- Indexes bổ sung cho bảng comments
CREATE INDEX `idx_comments_product_status` ON `comments`(`product_id`, `status`);
CREATE INDEX `idx_comments_user_created` ON `comments`(`user_id`, `created_at`);
CREATE INDEX `idx_comments_status_created` ON `comments`(`status`, `created_at`);
CREATE INDEX `idx_comments_rating` ON `comments`(`rating`);

-- Indexes bổ sung cho bảng comment_moderation
CREATE INDEX `idx_moderation_action_created` ON `comment_moderation`(`action`, `created_at`);

-- Indexes bổ sung cho bảng comment_reports
CREATE INDEX `idx_reports_status_type` ON `comment_reports`(`status`, `report_type`);
CREATE INDEX `idx_reports_created` ON `comment_reports`(`created_at`);

-- Indexes bổ sung cho bảng banned_words
CREATE INDEX `idx_banned_words_active_severity` ON `banned_words`(`is_active`, `severity`);

-- =====================================================
-- DỮ LIỆU MẪU CHO BẢNG BANNED_WORDS
-- =====================================================

INSERT INTO banned_words (word, severity, action) VALUES
('spam', 'high', 'block'),
('fake', 'medium', 'flag'),
('scam', 'high', 'block'),
('cheat', 'medium', 'filter'),
('hack', 'medium', 'filter'),
('virus', 'high', 'block'),
('malware', 'high', 'block'),
('phishing', 'critical', 'block'),
('fraud', 'high', 'block'),
('illegal', 'high', 'block');

-- =====================================================
-- HOÀN THÀNH SCRIPT
-- =====================================================

-- Script này tạo 4 bảng cơ bản cho hệ thống comment:
-- 1. comments: Lưu bình luận và đánh giá
-- 2. comment_moderation: Lịch sử kiểm duyệt
-- 3. comment_reports: Báo cáo vi phạm
-- 4. banned_words: Từ cấm để lọc nội dung
--
-- Để chạy script này trong MySQL:
-- 1. Mở phpMyAdmin hoặc MySQL Workbench
-- 2. Chọn database 'my_store'
-- 3. Copy và paste toàn bộ nội dung file này
-- 4. Thực thi (Execute)