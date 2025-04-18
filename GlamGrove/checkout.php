<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'php/db_connect.php'; // Ensure this path is correct

$user_id = $_SESSION['user_id'];
$cart_items = []; // Initialize as an empty array
$total_price = 0; // Initialize as 0

$sql = "SELECT cart.id AS cart_id, products.id AS product_id, products.name, products.description, products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = :user_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Calculate total price
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - GlamGrove</title>
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'php/header.php'; ?>

    <main class="checkout-main">
        <h1 class="checkout-title">Checkout</h1>

        <?php if (count($cart_items) > 0): ?>
            <div class="checkout-summary">
                <h2>Order Summary</h2>
                <table class="checkout-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr class="checkout-item">
                                <td class="checkout-item-name"><?php echo htmlspecialchars($item['name']); ?></td>
                                <td class="checkout-item-description"><?php echo htmlspecialchars($item['description']); ?></td>
                                <td class="checkout-item-price">$<?php echo number_format($item['price'], 2); ?></td>
                                <td class="checkout-item-quantity"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td class="checkout-item-total">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="checkout-total">
                    <p>Total: $<?php echo number_format($total_price, 2); ?></p>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="checkout-form">
                <h2>Shipping Information</h2>
                <form action="process_checkout.php" method="POST">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>
                    <!-- Add more form fields as needed -->
                    <button type="submit" class="checkout-button">Place Order</button>
                </form>
            </div>
        <?php else: ?>
            <p class="checkout-empty">Your cart is empty.</p>
        <?php endif; ?>
    </main>

    <!-- Include Footer -->
    <?php include 'php/footer.php'; ?>
</body>
</html>