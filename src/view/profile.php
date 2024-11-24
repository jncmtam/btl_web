<?php
    $this->title = "User - Profile";
    $user = null;
    if(isset($this->data["user"])) {
        $user = $this->data["user"];
    }

    $updateProfileForm = null;
    if(isset($this->data["updateProfileForm"])){
        $updateProfileForm = $this->data["updateProfileForm"];
    }

    $message = null;
    if(isset($this->data["message"])) {
        $message = $this->data["message"];
    }
?>

<script>
    function enableEditing() {
        // Bỏ thuộc tính readonly để các trường có thể chỉnh sửa
        document.getElementById("email").removeAttribute("readonly");
        document.getElementById("phone").removeAttribute("readonly");
        document.getElementById("new_password").removeAttribute("readonly");
        document.getElementById("confirm_password").removeAttribute("readonly");

        // Chuyển nút "Cập nhật" thành "Lưu"
        document.getElementById("editBtn").style.display = "none";
        document.getElementById("saveBtn").style.display = "inline";
    }
</script>


<main>
    <h1>Thông tin cá nhân</h1>

    <form action="profile" method="POST">
        <!-- username -->
        <label for="username">Username:</label>
        <input type="text" id="username" value="<?php echo $user['username']; ?>" readonly>

        <!-- email -->
        <label for="email">Email:</label>
        <?php 
            if($updateProfileForm != null) {
                echo "<input type='email' id='email' name='email' value='{$updateProfileForm->email}' required>";
                if(isset($updateProfileForm->errors["email"])) {
                    echo "<span class='validation-error'>{$updateProfileForm->errors['email']}</span>";
                }
            } else {
                echo "<input type='email' id='email' name='email' value='{$user['email']}' readonly required>";
            }
        ?>

        <!-- phone -->
        <label for="phone">Phone:</label>
        <?php
            if ($updateProfileForm != null) {
                echo "<input type='text' id='phone' name='phone' value='{$updateProfileForm->phone}'>";
                if (isset($updateProfileForm->errors["phone"])) {
                    echo "<span class='validation-error'>{$updateProfileForm->errors['phone']}</span>";
                }
            } else {
                echo "<input type='text' id='phone' name='phone' value='{$user['phone']}' readonly>";
            }
        ?>

        <h3>Thay đổi mật khẩu</h3>
        <!-- new password -->
        <label for="new_password">Mật khẩu mới:</label>
        <input type="password" id="new_password" name="new_password" readonly>

        <!-- confirm password -->
        <label for="confirm_password">Xác nhận mật khẩu mới:</label>
        <?php
            if ($updateProfileForm != null) {
                echo "<input type='password' id='confirm_password' name='confirm_password' value='{$updateProfileForm->confirm_password}'>";
                if (isset($updateProfileForm->errors["confirm_password"])) {
                    echo "<span class='validation-error'>{$updateProfileForm->errors['confirm_password']}</span>";
                }
            } else {
                echo "<input type='password' id='confirm_password' name='confirm_password' readonly>";
            }
        ?>

        <!-- Nút Cập nhật và Lưu -->
        <button type="button" id="editBtn" onclick="enableEditing()">Cập nhật</button>
        <button type="submit" id="saveBtn" style="display: none;">Lưu</button>
    </form>

    <!-- Hiển thị thông báo -->
    <script>
        window.onload = function () {
            <?php 
                if($updateProfileForm != null) {
                    echo "enableEditing()";
                }
                if($message != null) {
                    echo "alert('{$message}')";
                }
            ?>
        }
    </script>

</main>