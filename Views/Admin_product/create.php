<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Добавление товара</title>
    </head>
    <body>
        <section>
            <div class="container">
                <div class="row">

                    <br/>

                    <div class="">
                        <ol class="">
                            <li><a href="/admin">Админпанель</a></li>
                            <li><a href="/admin/product">Управление товарами</a></li>
                            <li class="color">Добавить товар</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Добавление нового товара</h4>

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


                                <select name="newProduct[id_category]">
                                    <?php if (!isset($data['value']['id_category'])) $data['value']['id_category']="";?>
                                    <?php if (is_array($categoriesList)): ?>
                                        <?php foreach ($categoriesList as $category): ?>

                                            <option value="<?php echo $category['id_category']; ?>"
                                                <?php if ($category['id_category']==$data['value']['id_category']) echo " selected";?>>
                                                <?php echo $category['category']; ?>
                                            </option>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <option value="" <?php if ($data['value']['id_category']=="" ) echo " selected";?>></option>
                                </select>

                                <p>Производитель</p>
                                <select name="newProduct[id_brand]">
                                    <?php if (!isset($data['value']['id_brand'])) $data['value']['id_brand']="";?>
                                    <?php if (is_array($brandList)): ?>
                                        <?php foreach ($brandList as $brand): ?>

                                            <option value="<?php echo $brand['id_brand']; ?>"
                                            <?php if ($brand['id_brand']==$data['value']['id_brand']) echo " selected";?>>
                                                <?php echo $brand['brand']; ?>
                                            </option>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <option value="" <?php if ($data['value']['id_brand']=="" ) echo " selected";?>></option>
                                </select>

                                <p>Артикул</p>
                                <input type="text" name="newProduct[vendor_code]" size="40" placeholder=""
                                       value="<?php if (isset ($data['value']['vendor_code'])) echo $data['value']['vendor_code'];?>">

                                <p>Цена товара, BYR</p>
                                <input type="text" name="newProduct[price]" placeholder=""
                                       value="<?php if (!empty ($data['value']['price'])) echo $data['value']['price'];?>">



                                <br/><br/><br/>




								
								 <p>URL изображения товара</p>
                                <input type="text" name="newProduct[url]" size="70" placeholder="" value="<?php if (!empty ($data['value']['url'])) echo $data['value']['url'];?>">

                                <p>Краткое описание</p>
                                <textarea name="newProduct[simple_descrip]" cols="40" rows="5"><?php if (!empty ($data['value']['simple_descrip'])) echo $data['value']['simple_descrip'];?></textarea>

                                <br/>

                                <p>Архивный товар</p>
                                <select name="newProduct[product_arh]">
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





