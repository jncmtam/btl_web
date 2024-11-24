<?php 
    $this->title = "Admin home - Company";
    $user = $this->data["user"];

?>

<main>
    <h1>Welcome, Admin <?php echo $user["username"]; ?></h1>

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