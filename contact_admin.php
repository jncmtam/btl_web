<?php
session_start();

// Kiểm tra nếu người dùng không phải là admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Xóa phản hồi nếu có yêu cầu
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Phản hồi đã được xóa!'); window.location.href = 'contact_admin.php';</script>";
}

// Truy vấn lấy dữ liệu từ bảng contacts
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage contacts</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>

    <main>
        <h1>Manage Contact</h1>
        <table class="styled-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['message']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phản hồi này không?');">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?> 
        </table>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
