<?php
session_start();
include 'php/db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert contact form data into the database
    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $conn->prepare($sql);

    // Bind parameters using bindValue()
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Form submission successful
        $success_message = "Thank you for contacting us! We will get back to you soon.";
    } else {
        // Form submission failed
        $error_message = "Something went wrong. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GlamGrove</title>
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
                <a href="php/logout.php" class="head-auth-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="head-auth-link">Login</a>
                <span class="head-auth-separator">|</span>
                <a href="signup.php" class="head-auth-link">Signup</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="cont-main">
        <section class="cont-container">
            <h1 class="cont-title">Contact Us</h1>
            <?php if (isset($success_message)): ?>
                <p class="cont-success"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="cont-error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="cont-form" action="contact.php" method="POST">
                <div class="cont-form-group">
                    <label for="name" class="cont-label">Name</label>
                    <input type="text" id="name" name="name" class="cont-input" required>
                </div>
                <div class="cont-form-group">
                    <label for="email" class="cont-label">Email</label>
                    <input type="email" id="email" name="email" class="cont-input" required>
                </div>
                <div class="cont-form-group">
                    <label for="subject" class="cont-label">Subject</label>
                    <input type="text" id="subject" name="subject" class="cont-input" required>
                </div>
                <div class="cont-form-group">
                    <label for="message" class="cont-label">Message</label>
                    <textarea id="message" name="message" class="cont-textarea" rows="5" required></textarea>
                </div>
                <button type="submit" class="cont-button">Send Message</button>
            </form>
        </section>
    </main>

    <footer class="head-footer">
        <p>&copy; 2023 GlamGrove. All rights reserved.</p>
    </footer>

    <!-- Include JavaScript file -->
    <script src="js/scripts.js"></script>
</body>
</html>