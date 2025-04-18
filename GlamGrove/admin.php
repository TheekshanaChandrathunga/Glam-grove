<?php



// Include the database connection
include 'php/db_connect.php';

// Handle form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Insert the new product into the database
    $sql = "INSERT INTO products (name, description, price) VALUES (:name, :description, :price)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->execute();
}

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id = :delete_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$stmt = $conn->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users from the database
$sql = "SELECT * FROM users";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GlamGrove</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include 'php/header.php'; ?>

    <main class="admin-main">
        <h1 class="admin-title">Admin Dashboard</h1>

        <!-- Add Product Form -->
        <section class="admin-section">
            <h2 class="admin-section-title">Add Product</h2>
            <form class="admin-form" method="POST" action="admin.php">
                <div class="admin-form-group">
                    <label for="name" class="admin-label">Product Name</label>
                    <input type="text" id="name" name="name" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="description" class="admin-label">Description</label>
                    <textarea id="description" name="description" class="admin-textarea" required></textarea>
                </div>
                <div class="admin-form-group">
                    <label for="price" class="admin-label">Price</label>
                    <input type="number" id="price" name="price" class="admin-input" step="0.01" required>
                </div>
                <button type="submit" name="add_product" class="admin-button">Add Product</button>
            </form>
        </section>

        <!-- Product List -->
        <section class="admin-section">
            <h2 class="admin-section-title">Product List</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['description']; ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <a href="dashboard.php?delete_id=<?php echo $product['id']; ?>" class="admin-delete-link">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- User List -->
        <section class="admin-section">
            <h2 class="admin-section-title">User List</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo isset($user['role']) ? $user['role'] : 'user'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    
    <?php include 'php/footer.php'; ?>
</body>
</html>