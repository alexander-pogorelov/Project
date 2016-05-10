<?php include ROOT. '/Views/Layouts/header.php';?>

<div id="container">
    <div id="center" class="column">
        <div id="content">
            <?php if (!$result):?>
                <h2>Оформление заказа.</h2>
                <p>Товаров в корзине: <?php echo $countItemsInCart.'. ';?></p>
                <p>На общую сумму: <?php echo number_format($cartTotalAmount, 0, '', ' ').' б.р.';?></p>

                <form action="#" method="POST">
                    <?php if (UserModel::checkGuest()):?>
                        <p>Клиент: незарегистрированный пользователь.</p>
                        <br>
                        <?php if (count($data['error']) > 0): ?>
                            <ul>
                                <?php foreach ($data['error'] as $error): ?>
                                    <li> - <?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <p class="line"><span class="red">Name:</span> <input type="text" placeholder="Введите Ваше имя" title="<?php echo 'Используйте только буквы, цифры, знак подчеркивания, пробелы. Не менее '.NAME_MIN.' символов.';?>" name="order[name]" value="<?php if (isset ($data['order']['name'])) echo $data['order']['name'];?>" /></p>
                        <br>
                        <p class="line"><span class="red">Phone:</span> <input type="text" placeholder="Введите Ваш телефон" title="<?php echo 'Используйте только цифры. Не менее '.PHONE_MIN.' символов.';?>" name="order[phone]" value="<?php if (isset ($data['order']['phone'])) echo $data['order']['phone'];?>" /></p>
                        <br>
                    <?php else:?>
                        <p>Клиент: <?php echo $_SESSION['user']['name']?>.</p>
                    <?php endif;?>
                    <br>
                    <p class="line"><span class="">Comment:</span></p>
                    <textarea name="order[comment]" placeholder="Введите комментарий к заказу" title="Комментарий к заказу. Тэги запрещены" cols="40" rows="4"><?php if (isset ($data['order']['comment'])) echo $data['order']['comment'];?></textarea>
                    <br>
                    <button name="order_button" type="submit"> <img src="/Template/images/enter.gif" width="69" height="25"> </button>
                </form>
            <?php else: ?>
                <p>Ваш заказ успешно отправлен!</p>
            <?php endif;?>
        </div>
    </div>
    <div id="left" class="column">
        <div class="block">
            <img src="/Template/images/title1.gif" alt="" width="168" height="42" /><br />
            <?php include ROOT. '/Views/Layouts/navigation.php';?>
        </div>
        <a href="#"><img src="/Template/images/banner1.jpg" alt="" width="172" height="200" /></a>
    </div>
</div>

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	