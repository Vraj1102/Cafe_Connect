-- Authentication Enhancement Schema
-- Add password hashing and session management

-- Add session tracking table
CREATE TABLE IF NOT EXISTS `user_sessions` (
  `session_id` VARCHAR(128) PRIMARY KEY,
  `user_id` INT(11) NOT NULL,
  `user_type` ENUM('customer', 'shop', 'admin') NOT NULL,
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP,
  INDEX `idx_user` (`user_id`, `user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add login attempts tracking (brute force protection)
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(45) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `attempt_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_username_ip` (`username`, `ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
