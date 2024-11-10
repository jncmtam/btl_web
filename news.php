<?php
session_start();

// Lấy vai trò người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

include 'db.php'; // Kết nối với database

// Lấy dữ liệu từ bảng news
$sql = "SELECT * FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Services and products page">
    <title>News - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>
    
    <?php include 'nav.php'; ?>

    <main>

        <h1>Latest News</h1>

        <section id="news">
            

            <?php if ($result->num_rows > 0): ?>
                <div class="news-list">
                    <?php while ($news = $result->fetch_assoc()): ?>
                        <div class="news-item">
                            <h2><?php echo $news['title']; ?></h2>
                            <p><em>Posted on: <?php echo date('F j, Y, g:i a', strtotime($news['created_at'])); ?></em></p>

                            <?php if ($news['image']): ?>
                                <img src="<?php echo $news['image']; ?>" alt="News Image" class="news-image">
                            <?php endif; ?>

                            <p><?php echo nl2br($news['content']); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No news articles available at the moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
