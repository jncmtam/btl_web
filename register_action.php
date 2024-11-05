<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = 'user'; // Mặc định là user

    $sql = "INSERT INTO users (username, password, role, phone, email) VALUES ('$username', '$password', '$role', '$phone', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php"); // Chuyển đến trang login
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
