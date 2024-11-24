<?php
    $this->title = "Contact - Company";
    $contactForm = null;
    if(isset($this->data["contactForm"])) {
        $contactForm = $this->data["contactForm"];
    }
    $message = null;
    if(isset($this->data["message"])){
        $message = $this->data["message"];
    }
?>

<main>
    <section id="contact">
        <h1>Contact Us</h1>
        <form action="contact" method="POST">
            <label for="name">Name:</label>
            <?php
                if($contactForm != null) {
                    echo "<input type='text' id='name' name='name' value='{$contactForm->name}' required>";
                    if(isset($contactForm->errors["name"])) {
                        echo "<span class='validation-error'>{$contactForm->errors["name"]}</span>";
                    }
                } else {
                    echo "<input type='text' id='name' name='name' required>";
                }
            ?>
            
            <label for="email">Email:</label>
            <?php
                if ($contactForm != null) {
                    echo "<input type='email' id='email' name='email' value='{$contactForm->email}' required>";
                    if (isset($contactForm->errors["email"])) {
                        echo "<span class='validation-error'>{$contactForm->errors["email"]}</span>";
                    }
                } else {
                    echo "<input type='email' id='email' name='email' required>";
                }
            ?>
        
            <label for="message">Message:</label>
            <?php
                if ($contactForm != null) {
                    echo "<textarea id='message' name='message' required>{$contactForm->message}</textarea>";
                    if (isset($contactForm->errors["message"])) {
                        echo "<span class='validation-error'>{$contactForm->errors["message"]}</span>";
                    }
                } else {
                    echo "<textarea id='message' name='message' required></textarea>";
                }
            ?>
            
            <button type="submit" name="submit">Send Message</button>
        </form>
    </section>
    <!-- Hiển thị thông báo -->
    <script>
    window.onload = function () {
        <?php
            if ($message != null) {
                echo "alert('{$message}')";
            }
        ?>
    }
    </script>
</main>

