<?php include ROOT. '/Views/Layouts/header.php';?>

<div id="container">
    <div id="center" class="column">
        <div id="content">
            <h2>Корзина товаров</h2>
            <!--<h3><?php echo $_SESSION['user']['name'];?></h3>-->
            <br>
			<?php if (isset ($productsFromCart)): ?>
				<p>Товары в корзине:</p>
				
				<table class="container">
                    <tr>
                        <th>ID</th>
                        <th>Категория</th>
                        <th>Брэнд</th>
                        <th>Артикул</th>
                        <th>Цена</th>	
						<th>Кол-во</th>
						<th>Сумма</th>
						<th>Удалить</th>

                    </tr>
					<?php foreach ($productsFromCart as $product): ?>
						<tr>
                            <td><?php echo $product['id_product']; ?></td>
                            <td><?php echo $product['singular_category']; ?></td>
                            <td><?php echo $product['brand']; ?></td>
                            <td><?php echo $product['vendor_code']; ?></td>
                            <td><?php echo number_format($product['price'], 0, '', '&nbsp') ?></td>
							<td><?php echo $_SESSION['cart'][$product['id_product']] ?></td>
							<td><?php echo number_format($product['price']*$_SESSION['cart'][$product['id_product']], 0, '', ' ') ?></td>	
							<td><a href="/cart/delete/<?php echo $product['id_product'];?>">Delete</a></td>	
                        </tr>
                    <?php endforeach; ?>
					<tr>
						<td colspan="6" style="text-align: left">Итого</td>
						<td><?php echo number_format($cartTotalAmount, 0, '', '&nbsp') ?></td>
						<td></td>	
					</tr>
				</table>
				<br>
				<?php if (isset($_SESSION['user'])): ?>
				<p><a href="/cart/checkout">Оформить заказ</a>
				<?php else: ?>
				<p><a href="/cart/checkout">Оформить заказ без регистрации</a><a style="float: right;" href="/user/login">Регистрация на сайте</a></p>
				<?php endif;?>	
			<?php else: ?>
				<p>Корзина пустая</p>
			<?php endif;?>

        </div>
    </div>
    <div id="left" class="column">
        <div class="block">
            <img src="/Template/images/title1.gif" alt="" width="168" height="42" /><br />
            <?php include ROOT. '/Views/Layouts/navigation.php';?>
        </div>
        <a href="#"><img src="/Template/images/banner1.jpg" alt="" width="172" height="200" /></a>
    </div>

</div>

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	