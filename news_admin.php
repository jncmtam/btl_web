<?php
session_start();
include 'db.php'; // Kết nối với database

// Kiểm tra vai trò người dùng
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Chuyển hướng nếu không phải admin
    exit;
}

$role = $_SESSION['role'];

// Xử lý xóa bài viết
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM news WHERE id = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Xóa bài viết thành công!'); window.location.href = 'news_admin.php';  </script>";
    } else {
        echo "<script> alert('Lỗi khi xóa bài viết!". $conn->error."');  window.location.href = 'news_admin.php';  </script>";
    }
}

// Xử lý thêm bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = !empty($_POST['image']) ? $_POST['image'] : null; // Nếu không có hình ảnh, để null

    // Thêm bài viết vào cơ sở dữ liệu
    $sql_add = "INSERT INTO news (title, content, image) VALUES ('$title', '$content', '$image')";
    if ($conn->query($sql_add) === TRUE) {
        echo "<script> alert('Bài viết đã được thêm!'); window.location.href = 'news_admin.php';  </script>";
    } else {
        echo "<script> alert('Phản hồi của bạn đã được gửi thành công!". $conn->error."');  window.location.href = 'news_admin.php';  </script>";
    }
}

// Xử lý chỉnh sửa bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_news'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = !empty($_POST['image']) ? $_POST['image'] : null; // Nếu không có hình ảnh, để null

    // Cập nhật bài viết
    $sql_update = "UPDATE news SET title = '$title', content = '$content', image = '$image' WHERE id = $id";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script> alert('Bài viết đã được cập nhât!'); window.location.href = 'news_admin.php';  </script>";

    } else {
        echo "<script> alert('Lỗi khi cập nhật bài viết!". $conn->error."'); window.location.href = 'news_admin.php';  </script>" ;
    }
}

// Lấy tất cả bài viết từ bảng news
$sql = "SELECT * FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage News page">
    <title>Manage News - Admin</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>

    <main>
        <h1>Quản lý Tin Tức</h1>

        <?php if ($result->num_rows > 0): ?>
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
                    <?php while ($row = $result->fetch_assoc()): ?>
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
                                <button class="edit-btn" data-id="<?php echo $row['id'];?>" 
                                                        data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                                        data-content="<?php echo htmlspecialchars($row['content']); ?>"
                                                        data-image="<?php echo $row['image']; ?>">Sửa</button>

                                <!-- Nút Xóa -->
                                <a href="news_admin.php?delete_id=<?php echo $row['id']; ?>" 
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Hiện không có bài viết nào.</p>
        <?php endif; ?>

        <!-- Nút Thêm bài viết mới -->
        <button id="add-news-btn">Thêm bài viết mới</button>
            <div id="add-news-form" style="display: none;">
                <h2>Thêm Bài Viết</h2>
                <form action="news_admin.php" method="POST">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" name="title" required>

                    <label for="content">Nội dung:</label>
                    <textarea name="content" required></textarea>

                    <label for="image">Đường dẫn hình ảnh (tùy chọn):</label>
                    <input type="text" name="image">

                    <button type="submit" name="add_news">Thêm bài viết</button>
                </form>
        </div>

        <div id="edit-news-form" style="display: none;">
        <h2>Chỉnh Sửa Bài Viết</h2>
        <form action="news_admin.php" method="POST">
            <input type="hidden" name="id" id="edit-id">
            <label for="title">Tiêu đề:</label>
            <input type="text" name="title" id="edit-title" required>

            <label for="content">Nội dung:</label>
            <textarea name="content" id="edit-content" required></textarea>

            <label for="image">Đường dẫn hình ảnh (tùy chọn):</label>
            <input type="text" name="image" id="edit-image">

            <button type="submit" name="edit_news">Cập nhật bài viết</button>
        </form>
    </div>
    </main>

    

    <?php include 'footer.php'; ?>

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

</body>
</html>

<?php $conn->close(); ?>
