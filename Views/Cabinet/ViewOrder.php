<?php include ROOT . '/Views/Layouts/header.php'; ?>


<div id="center" class="column">
    <div id="content">
        <h2>Заказ № <?php echo $id . ' '; ?>пользователя</h2>
        <h3><?php echo $_SESSION['user']['name']; ?></h3>
        <br>
        <table class="container">
            <tr>
                <th>Категория</th>
                <th>Брэнд</th>
                <th>Артикул</th>
                <th>Кол-во</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($result as $order): ?>
                <tr>
                    <td><?php echo $order['singular_category']; ?></td>
                    <td><?php echo $order['brand']; ?></td>
                    <td><?php echo $order['vendor_code']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo number_format($order['price'], 0, '', '&nbsp'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>


<?php include ROOT . '/Views/Layouts/footer.php'; ?>