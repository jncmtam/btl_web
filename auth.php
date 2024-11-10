<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // echo $password;
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        

        if ($password == $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            
            // echo "<pre>";
            // print_r($_SESSION); // In toàn bộ nội dung của session
            // echo "</pre>";

            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: user.php");
            }
            exit();
        } else {
            echo "<script>alert('Sai mật khẩu!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Tài khoản không tồn tại!'); window.location.href='login.php';</script>";
        }
}

$conn->close();
?>
