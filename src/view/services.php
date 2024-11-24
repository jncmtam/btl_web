<?php
    $this->title = "Services - Company";
    
    $role = $this->data["userRole"];
    $products = [];
    if(isset($this->data["products"])){
        $products = $this->data["products"];
    }
?>

<main>
        <h1>Danh Sách Sản Phẩm</h1>
        <div class="product-list">

        <?php for($i = 0; $i < count($products); $i++) { ?>
            <?php $product = $products[$i]; ?>
            <div class="product">
                <h2><?php echo $product['name']; ?></h2>
                <p>Giá: <?php echo $product['price']; ?> VND</p>
                <p>Số lượng còn lại: <?php echo $product['quantity']; ?></p>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"><br>

                <?php if ($role === 'user'): ?>
                    <form action="services" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="quantity" class="quantity_label">Số lượng:</label>
                        <input type="number" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" value="1" required>
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                <?php endif; ?>
            </div>

        <?php } ?>
    </div>
</main>