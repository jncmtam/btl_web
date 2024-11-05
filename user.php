<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}
$role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Company website homepage">
    <title>User Home - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <?php include 'nav.php'; ?>

    <main>
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    </main> 

    <?php include 'footer.php'; ?>

</body>
</html>
