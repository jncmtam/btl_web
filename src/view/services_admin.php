<?php 
    $this->title = "Services - Company";
    $this->styleSheets = [
        Application::$protocol."://".Application::$server_name."/css/styles.css"
    ];

    $products = isset($this->data["products"]) ? $this->data["products"] : [];
    $productEdit = isset($this->data["productEdit"]) ? $this->data["productEdit"] : null;
    $updateProductForm = isset($this->data["updateProductForm"]) ? $this->data["updateProductForm"] : null;
    $deleteProductForm = isset($this->data["deleteProductForm"]) ? $this->data["deleteProductForm"] : null;
    $message = isset($this->data["message"]) ? $this->data["message"] : null;
?>


<main>

    <!-- Danh sách sản phẩm -->
    <h2>Danh Sách Sản Phẩm</h2>
    <div class="product-list">
        <?php
        // When delete product fails
        if ($deleteProductForm != null && isset($deleteProductForm->errors["delete"])) {
            echo "<span>{$deleteProductForm->errors["delete"]}</span>";
        }
        ?>
        <?php foreach ($products as $product) { ?>
            <div class="product">
                <h3><?php echo $product['name']; ?></h3>
                <p>Giá: <?php echo $product['price']; ?> VND</p>
                <p>Số lượng: <?php echo $product['quantity']; ?></p>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"><br>
                <a href="./../services_admin/edit?edit=<?php echo $product['id']; ?>">Sửa</a> |
                <a href="./../services_admin/delete?delete=<?php echo $product['id']; ?>"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
            </div>
        <?php } ?>
    </div>

    <?php if($productEdit != null){ 
        echo "<h2>Cập nhật Sản Phẩm</h2>";
        echo "<form action='./../services_admin/edit' method='POST'>";
        if($updateProductForm != null) { // Load page with edit mode & validation fails
            // id
            echo "<input type='hidden' name='id' value='{$updateProductForm->id}'>";
            if(isset($updateProductForm->errors["id"])) {
                echo "<span class='validation-error'>{$updateProductForm->errors["id"]}</span>";
            }
            // name
            echo "<label>Tên sản phẩm:</label><br>";
            echo "<input id='name' type='text' name='name' required value='{$updateProductForm->name}'><br>";
            if (isset($updateProductForm->errors["name"])) {
                echo "<span class='validation-error'>{$updateProductForm->errors["name"]}</span>";
            }
            // price
            echo "<label>Giá:</label><br>";
            echo "<input type='number' name='price' required value='{$updateProductForm->price}'><br>";
            if (isset($updateProductForm->errors["price"])) {
                echo "<span class='validation-error'>{$updateProductForm->errors["price"]}</span>";
            }
            // quantity
            echo "<label>Số lượng:</label><br>";
            echo "<input type='number' name='quantity' required value='{$updateProductForm->quantity}'><br>";
            if (isset($updateProductForm->errors["quantity"])) {
                echo "<span class='validation-error'>{$updateProductForm->errors["quantity"]}</span>";
            }
            // image
            echo "<label>Đường dẫn hình ảnh:</label><br>";
            echo "<input type='text' name='image' value='{$updateProductForm->image}'><br><br>";
            if (isset($updateProductForm->errors["image"])) {
                echo "<span class='validation-error'>{$updateProductForm->errors["image"]}</span>";
            }
        } else { // load page with edit mode
            // id
            echo "<input type='hidden' name='id' value='{$productEdit['id']}'>";
            // name
            echo "<label>Tên sản phẩm:</label><br>";
            echo "<input id='name' type='text' name='name' required value='{$productEdit['name']}'><br>";
            // price
            echo "<label>Giá:</label><br>";
            echo "<input type='number' name='price' required value='{$productEdit['price']}'><br>";
            // quantity
            echo "<label>Số lượng:</label><br>";
            echo "<input type='number' name='quantity' required value='{$productEdit['quantity']}'><br>";
            // image
            echo "<label>Đường dẫn hình ảnh:</label><br>";
            echo "<input type='text' name='image' value='{$productEdit['image']}'><br><br>";
        }
        echo "<button type='submit'>Cập nhật Sản Phẩm</button>";
        echo "</form>";
    } else { // load page in normal mode ?>
        <h2>Thêm Sản Phẩm</h2>
        <form action='./../services_admin' method='POST'>
            <input type="hidden" name="id" value="">
            <label>Tên sản phẩm:</label><br>
            <input type="text" name="name" required><br>
            <label>Giá:</label><br>
            <input type="number" name="price" required><br>
            <label>Số lượng:</label><br>
            <input type="number" name="quantity" required><br>
            <label>Đường dẫn hình ảnh:</label><br>

            <input type="text" name="image"><br><br>
            <button type='submit'>Thêm Sản Phẩm</button>
        </form>
    <?php } ?>

    <script>
        window.onload = function () {
            <?php if($productEdit != null): ?>
                document.getElementById('name').focus();
            <?php endif ?>
            <?php if ($message != null) {
                echo "alert('{$message}')";
            } ?>
        }
    </script>

</main>