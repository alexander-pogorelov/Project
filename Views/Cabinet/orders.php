<?php include ROOT. '/Views/Layouts/header.php';?>
	

	<div id="center" class="column">
		<div id="content">	
			<h2>Список заказов пользователя</h2>
            <h3><?php echo $_SESSION['user']['name'];?></h3>
			<br>
			<?php if ($result): ?>
                <table class="container">
                    <tr>
                        <th>ID заказа</th>
                        <th>Дата заказа</th>
                        <th>Сумма заказа</th>
                        <th>Статус заказа</th>
                    </tr>
                    <?php foreach ($result as $order): ?>
                        <tr>
                            <td><a href="/cabinet/order/<?php echo $order['id_orders']; ?>"><?php echo $order['id_orders']; ?></a></td>
                            <td><?php echo $order['date_order']; ?></td>
                            <td><?php echo number_format(OrderModel::getTotalAmountOrderByID($order['id_orders']), 0, '', '&nbsp');?></td>
                            <td><?php echo $order['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
			<?php else: ?>
                <p>У Вас нет заказов.</p>
            <?php endif;?>

		</div>
	</div>	

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	