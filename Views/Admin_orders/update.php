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
                        <li class="color">Изменение заказа</li>
                    </ol>
                </div>
                <br>
                <h4>Редактирование заказа №<?php echo ' '.$idOrder;?></h4>
                <br/>
                <div class="form">
                    <form action="#" method="post">
                        <p>Дата заказа</p>
                        <input type="text" name="updateOrder[date_order]" placeholder=""
                               value="<?php echo $orderAndUserInfo['date_order'];?>">
                        <br>
                        <?php if (empty($orderAndUserInfo['email'])): ?>
                            <p>Клиент</p>
                            <input type="text" name="updateOrder[name]" placeholder=""
                                   value="<?php echo $orderAndUserInfo['name'];?>">
                            <br>
                            <p>Телефон</p>
                            <input type="text" name="updateOrder[phone]" placeholder=""
                                   value="<?php echo $orderAndUserInfo['phone'];?>">
                            <br>
                        <?php endif; ?>
                        <p>Комментарий к заказу</p>
                        <textarea name="updateOrder[comment]" cols="40" rows="4"><?php echo $orderAndUserInfo['comment'];?></textarea>
                        <p>Статус заказа</p>
                        <select name="updateOrder[status]">
                            <?php foreach ($orderStatusList as $item => $value): ?>
                                <option value="<?php echo $item;?>"<?php if ($orderAndUserInfo['status']==$value) echo "selected";?>><?php echo $value;?></option>
                            <?php endforeach;?>
                        </select>
                        <br><br>
                        <input type="submit" name="orderUpdate" class="" value="Сохранить изменения">
                    </form>
                </div>
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
                <a href="/admin/orders" class="">Назад</a>
            </div>
        </div>
    </section>
    </body>
</html>





