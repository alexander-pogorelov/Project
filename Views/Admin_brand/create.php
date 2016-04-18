<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Добавление брэнда</title>
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
                            <li class="color">Добавить новый брэнд</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Добавление нового брэнда</h4>

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


                                <p>Брэнд</p>
                                <input type="text" name="newBrand[brand]" placeholder=""
                                       value="<?php if (isset ($data['value']['category'])) echo $data['value']['category'];?>">


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





