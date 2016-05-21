<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Просмотр заказа</title>
    </head>
    <body>
    <section>
        <div class="container">
            <div class="row">
                <br/>
                <div class="">
                    <ol class="">
                        <li><a href="/admin">Админпанель</a></li>
                        <li><a href="/admin/orders">Управление заказами</a></li>
                        <li class="color">Просмотр заказа</li>
                    </ol>
                </div>
                <br>
                <h4>Информация о заказе</h4>
                <br/>
                <table class="container">
                    <tr>
                        <td>ID заказа</td>
                        <td><?php echo $idOrder;?></td>
                    </tr>
                    <tr>
                        <td>Дата заказа</td>
                        <td><?php echo $orderAndUserInfo['date_order'];?></td>
                    </tr>
                    <tr>
                        <td>Сумма заказа</td>
                        <td><?php echo number_format(OrderModel::getTotalAmountOrderByID($idOrder), 0, '', '&nbsp');?></td>
                    </tr>
                    <tr>
                        <td>Клиент</td>
                        <td><?php echo $orderAndUserInfo['name'];?></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><?php echo $orderAndUserInfo['phone'];?></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><?php echo $orderAndUserInfo['email'];?></td>
                    </tr>
                    <tr>
                        <td>Комментарий к заказу</td>
                        <td><?php echo $orderAndUserInfo['comment'];?></td>
                    </tr>
                    <tr>
                        <td>Статус заказа</td>
                        <td><?php echo $orderAndUserInfo['status'];?></td>
                    </tr>
                </table>
                <br>
                <h4>Товар в заказе</h4>
                <br>
                <table>
                    <tr>
                        <th>Категория</th>
                        <th>Брэнд</th>
                        <th>Артикул</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                    </tr>
                    <?php foreach ($productsInOrder as $order): ?>
                        <tr>
                            <td><?php echo $order['singular_category']; ?></td>
                            <td><?php echo $order['brand']; ?></td>
                            <td><?php echo $order['vendor_code']; ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo number_format($order['price'], 0, '', '&nbsp'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>
                <p>
                    <a href="/admin/orders" class="">Назад</a>
                    <a style="float: right;" href="/admin/orders/update/<?php echo $idOrder;?>" class="">Редактировать заказ</a>
                </p>
            </div>
        </div>
    </section>
    </body>
</html>





