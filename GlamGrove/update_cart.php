<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Adjust the path to db_connect.php as necessary
include 'php/db_connect.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // Update quantity in cart
    $sql = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id"; // Use named parameters for PDO
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to cart page
    header("Location: cart.php");
    exit();
}
?>