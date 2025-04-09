-- Drop and create the database
DROP DATABASE IF EXISTS lanube_api;
CREATE DATABASE lanube_api CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE lanube_api;

-- Create tables for authentication system
CREATE TABLE IF NOT EXISTS `groups` (
    `id_group` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(100),
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`id_group`),
    UNIQUE INDEX `name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
    `id_user` INT NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(45) NOT NULL,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(255) NOT NULL,
    `email` VARCHAR(254) NOT NULL,
    `activation_selector` VARCHAR(255),
    `activation_code` VARCHAR(255),
    `forgotten_password_selector` VARCHAR(255),
    `forgotten_password_code` VARCHAR(255),
    `forgotten_password_time` INT,
    `remember_selector` VARCHAR(255),
    `remember_code` VARCHAR(255),
    `created_on` INT NOT NULL,
    `last_login` INT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `name` VARCHAR(50),
    `surname` VARCHAR(50),
    `company` VARCHAR(100),
    `telefono` VARCHAR(20),
    `phone` VARCHAR(20),
    `last_ip` VARCHAR(45),
    `last_activity` INT,
    `avatar` VARCHAR(255),
    `gender` VARCHAR(1),
    `group_id` INT,
    `type_user_id` INT,
    PRIMARY KEY (`id_user`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users_groups` (
    `id_user` INT NOT NULL,
    `id_group` INT NOT NULL,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_user`, `id_group`),
    KEY `id_group` (`id_group`),
    KEY `id_user` (`id_user`),
    CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
    CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `login_attempts_errors` (
    `id_attemp` INT NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(45) NOT NULL,
    `login` VARCHAR(100) NOT NULL,
    `time` INT NOT NULL,
    `id_user` INT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`id_attemp`),
    KEY `id_user` (`id_user`),
    CONSTRAINT `login_attempts_errors_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create tables for location management
CREATE TABLE IF NOT EXISTS `countries` (
    `country_id` INT NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(3) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `capital` VARCHAR(100),
    `province` VARCHAR(100),
    `area` DECIMAL(10,2),
    `population` INT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`country_id`),
    UNIQUE INDEX `code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `provinces` (
    `province_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `country_id` INT NOT NULL,
    `population` INT,
    `area` DECIMAL(10,2),
    `capital` VARCHAR(100),
    `capprovince` VARCHAR(100),
    `code` VARCHAR(5) NOT NULL,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`province_id`),
    UNIQUE INDEX `code_unique` (`code`),
    KEY `provinces_ibfk_1` (`country_id`),
    CONSTRAINT `provinces_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `destinations` (
    `destination_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `province_id` INT NOT NULL,
    `postal_code` VARCHAR(20) NOT NULL,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`destination_id`),
    UNIQUE INDEX `postal_code_unique` (`postal_code`),
    KEY `destinations_ibfk_1` (`province_id`),
    CONSTRAINT `destinations_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create tables for customer management
CREATE TABLE IF NOT EXISTS `customers` (
    `customer_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100),
    `surname` VARCHAR(100),
    `password` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255),
    `province` VARCHAR(100),
    `location` VARCHAR(100),
    `telephone` VARCHAR(20),
    `email` VARCHAR(100) NOT NULL,
    `code_confirmation` VARCHAR(100),
    `type_user_id` INT,
    `status_code_confirmation` VARCHAR(50),
    `postal_code` VARCHAR(20),
    `country_id` INT NOT NULL,
    `province_id` INT,
    `province_name_manual` VARCHAR(255) DEFAULT NULL,
    `destination_name_manual` VARCHAR(255) DEFAULT NULL,
    `destination_id` INT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    `social_reason` VARCHAR(100),
    `fiscal_identifier` VARCHAR(50),
    `person_contact` VARCHAR(100),
    `business_hours` VARCHAR(100),
    PRIMARY KEY (`customer_id`),
    UNIQUE INDEX `email_unique` (`email`),
    KEY `customers_country_id_fk` (`country_id`),
    KEY `customers_province_id_fk` (`province_id`),
    KEY `customers_destination_id_fk` (`destination_id`),
    CONSTRAINT `customers_country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `customers_province_id_fk` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `customers_destination_id_fk` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`destination_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `token_customers` (
    `token_id` INT NOT NULL AUTO_INCREMENT,
    `customer_id` INT NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `token_dev` VARCHAR(255),
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`token_id`),
    UNIQUE INDEX `token_unique` (`token`),
    UNIQUE INDEX `token_dev_unique` (`token_dev`),
    KEY `token_customer_id_fk` (`customer_id`),
    CONSTRAINT `token_customer_id_fk` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `customer_shipping_credentials` (
    `credential_id` INT NOT NULL AUTO_INCREMENT,
    `store_order_id` INT,
    `customer_id` INT NOT NULL,
    `code_postal` VARCHAR(20),
    `country_code` VARCHAR(3),
    `province_code` VARCHAR(5),
    `city` VARCHAR(100),
    `street` VARCHAR(255),
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `address` VARCHAR(255),
    `postal_code` VARCHAR(20),
    `province` VARCHAR(100),
    PRIMARY KEY (`credential_id`),
    KEY `customer_id` (`customer_id`),
    CONSTRAINT `customer_shipping_credentials_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create tables for shipping and orders
CREATE TABLE IF NOT EXISTS `tariff` (
    `tariff_id` INT NOT NULL AUTO_INCREMENT,
    `destination_id` INT NULL,
    `country_id` INT NOT NULL,
    `province_id` INT NULL,
    `tariff_price` DECIMAL(10,2) NOT NULL,
    `weight` DECIMAL(15,2),
    `volume` DECIMAL(15,2),
    `province_name_manual` VARCHAR(255) DEFAULT NULL,
    `destination_name_manual` VARCHAR(255) DEFAULT NULL,
    `postal_code_manual` VARCHAR(20) DEFAULT NULL,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`tariff_id`),
    KEY `destination_id` (`destination_id`),
    KEY `country_id` (`country_id`),
    KEY `province_id` (`province_id`),
    CONSTRAINT `tariff_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`destination_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `tariff_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `tariff_ibfk_3` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `statuses` (
    `status_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `orders` (
    `order_id` INT NOT NULL AUTO_INCREMENT,
    `customer_id` INT NOT NULL,
    `tariff_id` INT NOT NULL,
    `status_id` INT NOT NULL,
    `order_number` VARCHAR(50) NOT NULL,
    `total_amount` DECIMAL(10,2) NOT NULL,
    `tracking_number` VARCHAR(100),
    `items` TEXT,
    `client` VARCHAR(255),
    `reference` VARCHAR(255),
    `shipping_data` TEXT,
    `postal_code` VARCHAR(20),
    `weight` DECIMAL(15,2),
    `volume` DECIMAL(15,2),
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`order_id`),
    UNIQUE INDEX `order_number_unique` (`order_number`),
    KEY `customer_id` (`customer_id`),
    KEY `tariff_id` (`tariff_id`),
    KEY `status_id` (`status_id`),
    CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`tariff_id`) REFERENCES `tariff` (`tariff_id`),
    CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
    `order_item_id` INT NOT NULL AUTO_INCREMENT,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    `unit_price` DECIMAL(10,2) NOT NULL,
    `total_price` DECIMAL(10,2) NOT NULL,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`order_item_id`),
    KEY `order_id` (`order_id`),
    CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create tables for menu and permissions
CREATE TABLE IF NOT EXISTS `menus` (
    `id_menu` INT NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(100) NOT NULL,
    `link` VARCHAR(255),
    `status` INT DEFAULT 1,
    `parent` INT DEFAULT 0,
    `iconpath` VARCHAR(255),
    `active` TINYINT NOT NULL DEFAULT 1,
    `dashboard` TINYINT NOT NULL DEFAULT 0,
    `order` INT DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`id_menu`),
    KEY `parent` (`parent`),
    CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menus` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `permissions` (
    `id_permission` INT NOT NULL AUTO_INCREMENT,
    `id_group` INT NOT NULL,
    `id_menu` INT NOT NULL,
    `read` TINYINT NOT NULL DEFAULT 0,
    `insert` TINYINT NOT NULL DEFAULT 0,
    `update` TINYINT NOT NULL DEFAULT 0,
    `delete` TINYINT NOT NULL DEFAULT 0,
    `export` TINYINT NOT NULL DEFAULT 0,
    `print` TINYINT NOT NULL DEFAULT 0,
    `invoice` TINYINT NOT NULL DEFAULT 0,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`id_permission`),
    KEY `id_group` (`id_group`),
    KEY `id_menu` (`id_menu`),
    CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`),
    CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create tables for content management
CREATE TABLE IF NOT EXISTS `faqs` (
    `id_faq` INT NOT NULL AUTO_INCREMENT,
    `question` TEXT NOT NULL,
    `answer` TEXT NOT NULL,
    `slug` VARCHAR(255),
    `order` INT DEFAULT 0,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_faq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `image_gallery` (
    `image_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `title` VARCHAR(100),
    `description` TEXT,
    `file_path` VARCHAR(255),
    `order` INT DEFAULT 0,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `login_attempts` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(45) NOT NULL,
    `login` VARCHAR(100) NOT NULL,
    `time` INT NOT NULL,
    `id_user` INT,
    PRIMARY KEY (`id`),
    KEY `id_user` (`id_user`),
    CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `login_errors` (
    `id_login` INT NOT NULL AUTO_INCREMENT,
    `user` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `ip_address` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create tables for system management
CREATE TABLE IF NOT EXISTS `configurations` (
    `id_configuration` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `value` TEXT,
    `key_id` VARCHAR(100) NOT NULL,
    `input` VARCHAR(50),
    `required` TINYINT NOT NULL DEFAULT 0,
    `icon` VARCHAR(50),
    `ordering` INT DEFAULT 0,
    `enabled` TINYINT NOT NULL DEFAULT 1,
    `active` TINYINT NOT NULL DEFAULT 1,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`id_configuration`),
    UNIQUE INDEX `key_id_unique` (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `activity_log` (
    `activity_id` INT NOT NULL AUTO_INCREMENT,
    `id_user` INT NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `ip_address` VARCHAR(45) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`activity_id`),
    KEY `id_user` (`id_user`),
    CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `email_templates` (
    `template_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `variables` TEXT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `email_logs` (
    `log_id` INT NOT NULL AUTO_INCREMENT,
    `template_id` INT DEFAULT NULL,
    `recipient` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `error_message` TEXT,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`log_id`),
    KEY `template_id` (`template_id`),
    CONSTRAINT `email_logs_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `email_templates` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `product_categories` (
    `category_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `parent_id` INT DEFAULT NULL,
    `order` INT DEFAULT 0,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`category_id`),
    KEY `parent_id` (`parent_id`),
    CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `product_media` (
    `media_id` INT NOT NULL AUTO_INCREMENT,
    `product_id` INT NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_type` VARCHAR(50) NOT NULL,
    `is_primary` TINYINT NOT NULL DEFAULT 0,
    `order` INT DEFAULT 0,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `opciones_variables` (
    `opcion_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `value` TEXT,
    `description` TEXT,
    `order` INT DEFAULT 0,
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`opcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
    `tipo_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(100),
    `active` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME DEFAULT NULL,
    `create_by` INT DEFAULT NULL,
    `update_by` INT DEFAULT NULL,
    `delete_by` INT DEFAULT NULL,
    PRIMARY KEY (`tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial admin group
INSERT INTO `groups` (`name`, `description`) VALUES
('admin', 'Administrator');

-- Insert initial admin user with correct Ion Auth SHA1 password (password: admin123)
INSERT INTO `users` (
    `ip_address`,
    `username`,
    `password`,
    `salt`,
    `email`,
    `created_on`,
    `active`,
    `name`,
    `surname`
) VALUES (
    '127.0.0.1',
    'admin',
    SHA1(CONCAT('admin123', 'admin_salt')), -- Using exact SHA1 format
    'admin_salt',
    'admin@admin.com',
    UNIX_TIMESTAMP(),
    1,
    'Admin',
    'User'
);

-- Link admin user to admin group
INSERT INTO `users_groups` (`id_user`, `id_group`)
SELECT 
    (SELECT `id_user` FROM `users` WHERE `username` = 'admin'),
    (SELECT `id_group` FROM `groups` WHERE `name` = 'admin');

-- Insert test users with correct Ion Auth SHA1 passwords (password: test123)
INSERT INTO `users` (
    `ip_address`,
    `username`,
    `password`,
    `salt`,
    `email`,
    `created_on`,
    `active`,
    `name`,
    `surname`
) VALUES 
(
    '127.0.0.1',
    'admin1',
    SHA1(CONCAT('test123', 'salt1')), -- Using exact SHA1 format
    'salt1',
    'admin1@lanube.com',
    UNIX_TIMESTAMP(),
    1,
    'Admin',
    'User 1'
),
(
    '127.0.0.1',
    'admin2',
    SHA1(CONCAT('test123', 'salt2')), -- Using exact SHA1 format
    'salt2',
    'admin2@lanube.com',
    UNIX_TIMESTAMP(),
    1,
    'Admin',
    'User 2'
),
(
    '127.0.0.1',
    'admin3',
    SHA1(CONCAT('test123', 'salt3')), -- Using exact SHA1 format
    'salt3',
    'admin3@lanube.com',
    UNIX_TIMESTAMP(),
    1,
    'Admin',
    'User 3'
);

-- Link additional admin users to admin group
INSERT INTO `users_groups` (`id_user`, `id_group`)
SELECT u.id_user, g.id_group
FROM `users` u
CROSS JOIN `groups` g
WHERE u.username IN ('admin1', 'admin2', 'admin3') AND g.name = 'admin';