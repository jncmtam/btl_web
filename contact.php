<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Kết nối cơ sở dữ liệu
    include 'db.php';

    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Thực hiện câu lệnh SQL để lưu phản hồi vào bảng feedback
    $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Phản hồi của bạn đã được gửi thành công!');</script>";
    } else {
        echo "<script>alert('Lỗi khi gửi phản hồi: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact page">
    <title>Contact - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <?php include 'nav.php'; ?>

    <main>
        <section id="contact">
            <h1>Contact Us</h1>
            <form action="contact.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit" name="submit">Send Message</button>
            </form>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
