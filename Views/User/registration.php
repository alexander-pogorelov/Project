<?php include ROOT. '/Views/Layouts/header.php';?>

<div id="center" class="column">
    <div id="content">
         <img src="/Template/images/title4.gif" alt="" width="218" height="29" /><br />
         <?php if ($result): ?>
             <p>Вы успешно зарегистрированы!</p>
         <?php else: ?>
             <?php if (count($data['error']) > 0): ?>
                 <ul>
                     <?php foreach ($data['error'] as $error): ?>
                     <li> - <?php echo $error; ?></li>
                     <?php endforeach; ?>
                 </ul>
             <?php endif; ?>
             <div class="blocks">
                 <h3>Регистрация на сайте</h3>
                 <br>
                 <form action="#" method="POST">
					<p class="line"><span class="red">Name:</span> <input type="text" placeholder="Введите Ваше имя" title="<?php echo 'Используйте только буквы, цифры, знак подчеркивания, пробелы. Не менее '.NAME_MIN.' символов.';?>" name="user[name]" value="<?php if (isset ($data['user']['name'])) echo $data['user']['name'];?>" /></p>
					<p class="line"><span class="red">Phone:</span> <input type="text" placeholder="Введите Ваш телефон" title="<?php echo 'Используйте только цифры. Не менее '.PHONE_MIN.' символов.';?>" name="user[phone]" value="<?php if (isset ($data['user']['phone'])) echo $data['user']['phone'];?>" /></p>
                    <p class="line"><span class="red">E-mail:</span> <input type="email" placeholder="Введите Ваш e-mail" title="Введите свой e-mail" name="user[email]" value="<?php if (isset ($data['user']['email'])) echo $data['user']['email'];?>"/></p>
                    <p class="line"><span class="red">Password:</span> <input type="password" placeholder="Введите Ваш пароль" name="user[password]" title="<?php echo 'Используйте только английские буквы, цифры и знак подчеркивания. Не менее '.PASSWORD_MIN.' символов.';?>" value="<?php if (isset ($data['user']['password'])) echo $data['user']['password'];?>"" /></p>
                    <button name="registration" type="submit"> <img src="/Template/images/enter.gif" width="69" height="25"> </button>
                 </form>
                 <!--<img src="/Template/images/bot_bg.gif" alt="" width="188" height="10" /><br />-->
             </div>
         <?php endif; ?>
    </div>
</div>

<?php include ROOT. '/Views/Layouts/footer.php';?>	