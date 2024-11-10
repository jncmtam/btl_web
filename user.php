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

        <section id="about">
            <h2>About BK Company</h2>
            <p>We are a leading provider of quality services and products to help your business succeed.</p>
            <a href="services.php">About Us</a>
        </section>

        <section id="profile">
            <h2>Your Profile</h2>
            <p>View and update your profile information, including personal details and settings.</p>
            <a href="profile.php">Go to Profile</a>
        </section>

        <section id="services">
            <h2>Our Services</h2>
            <p>Discover our wide range of services tailored to your needs.</p>
            <a href="services.php">Explore Services</a>
        </section>

        <section id="news">
            <h2>Latest News</h2>
            <p>Stay updated with our latest news and updates.</p>
            <a href="news.php">Read News</a>
        </section>

        <section id="contact">
            <h2>Contact Us</h2>
            <p>If you have any questions, feedback, or inquiries, feel free to reach out to us.</p>
            <a href="contact.php">Contact Us</a>
        </section>
    </main> 

    <?php include 'footer.php'; ?>

</body>
</html>
