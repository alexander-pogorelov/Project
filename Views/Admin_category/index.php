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
                        <li class="color">Управление категориями</li>
                    </ol>
                </div>
                <br><br>
                <a href="/admin/category/create" class=""><i class=""></i> Добавить категорию</a>
                <br><br>
                <h4>Список категорий</h4>

                <br/>

                <table class="container">
                    <tr>
                        <th>ID</th>
                        <th>Категория</th>
                        <th>Префикс</th>
						<th>Сортировка</th>
						<th>Архив</th>
                        <th>Изменить</th>
                        <th>Удалить</th>
                    </tr>
                    <?php foreach ($CategoriesList as $category): ?>
                        <tr>
                            <td><?php echo $category['id_category']; ?></td>
                            <td><?php echo $category['category']; ?></td>
                            <td><?php echo $category['singular_category']; ?></td>
							<td><?php echo $category['category_sort']; ?></td>
							<td><?php echo $category['category_arh']; ?></td>
							
 
                            <td><a href="/admin/category/update/<?php echo $category['id_category']; ?>" title="Редактировать">Update</a></td>
                            <td><a href="/admin/category/delete/<?php echo $category['id_category']; ?>" title="Удалить">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                

            </div>
        </div>
    </section>
    </body>
</html>





