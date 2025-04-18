create database glamgrove;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user', -- Add role column
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique product ID
    name VARCHAR(255) NOT NULL,        -- Product name
    description TEXT,                  -- Product description
    price DECIMAL(10, 2) NOT NULL,     -- Product price (up to 10 digits, 2 decimal places)
    image VARCHAR(255),                -- Path to product image
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of product creation
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique cart item ID
    user_id INT NOT NULL,              -- ID of the user who added the item
    product_id INT NOT NULL,           -- ID of the product in the cart
    quantity INT DEFAULT 1,            -- Quantity of the product in the cart
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the item was added
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Link to users table
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE -- Link to products table
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

