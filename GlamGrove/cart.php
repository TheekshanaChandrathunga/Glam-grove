<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'php/db_connect.php'; // Ensure this path is correct

$user_id = $_SESSION['user_id'];
$cart_items = []; // Initialize cart_items to an empty array

$sql = "SELECT cart.id AS cart_id, products.id AS product_id, products.name, products.description, products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = :user_id"; // Use named parameter

$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Use bindParam for PDO
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results

$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - GlamGrove</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <!-- Include Header -->
    <?php include 'php/header.php'; ?>

    <main class="cart-main">
        <h1 class="cart-title">Your Cart</h1>

        <?php if (count($cart_items) > 0): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr class="cart-item">
                            <td class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></td>
                            <td class="cart-item-description"><?php echo htmlspecialchars($item['description']); ?></td>
                            <td class="cart-item-price">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="cart-item-quantity">
                                <form action="update_cart.php" method="POST" class="cart-quantity-form">
                                    <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item['cart_id']); ?>">
                                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="cart-quantity-input">
                                    <button type="submit" class="cart-update-button">Update</button>
                                </form>
                            </td>
                            <td class="cart-item-total">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td class="cart-item-action">
                                <a href="remove_from_cart.php?cart_id=<?php echo htmlspecialchars($item['cart_id']); ?>" class="cart-remove-link">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-total">
                <p>Total: $<?php echo number_format($total_price, 2); ?></p>
            </div>

            <div class="cart-actions">
                <a href="checkout.php" class="cart-checkout-button">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p class="cart-empty">Your cart is empty.</p>
        <?php endif; ?>
    </main>

    <!-- Include Footer -->
    <?php include 'php/footer.php'; ?>
</body>
</html>