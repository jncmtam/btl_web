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
        <section id="about-us">
            <h1>About Our Company</h1>
            <p>We are a company that provides exceptional services in various industries...</p>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
