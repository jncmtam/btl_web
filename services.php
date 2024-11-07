<?php
session_start();
include 'db.php'; // Kết nối database

// Lấy vai trò người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guess';

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
                <p>Số lượng: <?php echo $product['quantity']; ?></p>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"><br>
            </div>
        <?php endwhile; ?>
        </div>
        
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>

<?php $conn->close(); ?>
