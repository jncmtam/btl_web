<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Lấy vai trò người dùng từ session
$role = $_SESSION['role'];

// Lấy thông tin người dùng từ database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

$user = $result->fetch_assoc();
// Xử lý khi người dùng cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra nếu mật khẩu mới trùng khớp
    if (!empty($new_password)) {
        if ($new_password === $confirm_password) {
            $sql = "UPDATE users SET email='$email', phone='$phone', password='$new_password' WHERE username='$username'";
            echo "<script> alert('Cập nhật mật khẩu thành công!'); window.location.href = 'profile.php';</script>";
            // $password_message = "Cập nhật mật khẩu thành công!";
        } else {
            echo "<script> alert('Mật khẩu xác nhận không khớp!'); window.location.href = 'profile.php';</script>";
            // $password_message = "Mật khẩu xác nhận không khớp!";
        }
    } else {
        $sql = "UPDATE users SET email='$email', phone='$phone' WHERE username='$username'";
    }

    // Thực hiện câu lệnh cập nhật
    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Cập nhật thông tin thành công!'); window.location.href = 'profile.php';</script>";
        // $message = "Cập nhật thông tin thành công!";
    } else {
        echo "<script> alert('Lỗi cập nhật! ".$conn->error."'); window.location.href = 'profile.php';</script>";
        // $message = "Lỗi cập nhật: " . $conn->error;
    }

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Profile page">
    <title>Profile</title>
    <link rel="stylesheet" href="css/styles.css">
    
    <script>
        function enableEditing() {
            // Bỏ thuộc tính readonly để các trường có thể chỉnh sửa
            document.getElementById("email").removeAttribute("readonly");
            document.getElementById("phone").removeAttribute("readonly");
            document.getElementById("new_password").removeAttribute("readonly");
            document.getElementById("confirm_password").removeAttribute("readonly");

            // Chuyển nút "Cập nhật" thành "Lưu"
            document.getElementById("editBtn").style.display = "none";
            document.getElementById("saveBtn").style.display = "inline";
        }
    </script>
</head>
<body>

    <?php include 'header.php'; ?>

    <?php include 'nav.php'; ?>

    <main>
        <h1>Thông tin cá nhân</h1>

        <form action="profile.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" value="<?php echo $user['username']; ?>" readonly>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" readonly required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" readonly>

            <h3>Thay đổi mật khẩu</h3>
            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" id="new_password" name="new_password" readonly>

            <label for="confirm_password">Xác nhận mật khẩu mới:</label>
            <input type="password" id="confirm_password" name="confirm_password" readonly>

            <!-- Nút Cập nhật và Lưu -->
            <button type="button" id="editBtn" onclick="enableEditing()">Cập nhật</button>
            <button type="submit" id="saveBtn" style="display: none;">Lưu</button>
        </form>

        <!-- Hiển thị thông báo -->
        <!-- <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <?php if (isset($password_message)) { echo "<p class='error'>$password_message</p>"; } ?> -->

    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
