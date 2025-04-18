<?php

include 'php/db_connect.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle success or error messages from add_to_cart.php
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo "<div class='alert'>$message</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - GlamGrove</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'php/header.php'; ?>

    <main class="pro-main">
        <h1 class="pro-title">Our Products</h1>
        <div class="pro-container">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="pro-card">
                        <img src="images/<?php echo $product['id']; ?>.png" alt="<?php echo $product['name']; ?>" class="pro-image">
                        <h2 class="pro-name"><?php echo $product['name']; ?></h2>
                        <p class="pro-description"><?php echo $product['description']; ?></p>
                        <p class="pro-price">$<?php echo number_format($product['price'], 2); ?></p>
                        
                        <form action="add_to_cart.php" method="POST" class="pro-form">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="pro-button">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="pro-no-products">No products found.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Include Footer -->
    <?php include 'php/footer.php'; ?>

    <!-- Include JavaScript file -->
    <script src="js/scripts.js"></script>
</body>
</html>