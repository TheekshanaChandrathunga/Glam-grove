<?php
session_start(); // Start the session
include 'php/db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $sql = "SELECT id, password FROM users WHERE email = :email"; // Remove 'role' from the query
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        // Login successful
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        // Remove the line below since 'role' is no longer being fetched
        // $_SESSION['role'] = $user['role'];
        header("Location: index.php"); // Redirect to dashboard
        exit();
    } else {
        // Login failed
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GlamGrove</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
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
                <li class="head-nav-item"><a href="cart.php" class="head-nav-link">Cart</a></li>
                <li class="head-nav-item"><a href="profile.php" class="head-nav-link">Profile</a></li>
            </ul>
        </nav>
        <div class="head-auth">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="head-auth-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="head-auth-link">Login</a>
                <span class="head-auth-separator">|</span>
                <a href="signup.php" class="head-auth-link">Signup</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="log-main">
        <section class="log-container">
            <h1 class="log-title">Login to GlamGrove</h1>
            <?php if (isset($error_message)): ?>
                <p class="log-error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="log-form" action="login.php" method="POST">
                <div class="log-form-group">
                    <label for="email" class="log-label">Email</label>
                    <input type="email" id="email" name="email" class="log-input" required>
                </div>
                <div class="log-form-group">
                    <label for="password" class="log-label">Password</label>
                    <input type="password" id="password" name="password" class="log-input" required>
                </div>
                <button type="submit" class="log-button">Login</button>
            </form>
            <p class="log-signup-text">Don't have an account? <a href="signup.php" class="log-signup-link">Signup here</a></p>
        </section>
    </main>

    <footer class="head-footer">
        <p>&copy; 2023 GlamGrove. All rights reserved.</p>
    </footer>
</body>
</html>