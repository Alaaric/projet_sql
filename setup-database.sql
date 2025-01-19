SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET COLLATION_CONNECTION = 'utf8mb4_unicode_ci';

DROP DATABASE IF EXISTS projet_sql;

CREATE DATABASE IF NOT EXISTS projet_sql;
USE projet_sql;

CREATE TABLE IF NOT EXISTS categories (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(56) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(56) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id CHAR(36),
    image VARCHAR(254)
);

CREATE TABLE IF NOT EXISTS users (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(56) NOT NULL,
    firstname VARCHAR(56) NOT NULL,
    email VARCHAR(254) UNIQUE NOT NULL,
    password CHAR(60) NOT NULL,
    role ENUM('client', 'admin') NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    date_order DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('en cours', 'livré', 'annulé') NOT NULL
);

CREATE TABLE IF NOT EXISTS orders_products (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    order_id CHAR(36) NOT NULL,
    product_id CHAR(36) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL
);

ALTER TABLE products
ADD CONSTRAINT FK_products_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;

ALTER TABLE orders
ADD CONSTRAINT FK_orders_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE orders_products
ADD CONSTRAINT FK_orders_products_orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
ADD CONSTRAINT FK_orders_products_products FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE;

INSERT INTO categories (id, name) VALUES
(UUID(), 'petite arnaque'),
(UUID(), 'arnaque'),
(UUID(), 'bonne arnaque'),
(UUID(), 'bonne grosse arnaque');

INSERT INTO products (id, name, description, price, stock, category_id, image) VALUES
(UUID(), 'un chat', 'Un chat incroyable si vous voulez mon avis. à ce prix la c\'est moins cher que gratuit', 5000, 500, (SELECT id FROM categories WHERE name = 'petite arnaque'), 'chat1.jpg'),
(UUID(), 'un autre chat', 'Un chat de haute qualité qui vaut son pesant de cacahuète', 9999.99, 200, (SELECT id FROM categories WHERE name = 'arnaque'), 'chat2.jpg'),
(UUID(), 'UnChatCPasLeMême', 'Un chat incroyable pour decorer... votre salon?', 23479.99, 87, (SELECT id FROM categories WHERE name = 'bonne arnaque'), 'chat3.jpg'),
(UUID(), 'un chat?', 'Une belle arn... affaire pour les amateurs de NFT de COLLECTION!', 199999.99, 10, (SELECT id FROM categories WHERE name = 'bonne grosse arnaque'), 'chat4.jpg');

INSERT INTO users (id, name, firstname, email, password, role) VALUES
(UUID(), 'Place', 'Holder', 'place@holder.com', '$2y$10$GT4ZSG8MClNbl4z28tGC8eMcg3nyIFQiYeM8D6wm9ob0ySqLRF6YS', 'admin'),
(UUID(), 'Jean', 'Michel', 'jean@michel.com', '$2y$10$GT4ZSG8MClNbl4z28tGC8eMcg3nyIFQiYeM8D6wm9ob0ySqLRF6YS', 'admin'),
(UUID(), 'Lorem', 'Ipsum', 'lorem@ipsum.com', '$2y$10$GT4ZSG8MClNbl4z28tGC8eMcg3nyIFQiYeM8D6wm9ob0ySqLRF6YS', 'client');

INSERT INTO orders (id, user_id, date_order, status) VALUES
(UUID(), (SELECT id FROM users WHERE email = 'place@holder.com'), NOW(), 'en cours'),
(UUID(), (SELECT id FROM users WHERE email = 'jean@michel.com'), NOW(), 'livré'),
(UUID(), (SELECT id FROM users WHERE email = 'place@holder.com'), NOW(), 'annulé'),
(UUID(), (SELECT id FROM users WHERE email = 'lorem@ipsum.com'), NOW(), 'en cours');

INSERT INTO orders_products (id, order_id, product_id, quantity, unit_price) VALUES
(UUID(), (SELECT id FROM orders WHERE user_id = (SELECT id FROM users WHERE email = 'place@holder.com') ORDER BY date_order LIMIT 1), (SELECT id FROM products WHERE name = 'un chat'), 1, 5000),
(UUID(), (SELECT id FROM orders WHERE user_id = (SELECT id FROM users WHERE email = 'place@holder.com') ORDER BY date_order LIMIT 1), (SELECT id FROM products WHERE name = 'un autre chat'), 2, 9999.99),
(UUID(), (SELECT id FROM orders WHERE user_id = (SELECT id FROM users WHERE email = 'jean@michel.com') ORDER BY date_order LIMIT 1), (SELECT id FROM products WHERE name = 'UnChatCPasLeMême'), 1, 23479.99),
(UUID(), (SELECT id FROM orders WHERE user_id = (SELECT id FROM users WHERE email = 'lorem@ipsum.com') ORDER BY date_order LIMIT 1), (SELECT id FROM products WHERE name = 'un chat?'), 5,  199999.99);
