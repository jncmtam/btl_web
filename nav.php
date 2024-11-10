<nav>
    <ul>
        <li>
            <a href="<?php echo $role === 'admin' ? 'admin.php' : ($role === 'user' ? 'user.php' : 'index.php'); ?>">
                Home
            </a>
        </li>

        <?php if ($role === 'admin' || $role === 'user'): ?>
            <li><a href="profile.php">Profile</a></li>
        <?php endif; ?>

        <?php if ($role === 'guest' || $role === 'user'): ?>
            <li><a href="about.php">About Us</a></li>
        <?php endif; ?>
        
        <?php if ($role === 'guest' || $role === 'user'): ?>
            <li><a href="news.php">News</a></li>
        <?php endif; ?>

        <?php if ($role === 'guest' || $role === 'user'): ?>
            <li><a href="services.php">Services</a></li>
        <?php endif; ?>

        <?php if ($role === 'user'): ?>
            <li><a href="shopping_cart.php">Shopping Cart</a></li>
        <?php endif; ?>

        <?php if ($role === 'user'): ?>
            <li><a href="contact.php">Contact</a></li>
        <?php endif; ?>

        <?php if ($role === 'user'): ?>
            <li><a href="feedback.php">Feedback</a></li>
        <?php endif; ?>

        <?php if ($role === 'user'): ?>
            <li><a href="pricing.php">Pricing</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <li><a href="services_admin.php">Manage Product</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <li><a href="usermanagement.php">Manage User</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <li><a href="news_admin.php">Manage News</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <li><a href="contact_admin.php">Manage Contact</a></li>
        <?php endif; ?>

        <?php if ($role === 'guest'): ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>

        <?php if ($role === 'admin' || $role === 'user'): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>

        </ul>
    </nav>