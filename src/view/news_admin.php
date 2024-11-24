<?php 
    $this->title = "Manage News - Admin";

    $newsList = isset($this->data["newsList"]) ? $this->data["newsList"] : [];
    $addNewsForm = isset($this->data["addNewsForm"]) ? $this->data["addNewsForm"] : null;
    $updateNewsForm = isset($this->data["updateNewsForm"]) ? $this->data["updateNewsForm"] : null;
    $message = isset($this->data["message"]) ? $this->data["message"] : null;
?>

<main>
    <h1>Quản lý Tin Tức</h1>

    <?php if (count($newsList) > 0): ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Ngày tạo</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newsList as $row) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo substr($row['content'], 0, 100) . '...'; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="<?php echo $row['image']; ?>" alt="Hình ảnh tin tức" width="100">
                            <?php else: ?>
                                <span>Không có hình ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Nút Sửa -->
                            <button class="edit-btn" data-id="<?php echo $row['id']; ?>"
                                data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                data-content="<?php echo htmlspecialchars($row['content']); ?>"
                                data-image="<?php echo $row['image']; ?>">Sửa</button>
                    
                            <!-- Nút Xóa -->
                            <a href="deleteNews?delete_id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">Xóa</a>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    <?php else: ?>
        <p>Hiện không có bài viết nào.</p>
    <?php endif; ?>

    <!-- Nút Thêm bài viết mới -->
    <button id="add-news-btn">Thêm bài viết mới</button>
    <div id="add-news-form" style="display: none;">
        <h2>Thêm Bài Viết</h2>
        <form action="addNews" method="POST">
            <?php if($addNewsForm != null) {
                echo "<label for='title'>Tiêu đề:</label>";
                echo "<input type='text' name='title' required value='{$addNewsForm->title}'>";
                if(isset($addNewsForm->errors["title"])) {
                    echo "<span class='validation-error'>{$addNewsForm->errors["title"]}</span>";
                }

                echo "<label for='content'>Nội dung:</label>";
                echo "<textarea name='content' required>{$addNewsForm->content}</textarea>";
                if (isset($addNewsForm->errors["content"])) {
                    echo "<span class='validation-error'>{$addNewsForm->errors["content"]}</span>";
                }

                echo "<label for='image'>Đường dẫn hình ảnh (tùy chọn):</label>";
                echo "<input type='text' name='image' value='{$addNewsForm->image}'>";
                if (isset($addNewsForm->errors["image"])) {
                    echo "<span class='validation-error'>{$addNewsForm->errors["image"]}</span>";
                }
            } else { ?>
                <label for="title">Tiêu đề:</label>
                <input type="text" name="title" required>

                <label for="content">Nội dung:</label>
                <textarea name="content" required></textarea>

                <label for="image">Đường dẫn hình ảnh (tùy chọn):</label>
                <input type="text" name="image">
            <?php } ?>
            
            <button type="submit" name="add_news">Thêm bài viết</button>
        </form>
    </div>

    <div id="edit-news-form" style="display: none;">
        <h2>Chỉnh Sửa Bài Viết</h2>
        <form action="updateNews" method="POST">
            <?php if($updateNewsForm != null) {
                echo "<input type='hidden' name='id' id='edit-id' value='{$updateNewsForm->id}'>";
                echo "<label for='title'>Tiêu đề:</label>";
                echo "<input type='text' name='title' id='edit-title' required value='{$updateNewsForm->title}'>";
                if(isset($updateNewsForm->errors["title"])) {
                    echo "<span class='validation-error'>{$updateNewsForm->errors["title"]}</span>";
                }

                echo "<label for='content'>Nội dung:</label>";
                echo "<textarea name='content' id='edit-content' required>{$updateNewsForm->content}</textarea>";
                if (isset($updateNewsForm->errors["content"])) {
                    echo "<span class='validation-error'>{$updateNewsForm->errors["content"]}</span>";
                }

                echo "<label for='image'>Đường dẫn hình ảnh (tùy chọn):</label>";
                echo "<input type='text' name='image' id='edit-image' value={$updateNewsForm->image}>";
                if (isset($updateNewsForm->errors["image"])) {
                    echo "<span class='validation-error'>{$updateNewsForm->errors["image"]}</span>";
                }
            } else { ?>
                <input type="hidden" name="id" id="edit-id">
                <label for="title">Tiêu đề:</label>
                <input type="text" name="title" id="edit-title" required>

                <label for="content">Nội dung:</label>
                <textarea name="content" id="edit-content" required></textarea>

                <label for="image">Đường dẫn hình ảnh (tùy chọn):</label>
                <input type="text" name="image" id="edit-image">
            <?php } ?>
            
            <button type="submit" name="edit_news">Cập nhật bài viết</button>
        </form>
    </div>
</main>

<script>
    // Hiển thị form thêm bài viết
    document.getElementById('add-news-btn').addEventListener('click', function() {
        var form = document.getElementById('add-news-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // Hiển thị form chỉnh sửa bài viết
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');
            var content = this.getAttribute('data-content');
            var image = this.getAttribute('data-image') || ''; 

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-content').value = content;
            document.getElementById('edit-image').value = image;

            document.getElementById('edit-news-form').style.display = 'block';
        });
    });
</script>

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