
-- Database schema for ShoeCommerce
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191),
  email VARCHAR(191) UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255),
  phone VARCHAR(30) NULL,
  is_admin TINYINT(1) DEFAULT 0,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

DROP TABLE IF EXISTS brands;
CREATE TABLE brands (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191),
  slug VARCHAR(191) UNIQUE
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191),
  slug VARCHAR(191) UNIQUE,
  parent_id BIGINT UNSIGNED NULL
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191),
  slug VARCHAR(191) UNIQUE,
  brand_id BIGINT UNSIGNED,
  category_id BIGINT UNSIGNED,
  description TEXT,
  price DECIMAL(10,2),
  discount_price DECIMAL(10,2) NULL,
  stock INT DEFAULT 0,
  rating DECIMAL(3,2) DEFAULT 0,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

DROP TABLE IF EXISTS product_images;
CREATE TABLE product_images (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED,
  path VARCHAR(255)
);

DROP TABLE IF EXISTS product_sizes;
CREATE TABLE product_sizes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED,
  size VARCHAR(10),
  stock INT DEFAULT 0
);

DROP TABLE IF EXISTS coupons;
CREATE TABLE coupons (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) UNIQUE,
  type ENUM('flat','percent') DEFAULT 'flat',
  value DECIMAL(10,2) DEFAULT 0,
  min_cart DECIMAL(10,2) DEFAULT 0,
  starts_at DATE NULL,
  ends_at DATE NULL,
  active TINYINT(1) DEFAULT 1
);

DROP TABLE IF EXISTS addresses;
CREATE TABLE addresses (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED,
  name VARCHAR(191),
  phone VARCHAR(30),
  line1 VARCHAR(191),
  line2 VARCHAR(191) NULL,
  city VARCHAR(100),
  state VARCHAR(100),
  postcode VARCHAR(20),
  country VARCHAR(100),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED,
  total DECIMAL(10,2),
  status ENUM('pending','shipped','delivered','cancelled','refunded') DEFAULT 'pending',
  payment_method VARCHAR(50),
  payment_ref VARCHAR(191) NULL,
  shipping_address_id BIGINT UNSIGNED,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

DROP TABLE IF EXISTS order_items;
CREATE TABLE order_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED,
  product_id BIGINT UNSIGNED,
  size VARCHAR(10),
  qty INT,
  price DECIMAL(10,2)
);

DROP TABLE IF EXISTS banners;
CREATE TABLE banners (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(191),
  image VARCHAR(255),
  link VARCHAR(255) NULL,
  active TINYINT(1) DEFAULT 1,
  position INT DEFAULT 0
);

DROP TABLE IF EXISTS gift_cards;
CREATE TABLE gift_cards (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) UNIQUE,
  balance DECIMAL(10,2) DEFAULT 0,
  expires_at DATE NULL,
  active TINYINT(1) DEFAULT 1
);

DROP TABLE IF EXISTS loyalty_points;
CREATE TABLE loyalty_points (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED,
  points INT DEFAULT 0
);

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED,
  product_id BIGINT UNSIGNED,
  rating INT,
  comment TEXT,
  approved TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP NULL
);

-- Demo admin user
INSERT INTO users (name,email,password,is_admin,created_at) VALUES
('Admin','admin@example.com','$2y$10$DqgQx3J4x2npeb3y7oOeYum2q3x0oU9pX8Ww3bF4G2bY4f2x9n2xK',1,NOW());
-- password is 'password'

-- Demo brands
INSERT INTO brands (name,slug) VALUES ('Nike','nike'),('Adidas','adidas'),('Puma','puma'),('Bata','bata'),('Reebok','reebok'),('Converse','converse');

-- Demo categories
INSERT INTO categories (name,slug,parent_id) VALUES
('Men','men',NULL),('Women','women',NULL),('Kids','kids',NULL),
('Sports','sports',1),('Casual','casual',1),('Formal','formal',1);

-- Demo products
INSERT INTO products (name,slug,brand_id,category_id,description,price,discount_price,stock,rating,status,created_at) VALUES
('Nike Air Zoom','nike-air-zoom',1,4,'Lightweight sports running shoe',8999,7499,50,4.7,1,NOW()),
('Adidas Ultraboost','adidas-ultraboost',2,4,'High comfort and energy return',11999,9999,40,4.8,1,NOW()),
('Puma Smash','puma-smash',3,5,'Casual everyday sneaker',3999,2999,80,4.4,1,NOW());

INSERT INTO product_sizes (product_id,size,stock) VALUES
(1,'7',10),(1,'8',15),(1,'9',15),
(2,'8',10),(2,'9',10),(2,'10',10),
(3,'6',20),(3,'7',20),(3,'8',20);

INSERT INTO coupons (code,type,value,min_cart,active) VALUES ('WELCOME100','flat',100,999,1),('SAVE10','percent',10,0,1);

INSERT INTO banners (title,image,link,active,position) VALUES
('Festive Sale','/storage/banners/sale.jpg','/offers',1,1),
('New Arrivals','/storage/banners/new.jpg','/',1,2);
