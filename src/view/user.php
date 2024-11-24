<?php
    $this->title = "User - Home";
    $this->styleSheets = ["./css/styles.css"];
    $username = $this->data["username"];
?>

<main>
    <h1>Welcome, <?php echo $username ?></h1>

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

    <section id="news-home">
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