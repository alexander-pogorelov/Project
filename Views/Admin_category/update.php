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
                            <li class="color">Изменить категорию товара</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Изменение категории товара № <?php echo "$categoryId";?></h4>

                    <br/>


                    <div class="">
                        <div class="form">
                            <form action="#" method="post">


                                <p>Категория</p>
                                <input type="text" name="newCategory[category]" placeholder=""
                                       value="<?php echo $categoryItem['category'];?>">

                                <p>Префикс категории</p>
                                <input type="text" name="newCategory[singular_category]" placeholder=""
                                       value="<?php echo $categoryItem['singular_category'];?>">

                                <br/><br/>
									 
                                <p>Порядковый номер в сортировке</p>
                                <input type="text" name="newCategory[category_sort]" placeholder=""
                                       value="<?php echo $categoryItem['category_sort'];?>">

                                <br/><br/>

                                <p>Архивная категория</p>
                                <select name="newCategory[category_arh]">
                                    <option value="1" <?php if ($categoryItem['category_arh']==1) echo "selected";?>>Да</option>
                                    <option value="0" <?php if ($categoryItem['category_arh']==0) echo "selected";?>>Нет</option>
                                </select>

                                <br/><br/>

                                <input type="submit" name="update" class="" value="Сохранить изменения">

                                <br/><br/>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </body>
</html>





