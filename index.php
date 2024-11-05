<!-- <?php
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guess';
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
        <section id="hero">
            <h1>Welcome to Our Company</h1>
            <p>Providing top-notch services and products for your needs.</p>
            <a href="services.php" class="cta-button">Explore Our Services</a>
        </section>

        <section id="services">
            <h2>Our Services</h2>
            <div class="service-item">
                <h3>Service 1</h3>
                <p>High-quality service description.</p>
            </div>
            <div class="service-item">
                <h3>Service 2</h3>
                <p>Reliable and professional solutions.</p>
            </div>
        </section>
    </main> 
    
    <?php include 'footer.php'; ?>

</body>
</html>
