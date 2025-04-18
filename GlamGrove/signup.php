<?php

include 'php/db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_admin = $_POST['is_admin'] === 'yes' ? 1 : 0; // Convert radio button value to boolean

    // Insert user into the database
    $sql = "INSERT INTO users (name, username, email, password, is_admin) VALUES (:name, :username, :email, :password, :is_admin)";
    $stmt = $conn->prepare($sql);

    // Bind parameters using PDO
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Signup successful
        header("Location: login.php");
        exit();
    } else {
        // Signup failed
        $error_message = "Signup failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - GlamGrove</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'php/header.php'; ?>

    <main class="sign-main">
        <section class="sign-container">
            <h1 class="sign-title">Signup to GlamGrove</h1>
            <?php if (isset($error_message)): ?>
                <p class="sign-error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="sign-form" action="signup.php" method="POST">
                <div class="sign-form-group">
                    <label for="name" class="sign-label">Name</label>
                    <input type="text" id="name" name="name" class="sign-input" required>
                </div>
                <div class="sign-form-group">
                    <label for="username" class="sign-label">Username</label>
                    <input type="text" id="username" name="username" class="sign-input" required>
                </div>
                <div class="sign-form-group">
                    <label for="email" class="sign-label">Email</label>
                    <input type="email" id="email" name="email" class="sign-input" required>
                </div>
                <div class="sign-form-group">
                    <label for="password" class="sign-label">Password</label>
                    <input type="password" id="password" name="password" class="sign-input" required>
                </div>
                <div class="sign-form-group">
                    <label class="sign-label">Are you an admin?</label>
                    <div class="sign-radio-group">
                        <label class="sign-radio-label">
                            <input type="radio" name="is_admin" value="yes" class="sign-radio-input"> Yes
                        </label>
                        <label class="sign-radio-label">
                            <input type="radio" name="is_admin" value="no" class="sign-radio-input" checked> No
                        </label>
                    </div>
                </div>
                <button type="submit" class="sign-button">Signup</button>
            </form>
            <p class="sign-login-text">Already have an account? <a href="login.php" class="sign-login-link">Login here</a></p>
        </section>
    </main>

    <!-- Include Footer -->
    <?php include 'php/footer.php'; ?>

    <!-- Include JavaScript file -->
    <script src="js/scripts.js"></script>
</body>
</html>