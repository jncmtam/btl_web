<?php
    $this->title = "Admin - Manage contacts";
    $contacts = isset($this->data["contacts"]) ? $this->data["contacts"] : [];
    $message = isset($this->data["message"]) ? $this->data["message"] : null;
?>

<main>
    <h1>Manage Contact</h1>
    <table class="styled-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach($contacts as $contact) { ?>
            <tr>
                <td><?= htmlspecialchars($contact['id']) ?></td>
                <td><?= htmlspecialchars($contact['name']) ?></td>
                <td><?= htmlspecialchars($contact['email']) ?></td>
                <td><?= htmlspecialchars($contact['message']) ?></td>
                <td><?= htmlspecialchars($contact['created_at']) ?></td>
                <td>
                    <form method="POST" action="delete_contact" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phản hồi này không?');">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($contact['id']) ?>">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <script>
        <?php if($message != null) {
            echo "alert('{$message}')";
        } ?>
    </script>
</main>