<?php
require_once __DIR__ . '/includes/db_connect.php';

try {
    $pdo->exec("INSERT INTO rooms (name, description, price, capacity) VALUES 
        ('Dining Table', 'Reserve a table for a magnificent dining experience.', 10.00, 4),
        ('Reception Hall', 'A grand reception hall for weddings and large gatherings.', 500.00, 100)
        ON DUPLICATE KEY UPDATE description=VALUES(description)");
    echo "Seeded successfully!";
} catch (Exception $e) {
    echo "Seed Error: " . $e->getMessage();
}
