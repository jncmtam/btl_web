<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

$username = $_SESSION['username'];

// Xử lý xóa sản phẩm khỏi giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $product_id = $_POST['remove_product_id'];

    $deleteQuery = "DELETE FROM shopping_cart WHERE username = ? AND product_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();

    header("Location: shopping_cart.php");
    exit();
}

// Lấy sản phẩm trong giỏ hàng
$query = "SELECT p.name, p.price, sc.quantity, sc.product_id FROM shopping_cart sc
          JOIN products p ON sc.product_id = p.id WHERE sc.username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>

    <main>
        <h1>Your Shopping Cart</h1>

        <div class="cart">
            <?php if ($result->num_rows > 0): ?>
                <table class="styled-table">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($item = $result->fetch_assoc()): 
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['price']; ?> VND</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $itemTotal; ?> VND</td>
                            <td>
                                <form action="shopping_cart.php" method="POST">
                                    <input type="hidden" name="remove_product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td><?php echo $total; ?> VND</td>
                        <td>
                            <button type="button" onclick="alert('Proceed to checkout');">Mua hàng</button>
                        </td>
                    </tr>
                </table>
                
            <?php else: ?>
                <p>Giỏ hàng của bạn đang trống.</p>
            <?php endif; ?>
        </div>

    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
