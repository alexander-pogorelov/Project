<?php include ROOT. '/Views/Layouts/header.php';?>

<div id="center" class="column">
    <div id="content">
         <!--<img src="/Template/images/title4.gif" alt="" width="218" height="29" /><br />-->
         <?php if ($result): ?>
             <p>Сообщение успешно отправлено!</p>
         <?php else: ?>
             <h3>Обратная связь</h3>
             <?php if (count($data['error']) > 0): ?>
                 <ul>
                     <?php foreach ($data['error'] as $error): ?>
                     <li> - <?php echo $error; ?></li>
                     <?php endforeach; ?>
                 </ul>
             <?php endif; ?>
             <div class="blocks">
                 <br>
                 <form action="#" method="POST">
                    <p class="line"><span class="red">E-mail:</span>
                        <input type="email" placeholder="Введите Ваш e-mail" title="Введите свой e-mail" name="feedback_user[email]" value="<?php if (isset ($data['feedback_user']['email'])) echo $data['feedback_user']['email'];?>"/>
                    </p>
                    <p class="line"><span class="red">Тема:</span>
                        <input type="text" placeholder="Тема сообщения" title="Заполните тему сообщения" name="feedback_user[subject]" value="<?php if (isset ($data['feedback_user']['subject'])) echo $data['feedback_user']['subject'];?>" />
                    </p>
                    <p class="line"><span class="red">Сообщение:</span>
                        <textarea name="feedback_user[message]" placeholder="Текст сообщения" title="Заполните текст сообщения. Тэги запрещены" cols="80" rows="10"><?php if (isset ($data['feedback_user']['message'])) echo $data['feedback_user']['message'];?></textarea>
                    </p>
                     <br>
                    <button name="feedback_button" type="submit"> <img src="/Template/images/enter.gif" width="69" height="25"> </button>
                 </form>
                 <!--<img src="/Template/images/bot_bg.gif" alt="" width="188" height="10" /><br />-->
             </div>
         <?php endif; ?>
    </div>
</div>

<?php include ROOT. '/Views/Layouts/footer.php';?>	