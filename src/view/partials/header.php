<?php 
    $role = Application::$session->get('userRole');
    if(!isset($role) || $role == "") {
        $role = "guest";
    }
?>

<header>
    <div class="header-content">
        <div class="logo">
            <img src="<?php echo Application::$protocol . "://" . Application::$server_name . "/images/logo.png" ?>" alt="Company Logo">
        </div>

        <h1 class="company-name" style="color: white;">BK Company</h1>

        <p class="company-info">Best services and products.</p>
    </div>
</header>

<nav>
    <ul>
        <li>
            <a href="<?php echo $role === 'admin' ? Application::$baseUrl.'/admin' : ($role === 'user' ? Application::$baseUrl .'/user' : Application::$baseUrl .'/home'); ?>">
                Home
            </a>
        </li>

        <?php 
            if ($role === 'admin' || $role === 'user') {
                echo "<li><a href='".Application::$baseUrl."/profile'>Profile</a></li>";
            }
            if ($role === 'guest' || $role === 'user') {
                echo "<li><a href='". Application::$baseUrl."/about'>About Us</a></li>";
                echo "<li><a href='". Application::$baseUrl."/news'>News</a></li>";
                echo "<li><a href='". Application::$baseUrl."/services'>Services</a></li>";
            }
            if ($role === 'user') {
                echo "<li><a href='".Application::$baseUrl."/shopping_cart'>Shopping Cart</a></li>";
                echo "<li><a href='".Application::$baseUrl."/contact'>Contact</a></li>";
                echo "<li><a href='".Application::$baseUrl."/feedback'>Feedback</a></li>";
            }
            if ($role === 'admin') {
                echo "<li><a href='".Application::$baseUrl."/services_admin'>Manage Product</a></li>";
                echo "<li><a href='".Application::$baseUrl."/usermanagement'>Manage User</a></li>";
                echo "<li><a href='".Application::$baseUrl."/newsmanagement'>Manage News</a></li>";
                echo "<li><a href='".Application::$baseUrl."/contact_management'>Manage Contact</a></li>";
            }
            if ($role === 'guest') {
                echo "<li><a href='". Application::$baseUrl."/login'>Login</a></li>";
            }
            if ($role === 'admin' || $role === 'user') {
                echo "<li><a href='". Application::$baseUrl."/logout'>Logout</a></li>";
            }
        ?>
    </ul>
</nav>