<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Изменение товара</title>
    </head>
    <body>

            <div class="container">
                <div class="row">

                    <br/>


                    <div class="">
                        <ol class="">
                            <li><a href="/admin">Админпанель</a></li>
                            <li><a href="/admin/product">Управление товарами</a></li>
                            <li class="color">Изменить товар</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Изменение товара № <?php echo $idProduct; ?></h4>

                    <br/>

                   


                    <div class="">
                        <div class="form">
                            <form action="#" method="post" enctype="multipart/form-data">

                                <p>Категория</p>


                                <select name="newProduct[id_category]">

                                    <?php if (is_array($categoriesList)): ?>
                                        <?php foreach ($categoriesList as $category): ?>
                                            <option value="<?php echo $category['id_category']; ?>"
                                                <?php if ($category['id_category']==$productItem['id_category']) echo " selected";?>>
                                                <?php echo $category['category']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <option value=""></option>
                                </select>

                                <p>Производитель</p>
                                <select name="newProduct[id_brand]">
                                    <?php if (is_array($brandList)): ?>
                                        <?php foreach ($brandList as $brand): ?>
                                            <option value="<?php echo $brand['id_brand']; ?>"
                                            <?php if ($brand['id_brand']==$productItem['id_brand']) echo " selected";?>>
                                                <?php echo $brand['brand']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <option value=""></option>
                                </select>

                                <p>Артикул</p>
                                <input type="text" name="newProduct[vendor_code]" size ="40" placeholder=""
                                       value="<?php echo $productItem['vendor_code'];?>">

                                <p>Цена товара, BYR</p>
                                <input type="text" name="newProduct[price]" placeholder=""
                                       value="<?php echo $productItem['price'];?>">



                                <br/><br/><br/>




								
								 <p>URL изображения товара</p>
                                <input type="text" name="newProduct[url]" size="70" placeholder="" value="">

                                <p>Краткое описание</p>
                                <textarea name="newProduct[simple_descrip]" cols="40" rows="5"><?php echo $productItem['simple_descrip'];?></textarea>

                                <br/>

                                <p>Архивный товар</p>
                                <select name="newProduct[product_arh]">
                                    <option value="1" <?php if ($productItem['product_arh']==1) echo "selected";?>>Да</option>
                                    <option value="0" <?php if ($productItem['product_arh']==0) echo "selected";?>>Нет</option>
                                </select>

                                <br/><br/>







                                <input type="submit" name="update" class="" value="Сохранить изменения">

                                <br/><br/>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

    </body>
</html>





