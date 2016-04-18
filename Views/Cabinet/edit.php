<?php include ROOT. '/Views/Layouts/header.php';?>
	

	<div id="center" class="column">
		<div id="content">	
			<h2>Личный кабинет пользователя</h2>
            <h3><?php echo $_SESSION['user']['name'];?></h3>
			<br>			
            <ul>
                <li><a href="/cabinet/edit">Редактировать данные</a></li>
				<li><a href="/cabinet/pass">Сменить пароль</a></li>
				<li><a href="#">Список покупок</a></li>
            </ul>
			<br>
			<?php if ($result): ?>
				<p>Редактирование завершено успешно!</p>
			<?php else: ?>
				<?php if (count($data['error']) > 0): ?>
					<ul>
						<?php foreach ($data['error'] as $error): ?>
						<li> - <?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<div class="blocks">
					<h3>Редактирование личных данных</h3>
					<br>
					<form action="#" method="POST">
						<p class="line"><span>Name:</span> <input type="text" placeholder="Введите Ваше имя" title="<?php echo 'Используйте только буквы, цифры, знак подчеркивания, пробелы. Не менее '.NAME_MIN.' символов.';?>" name="user[name]" value="<?php echo $_SESSION['user']['name'];?>" /></p>
						<p class="line"><span>Phone:</span> <input type="text" placeholder="Введите Ваш телефон" title="<?php echo 'Используйте только цифры. Не менее '.PHONE_MIN.' символов.';?>" name="user[phone]" value="<?php echo $_SESSION['user']['phone'];?>" /></p>
						<p class="line"><span>E-mail:</span> <input type="email" placeholder="Введите Ваш e-mail" title="Введите свой e-mail" name="user[email]" value="<?php echo $_SESSION['user']['email'];?>"/></p>
						
						<button name="edit" type="submit"> <img src="/Template/images/enter.gif" width="69" height="25"> </button>
					</form>
					 <!--<img src="/Template/images/bot_bg.gif" alt="" width="188" height="10" /><br />-->
				</div>
			<?php endif; ?>
		</div>
	</div>	

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	