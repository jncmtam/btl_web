<?php
session_start();
include 'db.php'; // Kết nối database

// Lấy vai trò người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';


// Xử lý thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && $role === 'user') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $username = $_SESSION['username'];

    // Kiểm tra sản phẩm có trong giỏ hàng chưa
    $query = "SELECT * FROM shopping_cart WHERE username = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
        $updateQuery = "UPDATE shopping_cart SET quantity = quantity + ? WHERE username = ? AND product_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("isi", $quantity, $username, $product_id);
        $updateStmt->execute();
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $insertQuery = "INSERT INTO shopping_cart (username, product_id, quantity) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sii", $username, $product_id, $quantity);
        $insertStmt->execute();
    }

    header("Location: services.php");
    exit();
}


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Services and products page">
    <title>Services - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>
    
    <?php include 'nav.php'; ?>

    <main>
        <h1>Danh Sách Sản Phẩm</h1>

        <div class="product-list">
        <?php while ($product = $result->fetch_assoc()) : ?>
            <div class="product">
                <h2><?php echo $product['name']; ?></h2>
                <p>Giá: <?php echo $product['price']; ?> VND</p>
                <p>Số lượng còn lại: <?php echo $product['quantity']; ?></p>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"><br>

                <?php if ($role === 'user') : ?>
                    <form action="services.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="quantity" class="quantity_label" >Số lượng:</label>
                        <input type="number" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" value="1" required>
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                <?php endif; ?>

            </div>
        <?php endwhile; ?>
        </div>

    </main>

    <?php include 'footer.php'; ?>

</body>
</html>

<?php $conn->close(); ?>
