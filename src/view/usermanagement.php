<?php
    $this->title = "User management";
    $users = isset($this->data["users"]) ? $this->data["users"] : [];
    $message = isset($this->data["message"]) ? $this->data["message"] : null;
    $userForEdit = isset($this->data["userForEdit"]) ? $this->data["userForEdit"] : null;
    $updateUserForm = isset($this->data["updateUserForm"]) ? $this->data["updateUserForm"] : null;
?>

<script>
    function showEditForm() {
        document.getElementById('editForm').style.display = 'block';
    }
    
    function hideEditForm() {
        document.getElementById('editForm').style.display = 'none';
    }
</script>

<main>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($users) != 0){
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['username'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . $user['phone'] . "</td>";
                    echo "<td>
                                <a href='usermanagement_edit?edit_id=" . $user['id'] . "' onclick='showEditForm()'>Sửa</a>   
                                <a href='usermanagement_delete?delete_id=" . $user['id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này không?\")'>Xóa</a>
                            </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có người dùng nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Form sửa người dùng nếu có -->
    <div id="editForm" style="display: <?php echo isset($userForEdit) ? 'block' : 'none'; ?>;">
        <h2>Sửa thông tin người dùng</h2>
        <form action="usermanagement_edit" method="POST">
            <input type="hidden" name="user_id" value="<?php echo isset($userForEdit) ? $userForEdit['id'] : ''; ?>">
            <label for="username">Tên người dùng:</label>
            <input type="text" name="username" id="username"
                value="<?php echo isset($userForEdit) ? $userForEdit['username'] : ''; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo isset($userForEdit) ? $userForEdit['email'] : ''; ?>"
                required>
            <br>
            <label for="phone">Điện thoại:</label>
            <input type="text" name="phone" id="phone" value="<?php echo isset($userForEdit) ? $userForEdit['phone'] : ''; ?>"
                required>
            <br>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="submit" name="update_user" value="Cập nhật người dùng">
            <button type="button" onclick="hideEditForm()">Hủy</button>
        </form>
    </div>
    <div id="editForm" style="display: <?php echo isset($updateUserForm) ? 'block' : 'none'; ?>;">
        <h2>Sửa thông tin người dùng</h2>
        <form action="usermanagement_edit" method="POST">
            <input type="hidden" name="user_id" value="<?php echo isset($updateUserForm) ? $updateUserForm->id : ''; ?>">
            <label for="username">Tên người dùng:</label>
            <input type="text" name="username" id="username"
                value="<?php echo isset($updateUserForm) ? $updateUserForm->username : ''; ?>" required>
            <?php if(isset($updateUserForm->errors["username"])) {
                echo "<span class='validation-error'>{$updateUserForm->errors["username"]}</span>";
            } ?>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"
                value="<?php echo isset($updateUserForm) ? $updateUserForm->email : ''; ?>" required>
            <?php if (isset($updateUserForm->errors["email"])) {
                echo "<span class='validation-error'>{$updateUserForm->errors["email"]}</span>";
            } ?>
            <br>
            <label for="phone">Điện thoại:</label>
            <input type="text" name="phone" id="phone"
                value="<?php echo isset($updateUserForm) ? $updateUserForm->phone : ''; ?>" required>
            <?php if (isset($updateUserForm->errors["phone"])) {
                echo "<span class='validation-error'>{$updateUserForm->errors["phone"]}</span>";
            } ?>
            <br>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
            <?php if (isset($updateUserForm->errors["password"])) {
                echo "<span class='validation-error'>{$updateUserForm->errors["password"]}</span>";
            } ?>
            <br>
            <input type="submit" name="update_user" value="Cập nhật người dùng">
            <button type="button" onclick="hideEditForm()">Hủy</button>
        </form>
    </div>

    <!-- Form thêm người dùng -->
    <h2>Thêm người dùng mới</h2>
    <form action="" method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="phone">Điện thoại:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" name="add_user" value="Thêm người dùng">
    </form>

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