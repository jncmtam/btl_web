<?php
    $this->title = "Register - Company";
    $this->styleSheets = ["./css/styles.css"];
    $this->scripts = [];
    $registerForm = null;
    if(isset($this->data["registerForm"])){
        $registerForm = $this->data["registerForm"];
    }
?>

<main>
    <section id="register">
        <h1>Register</h1>
        <form action="/register" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required
            <?php
                if(isset($registerForm->username)){
                    echo "value='".$registerForm->username."'";
                }
            ?>
            >
            <?php
                if (isset($registerForm->errors["username"])) {
                    echo "<span class='validation-error'>".$registerForm->errors["username"]."</span>";
                }
            ?>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required
            <?php
            if (isset($registerForm->password)) {
                echo "value='" . $registerForm->password . "'";
            }
            ?>
            >
            <?php
            if (isset($registerForm->errors["password"])) {
                echo "<span class='validation-error'>" . $registerForm->errors["password"] . "</span>";
            }
            ?>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required
            <?php
            if (isset($registerForm->email)) {
                echo "value='" . $registerForm->email . "'";
            }
            ?>
            >
            <?php
            if (isset($registerForm->errors["email"])) {
                echo "<span class='validation-error'>" . $registerForm->errors["email"] . "</span>";
            }
            ?>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required
            <?php
            if (isset($registerForm->phone)) {
                echo "value='" . $registerForm->phone . "'";
            }
            ?>
            >
            <?php
            if (isset($registerForm->errors["phone"])) {
                echo "<span class='validation-error'>" . $registerForm->errors["phone"] . "</span>";
            }
            ?>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login">Login</a>.</p>
    </section>
</main>