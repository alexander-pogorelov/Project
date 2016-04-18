<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Удаление категории</title>
    </head>
    <body>
        <section>
            <div class="container">
                <div class="row">

                    <br/>

                    <div class="">
                        <ol class="">
                            <li><a href="/admin">Админпанель</a></li>
                            <li><a href="/admin/category">Управление категориями</a></li>
                            <li class="color">Удалить категорию</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Удаление категории №<?php echo $categoryId; ?></h4>

                    <br>
                    <p>Вы действительно хотите удалить эту категорию товара?</p>


                    <form method="post">
                        <input type="submit" name="delete" value="Удалить" />
                    </form>

                </div>
            </div>
        </section>
    </body>
</html>





