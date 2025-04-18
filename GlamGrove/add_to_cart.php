<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Adjust the path to db_connect.php as necessary
include 'php/db_connect.php'; // Ensure this path is correct

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        // Update the quantity if the product is already in the cart
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = :user_id AND product_id = :product_id";
    } else {
        // Insert the product into the cart if it's not already there
        $sql = "INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to products page
    header("Location: ../glamgrove/products.php");
    exit();
}
?>