<?php include ROOT. '/Views/Layouts/header.php';?>

<div id="container">
    <div id="center" class="column">
        <div id="content">
            <h2>Оформление заказа.</h2>
            
            <p>Товаров в корзине: <?php echo $countItemsInCart.'. ';?></p>
            <p>На общую сумму: <?php echo number_format($cartTotalAmount, 0, '', ' ').' б.р.';?></p>
			<p>Клиент: <?php echo (isset($_SESSION['user']))? $_SESSION['user']['name'].".": "незарегистрированный пользователь.";?></p>


            <br>
				
				
			

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