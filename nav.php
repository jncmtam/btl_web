<nav>
    <ul>
        <li>
            <a href="<?php echo $role === 'admin' ? 'admin.php' : ($role === 'user' ? 'user.php' : 'index.php'); ?>">
                Home
            </a>
        </li>

        <li><a href="about.php">About Us</a></li>

        <li><a href="news.php">News</a></li>

        <?php if ($role === 'guess' || $role === 'user'): ?>
            <li><a href="services.php">Services</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin' || $role === 'user'): ?>
            <li><a href="profile.php">Profile</a></li>
        <?php endif; ?>

        <?php if ($role === 'guess' || $role === 'user'): ?>
            <li><a href="contact.php">Contact</a></li>
        <?php endif; ?>

        <?php if ($role === 'user'): ?>
            <li><a href="pricing.php">Pricing</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <li><a href="services_admin.php">Management Product</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <li><a href="usermanagement.php">Management User</a></li>
        <?php endif; ?>


        <?php if ($role === 'guess'): ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin' || $role === 'user'): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>

        </ul>
    </nav>