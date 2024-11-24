<?php
    $this->title = "Shoppig cart - Company";
    $cartData = null;
    if(isset($this->data["cartData"])) {
        $cartData = $this->data["cartData"];
    }
    $total = 0;
?>

<main>
    <h1>Your Shopping Cart</h1>

    <div class="cart">
        <?php if (count($cartData) > 0): ?>
            <table class="styled-table">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cartData as $cartItem):
                    $product = $cartItem["product"];
                    $itemTotal = $product['price'] * $cartItem['quantity'];
                    $total += $itemTotal;    
                ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?> VND</td>
                        <td><?php echo $cartItem['quantity']; ?></td>
                        <td><?php echo $itemTotal; ?> VND</td>
                        <td>
                            <form action="shopping_cart" method="POST">
                                <input type="hidden" name="remove_product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td><?php echo $total; ?> VND</td>
                    <td>
                        <button type="button" onclick="alert('Proceed to checkout');">Mua hàng</button>
                    </td>
                </tr>
            </table>

        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>
    </div>

</main>