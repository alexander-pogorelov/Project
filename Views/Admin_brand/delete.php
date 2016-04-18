<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css" />
        <title>Удаление брэнда</title>
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
                            <li class="color">Удалить брэнд</li>
                        </ol>
                    </div>

                    <br>
                    <h4>Удаление брэнда №<?php echo $brandId; ?></h4>

                    <br>
                    <p>Вы действительно хотите удалить этот брэнд?</p>


                    <form method="post">
                        <input type="submit" name="delete" value="Удалить" />
                    </form>

                </div>
            </div>
        </section>
    </body>
</html>





