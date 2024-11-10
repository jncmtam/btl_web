<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Company website homepage">
    <meta name="keywords" content="company, services, products, pricing, contact">
    <title>Admin Home - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <?php include 'nav.php'; ?>

    <main>
        <h1>Welcome, Admin <?php echo $_SESSION['username']; ?></h1>

        <!-- Profile Section -->
        <section id="profile">
            <h2>Your Profile</h2>
            <p>View and update your profile information, including personal details and settings.</p>
            <a href="profile.php">Go to Profile</a>
        </section>

        <!-- Manage Users Section -->
        <section id="manage-users">
            <h2>Manage Users</h2>
            <p>View, edit, or delete user information, and manage user roles.</p>
            <a href="usermanagement.php">Go to User Management</a>
        </section>

        <!-- Manage Products Section -->
        <section id="manage-products">
            <h2>Manage Products</h2>
            <p>View, add, edit, or delete products listed on the website.</p>
            <a href="services_admin.php">Go to Product Management</a>
        </section>

        <!-- Manage Contact Section -->
        <section id="manage-contact">
            <h2>Manage Contact</h2>
            <p>View and respond to user feedback and inquiries.</p>
            <a href="contact_admin.php">Go to Feedback Management</a>
        </section>
    </main> 
    
    <?php include 'footer.php'; ?>


</body>
</html>
