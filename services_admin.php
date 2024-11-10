<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}


$role = $_SESSION['role'];

// Xử lý thêm hoặc cập nhật sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];
    $id = $_POST['id'] ?? null;

    if ($id) {
        $sql = "UPDATE products SET name='$name', price='$price', quantity='$quantity', image='$image' WHERE id='$id'";
    } else {
        $sql = "INSERT INTO products (name, price, quantity, image) VALUES ('$name', '$price', '$quantity', '$image')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href = 'services_admin.php';</script>";
        // $message = "Cập nhật sản phẩm thành công!";
    } else {
        echo "<script>alert('Phản hồi đã được xóa!".$conn->error."'); window.location.href = 'contact_admin.php';</script>";
        // $message = "Lỗi: " . $conn->error;
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id='$id'";
    $conn->query($sql);
}

// Lấy danh sách sản phẩm
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

        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

        
        <!-- Danh sách sản phẩm -->
        <h2>Danh Sách Sản Phẩm</h2>
        <div class="product-list">
        <?php while ($product = $result->fetch_assoc()) : ?>
            <div class="product">
                <h3><?php echo $product['name']; ?></h3>
                <p>Giá: <?php echo $product['price']; ?> VND</p>
                <p>Số lượng: <?php echo $product['quantity']; ?></p>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"><br>
                <a href="services_admin.php?edit=<?php echo $product['id']; ?>">Sửa</a> | 
                <a href="services_admin.php?delete=<?php echo $product['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
            </div>
        <?php endwhile; ?>
        </div>

        <h2>Thêm Sản Phẩm</h2>
        <!-- Form thêm hoặc cập nhật sản phẩm -->
        <form action="services_admin.php" method="POST">
            <input type="hidden" name="id" value="">
            <label>Tên sản phẩm:</label><br>
            <input type="text" name="name" required><br>
            <label>Giá:</label><br>
            <input type="number" name="price" required><br>
            <label>Số lượng:</label><br>
            <input type="number" name="quantity" required><br>
            <label>Đường dẫn hình ảnh:</label><br>
            <input type="text" name="image"><br><br>
            <button type="submit">Lưu Sản Phẩm</button>
        </form>

    </main>

    <?php include 'footer.php'; ?>

</body>
</html>

<?php $conn->close(); ?>
