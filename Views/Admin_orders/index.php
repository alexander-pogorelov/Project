<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Управление заказами</title>
    </head>
    <body>
    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="">
                    <ol class="">
                        <li><a href="/admin">Админпанель</a></li>
                        <li class="color">Управление заказами</li>
                    </ol>
                </div>
                <br><br>
                <!--<a href="/admin/product/create" class=""><i class=""></i> Добавить товар</a>-->
                <br><br>
                <h4>Список заказов</h4>

                <br/>

                <table class="container">
                    <tr>
                        <th>ID заказа</th>
                        <th>Дата заказа</th>
                        <th>Клиент</th>
                        <th>Авторизация</th>
                        <th>Сумма заказа</th>
                        <th>Статус заказа</th>
						<th>Просмотреть</th>
                        <th>Изменить</th>
                        <th>Удалить</th>
                    </tr>
                    <?php foreach ($ordersList as $order): ?>
                        <tr>
                            <td><a href="/admin/orders/view/<?php echo $order['id_orders']; ?>"><?php echo $order['id_orders']; ?></a></td>
                            <td><?php echo $order['date_order']; ?></td>
                            <td><?php echo $order['name']; ?></td>
                            <td><?php echo(empty($order['email']))? '-' : '+';?></td>
                            <td><?php echo number_format(OrderModel::getTotalAmountOrderByID($order['id_orders']), 0, '', '&nbsp');?></td>
                            <td><?php echo $order['status'] ?></td>
                            <td><a href="/admin/orders/view/<?php echo $order['id_orders']; ?>">View</a></td>
                            <td><a href="/admin/orders/update/<?php echo $order['id_orders']; ?>">Update</a></td>
                            <td><a href="/admin/orders/delete/<?php echo $order['id_orders']; ?>">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php echo $pagination->getPaginationList(); ?>

            </div>
        </div>
    </section>
    </body>
</html>





