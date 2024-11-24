<?php
    $this->title = "News - Company";
    $this->styleSheets = ["./css/styles.css"];
    $this->scripts = [];
    $news = $this->data["news"];
?>

<main>

    <h1>Latest News</h1>
    <section id="news">

        <?php if(count($news) != 0): ?>
            <div class="news-list">
                <?php for($i = 0; $i < count($news); $i++) { ?>
                    <?php $new = $news[$i]; ?>
                    <div class="news-item">
                        <h2><?php echo $new['title']; ?></h2>
                        <p><em>Posted on: <?php echo date('F j, Y, g:i a', strtotime($new['created_at'])); ?></em></p>

                        <?php if ($new['image']): ?>
                            <img src="<?php echo $new['image']; ?>" alt="News Image" class="new-image">
                        <?php endif; ?>

                        <p><?php echo nl2br($new['content']); ?></p>
                    </div>
                <?php }?>
            </div>

        <?php else: ?>
            <p>No news articles available at the moment.</p>
        <?php endif; ?>

    </section>
</main>