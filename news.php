<?php
session_start();

// Lấy vai trò người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guess';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Services and products page">
    <title>News - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>
    
    <?php include 'nav.php'; ?>

    <main>
        
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
