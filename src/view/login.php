<?php
    $this->title = "Login - Company";
    $this->styleSheets = ["./css/styles.css"];
    $this->scripts = [];
    $loginForm = null;
    if (isset($this->data["loginForm"])) {
        $loginForm = $this->data["loginForm"];
    }
?>

<main>
    <section id="login">
        <h1>Login</h1>
        <form action="/login" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required
            <?php
            if (isset($loginForm->username)) {
                echo "value='" . $loginForm->username . "'";
            }
            ?>
            >
            <?php
            if (isset($loginForm->errors["username"])) {
                echo "<span class='validation-error'>" . $loginForm->errors["username"] . "</span>";
            }
            ?>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <?php
            if (isset($loginForm->errors["password"])) {
                echo "<span class='validation-error'>" . $loginForm->errors["password"] . "</span>";
            }
            ?>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register">Register</a>.</p>
    </section>
</main>

<?php
$message = Application::$session->getFlashMessage("registerMessage");
if ($message !== false) {
    echo "<script>alert('" . $message . "')</script>";
}
$message = Application::$session->getFlashMessage("loginMessage");
if ($message !== false) {
    echo "<script>alert('" . $message . "')</script>";
}

?>