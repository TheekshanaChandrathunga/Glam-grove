<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'php/db_connect.php'; // Ensure this file uses PDO

if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];

    // Remove item from cart
    $sql = "DELETE FROM cart WHERE id = :cart_id"; // Use named parameter
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind the parameter using PDO
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            // Redirect back to cart page
            header("Location: cart.php");
            exit();
        } else {
            echo "Error removing item: " . implode(", ", $stmt->errorInfo());
        }
    } else {
        echo "Error preparing statement: " . implode(", ", $conn->errorInfo());
    }
}
?>