-- Create Database
CREATE DATABASE IF NOT EXISTS hedawa_restaurant;
USE hedawa_restaurant;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer', 'staff') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Rooms Table (New)
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    capacity INT DEFAULT 1,
    is_available BOOLEAN DEFAULT TRUE
);

-- Bookings Table (Updated for Rooms/Tables)
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT, -- Can be NULL if booking table only
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    guests INT NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE SET NULL
);

-- Food Table (Previously menu_items)
CREATE TABLE food (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50),
    is_available BOOLEAN DEFAULT TRUE
);

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    delivery_address TEXT,
    status ENUM('pending', 'preparing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table (Mapping food to orders)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_time DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES food(id) ON DELETE CASCADE
);

-- Contacts Table (Previously messages)
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- SEED DATA
-- ==========================================

-- Seed Rooms
INSERT INTO rooms (name, description, price, capacity) VALUES 
('Single', 'Cozy single room for solo travelers.', 50.00, 1),
('Double', 'Comfortable double room perfect for couples.', 85.00, 2),
('Suite', 'Luxury suite with premium amenities and extra space.', 150.00, 4);

-- Seed Food
INSERT INTO food (name, description, price, category) VALUES 
('Rice and curry', 'Authentic traditional rice served with multiple curries.', 12.50, 'Mains'),
('Grilled chicken', 'Perfectly grilled chicken breast with side vegetables.', 18.00, 'Mains'),
('Salad', 'Fresh garden salad with vinaigrette dressing.', 8.00, 'Starters'),
('Soup', 'Creamy seasonal vegetable soup.', 6.50, 'Starters'),
('Dessert', 'House special chocolate lava cake.', 7.00, 'Desserts');

-- Dummy Admin User (Password: admin123)
INSERT INTO users (full_name, email, password_hash, role) VALUES 
('System Admin', 'admin@hedawa.com', '$2y$10$5AOnZQQEujrbd/rIfOI3VOZFnVng6a/Fj5qN7qKvLCaOIJYjo3U6.', 'staff');
