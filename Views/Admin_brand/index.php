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
                        <li class="color">Управление брэндами</li>
                    </ol>
                </div>
                <br><br>
                <a href="/admin/brand/create" class=""><i class=""></i> Добавить брэнд</a>
                <br><br>
                <h4>Список брэндов</h4>

                <br/>

                <table class="container">
                    <tr>
                        <th>ID</th>
                        <th>Брэнд</th>
                        <th>Изменить</th>
                        <th>Удалить</th>
                    </tr>
                    <?php foreach ($brandList as $brand): ?>
                        <tr>
                            <td><?php echo $brand['id_brand']; ?></td>
                            <td><?php echo $brand['brand']; ?></td>
                            <td><a href="/admin/brand/update/<?php echo $brand['id_brand']; ?>" title="Редактировать">Update</a></td>
                            <td><a href="/admin/brand/delete/<?php echo $brand['id_brand']; ?>" title="Удалить">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                

            </div>
        </div>
    </section>
    </body>
</html>





