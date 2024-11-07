<?php
session_start();

// Kiểm tra quyền truy cập
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Kết nối đến cơ sở dữ liệu
include 'db.php';

$role = $_SESSION['role'];

// Xử lý thêm người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Thêm người dùng vào cơ sở dữ liệu
    $sql = "INSERT INTO users (username, email, phone, password, role) VALUES (?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $phone, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm người dùng thành công!'); window.location.href='usermanagement.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm người dùng: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Xử lý sửa người dùng
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Xử lý cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $update_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $sql = "UPDATE users SET username=?, email=?, phone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $email, $phone, $update_id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật người dùng thành công!'); window.location.href='usermanagement.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật người dùng: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Xử lý xóa người dùng
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Xóa người dùng khỏi cơ sở dữ liệu
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Xóa người dùng thành công!'); window.location.href='usermanagement.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa người dùng: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Lấy danh sách người dùng có vai trò là user
$sql = "SELECT id, username, email, phone FROM users WHERE role='user'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Services and products page">
    <title>User Management</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function showEditForm() {
            document.getElementById('editForm').style.display = 'block';
        }
        
        function hideEditForm() {
            document.getElementById('editForm').style.display = 'none';
        }
    </script>
</head>
<body>
    
    <?php include 'header.php'; ?>  

    <?php include 'nav.php'; ?>

    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>
                                <a href='usermanagement.php?edit_id=" . $row['id'] . "' onclick='showEditForm()'>Sửa</a> |
                                <a href='usermanagement.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này không?\")'>Xóa</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Không có người dùng nào.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form sửa người dùng nếu có -->
        <h2>Sửa thông tin người dùng</h2>
        <div id="editForm" style="display: <?php echo isset($user) ? 'block' : 'none'; ?>;">
            <form action="" method="POST">
                <input type="hidden" name="user_id" value="<?php echo isset($user) ? $user['id'] : ''; ?>">
                <label for="username">Tên người dùng:</label>
                <input type="text" name="username" id="username" value="<?php echo isset($user) ? $user['username'] : ''; ?>" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo isset($user) ? $user['email'] : ''; ?>" required>
                <br>
                <label for="phone">Điện thoại:</label>
                <input type="text" name="phone" id="phone" value="<?php echo isset($user) ? $user['phone'] : ''; ?>" required>
                <br>
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" required>
                <br>
                <input type="submit" name="update_user" value="Cập nhật người dùng">
                <button type="button" onclick="hideEditForm()">Hủy</button>
            </form>
        </div>

        <!-- Form thêm người dùng -->
        <h2>Thêm người dùng mới</h2>
        <form action="" method="POST">
            <label for="username">Tên người dùng:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br>
            <label for="phone">Điện thoại:</label>
            <input type="text" name="phone" id="phone" required>
            <br>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="submit" name="add_user" value="Thêm người dùng">
        </form>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>

<?php
$conn->close();
?>
