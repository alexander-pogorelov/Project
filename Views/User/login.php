<?php include ROOT. '/Views/Layouts/header.php';?>

<div id="center" class="column">
    <div id="content">
        <img src="/Template/images/title4.gif" alt="" width="218" height="29" /><br />
        <?php if (count($data['error']) > 0): ?>
        <ul>
            <?php foreach ($data['error'] as $error): ?>
            <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <div class="blocks">
            <h3>Авторизация на сайте</h3>
            <br>
            <form action="#" method="POST">
                <p class="line"><span>E-mail:</span> <input type="email" placeholder="Введите Ваш e-mail" title="Введите свой e-mail" name="user[email]" value="<?php if (isset ($data['user']['email'])) echo $data['user']['email'];?>"/></p>
                <p class="line"><span>Password:</span> <input type="password" placeholder="Введите Ваш пароль" name="user[password]" title="<?php echo 'Используйте только английские буквы, цифры и знак подчеркивания. Не менее '.PASSWORD_MIN.' символов.';?>" value="<?php if (isset ($data['user']['password'])) echo $data['user']['password'];?>"" /></p>
                <button name="login" type="submit"> <img src="/Template/images/enter.gif" width="69" height="25"> </button>
            </form>
        </div>
    </div>
</div>

<?php include ROOT. '/Views/Layouts/footer.php';?>	