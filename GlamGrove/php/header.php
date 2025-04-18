<?php
session_start();
include 'php/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping Cart - Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="head-header">
        <div class="head-logo">
            <img src="images/logo.png" alt="Online Store Logo" class="head-logo-img">
        </div>
        <nav class="head-nav">
            <ul class="head-nav-list">
                <li class="head-nav-item"><a href="index.php" class="head-nav-link">Home</a></li>
                <li class="head-nav-item"><a href="products.php" class="head-nav-link">Products</a></li>
                <li class="head-nav-item"><a href="admin.php" class="head-nav-link">Dashboard</a></li>
                <li class="head-nav-item"><a href="contact.php" class="head-nav-link">Contact US</a></li>
            </ul>
        </nav>
        <div class="head-auth">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Show Visit Cart and Logout buttons when logged in -->
                <a href="cart.php" class="head-auth-link">Visit Cart</a>
                <span class="head-auth-separator">|</span>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Show Dashboard link for admin -->
                    <a href="admin.php" class="head-auth-link">Dashboard</a>
                    <span class="head-auth-separator">|</span>
                <?php endif; ?>
                <a href="logout.php" class="head-auth-link">Logout</a>
            <?php else: ?>
                <!-- Show Login and Signup buttons when not logged in -->
                <a href="login.php" class="head-auth-link">Login</a>
                <span class="head-auth-separator">|</span>
                <a href="signup.php" class="head-auth-link">Signup</a>
            <?php endif; ?>
        </div>
    </header>