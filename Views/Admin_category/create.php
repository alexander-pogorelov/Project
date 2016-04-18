<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Добавление категории товара</title>
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
                            <li class="color">Добавить категорию товара</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Добавление новой категории товара</h4>

                    <br/>

                    <?php if (count($data['error']) > 0): ?>
                        <ul>
                            <?php foreach ($data['error'] as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <br><hr><br>
                    <?php endif; ?>


                    <div class="">
                        <div class="form">
                            <form action="#" method="post" enctype="multipart/form-data">


                                <p>Категория</p>
                                <input type="text" name="newCategory[category]" placeholder=""
                                       value="<?php if (isset ($data['value']['category'])) echo $data['value']['category'];?>">

                                <p>Префикс категории</p>
                                <input type="text" name="newCategory[singular_category]" placeholder=""
                                       value="<?php if (isset ($data['value']['singular_category'])) echo $data['value']['singular_category'];?>">

                                <br/><br/>
									 
                                <p>Порядковый номер в сортировке</p>
                                <input type="text" name="newCategory[category_sort]" placeholder=""
                                       value="<?php if (isset ($data['value']['category_sort'])) echo $data['value']['category_sort'];?>">

                                <br/><br/>

                                <p>Архивная категория</p>
                                <select name="newCategory[category_arh]">
                                    <option value="1" >Да</option>
                                    <option value="0" selected>Нет</option>
                                </select>

                                <br/><br/>

                                <input type="submit" name="create" class="" value="Сохранить">

                                <br/><br/>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </body>
</html>





