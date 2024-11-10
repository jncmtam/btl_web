<!-- <?php
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Company website homepage">
    <meta name="keywords" content="company, services, products, pricing, contact">
    <title>Home - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <?php include 'nav.php'; ?>

    <main>
        <h1>Welcome to Our Company</h1>
            
        <section id="about">
            <h2>About BK Company</h2>
            <p>We are a leading provider of quality services and products to help your business succeed.</p>
            <a href="services.php">Abous Us</a>
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
    </main> 
    
    <?php include 'footer.php'; ?>

</body>
</html>
