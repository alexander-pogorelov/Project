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
				<p>Пароль успешно изменен!</p>
			<?php else: ?>
				<?php if (count($data['error']) > 0): ?>
					<ul>
						<?php foreach ($data['error'] as $error): ?>
						<li> - <?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<div class="blocks">
					<h3>Смена пароля</h3>
					<br>
					<form action="#" method="POST">
						

						<p class="line"><span>Password:</span> <input type="password" placeholder="Введите Ваш пароль" name="user[password]" title="<?php echo 'Используйте только английские буквы, цифры и знак подчеркивания. Не менее '.PASSWORD_MIN.' символов.';?>" value="" /></p>
						<button name="pass" type="submit"> <img src="/Template/images/enter.gif" width="69" height="25"> </button>
					</form>
					 <!--<img src="/Template/images/bot_bg.gif" alt="" width="188" height="10" /><br />-->
				</div>
			<?php endif; ?>
		</div>
	</div>	

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	