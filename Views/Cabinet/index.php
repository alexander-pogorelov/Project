<?php include ROOT. '/Views/Layouts/header.php';?>
	

	<div id="center" class="column">
		<div id="content">	
			<h2>Личный кабинет пользователя</h2>
            <h3><?php echo $_SESSION['user']['name'];?></h3>
			<br>

            <ul>
                <li><a href="/cabinet/edit">Редактировать данные</a></li>
				<li><a href="/cabinet/pass">Сменить пароль</a></li>
				<li><a href="/cabinet/orders">Список заказов</a></li>
            </ul>
		</div>
	</div>	

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	