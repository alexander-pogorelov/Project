<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Изменение брэнда</title>
    </head>
    <body>
        <section>
            <div class="container">
                <div class="row">

                    <br/>

                    <div class="">
                        <ol class="">
                            <li><a href="/admin">Админпанель</a></li>
                            <li><a href="/admin/brand">Управление брэндами</a></li>
                            <li class="color">Изменить брэнд</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Изменение брэнда № <?php echo $brandId; ?></h4>

                    <br/>




                    <div class="">
                        <div class="form">
                            <form action="#" method="post">


                                <p>Брэнд</p>
                                <input type="text" name="newBrand[brand]" placeholder=""
                                       value="<?php echo $brandItem['brand'];?>">


                                <br/><br/>

                                <input type="submit" name="update" class="" value="Сохранить">

                                <br/><br/>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </body>
</html>





