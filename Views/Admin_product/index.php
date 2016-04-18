<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Управление товарами</title>
    </head>
    <body>
    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="">
                    <ol class="">
                        <li><a href="/admin">Админпанель</a></li>
                        <li class="color">Управление товарами</li>
                    </ol>
                </div>
                <br><br>
                <a href="/admin/product/create" class=""><i class=""></i> Добавить товар</a>
                <br><br>
                <h4>Список товаров</h4>

                <br/>

                <table class="container">
                    <tr>
                        <th>ID</th>
                        <th>Категория</th>
                        <th>Брэнд</th>
                        <th>Артикул</th>
                        <th>Цена</th>
						<th>Описание</th>
                        <th>Фото</th>
                        <th>Арх.</th>
                        <th>Изменить</th>
                        <th>Удалить</th>
                    </tr>
                    <?php foreach ($productsList as $product): ?>
                        <tr>
                            <td><?php echo $product['id_product']; ?></td>
                            <td><?php echo $product['singular_category']; ?></td>
                            <td><?php echo $product['brand']; ?></td>
                            <td><?php echo $product['vendor_code']; ?></td>
                            <td><?php echo $product['price'] ?></td>
							<td><?php echo $product['simple_descrip']; ?></td>
                            <td><?php echo (file_exists(ROOT.'/Template/images/'.$product['id_product'].'_medium.jpg')) ? '+' : '-';?></td>
                            <td><?php echo $product['product_arh']; ?></td>
                            <td><a href="/admin/product/update/<?php echo $product['id_product']; ?>" title="Редактировать">Update</a></td>
                            <td><a href="/admin/product/delete/<?php echo $product['id_product']; ?>" title="Удалить">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php echo $pagination->getPaginationList(); ?>

            </div>
        </div>
    </section>
    </body>
</html>





