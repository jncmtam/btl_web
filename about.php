<?php
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guess';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About us page">
    <title>About Us - Company</title>
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
