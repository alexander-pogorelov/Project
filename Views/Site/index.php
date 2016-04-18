<?php include ROOT. '/Views/Layouts/header.php';?>
	
<div id="container">
    <div id="center" class="column">
        <?php if ($categoryId==0) include ROOT. '/Views/Layouts/banner.php';?>

	  	<div id="content">

			<?php if ($categoryId==0) include ROOT. '/Views/Layouts/about.php';?>
			<img src="/Template/images/title3.gif" alt="" width="540" height="26" class="pad25" />
			<div class="stuff">
				<?php foreach ($latestProducts as $product):?>
				<div class="item">
					<img src="<?php echo (file_exists(ROOT.'/Template/images/'.$product['id_product'].'_small.jpg')) ? '/Template/images/'.$product['id_product'].'_small.jpg' : '/Template/images/none_small.jpg';?>" alt=""  />
					<a href="/product/<?php echo $product['id_product'];?>" class="name"><?php echo ($product['singular_category'] . ' ' . $product['brand']. ' ' . $product['vendor_code']); ?></a>
					<span><?php echo number_format($product['price'], 0, '', ' ') . ' б.р.';?></span>
					<a href="#"><img src="/Template/images/zoom.gif" alt="" width="53" height="19" /></a><a href="/cart/add/<?php echo $product['id_product'];?>"><img src="/Template/images/cart.gif" alt="" width="71" height="19" /></a>
				</div>	
				<?php endforeach;?>
			</div>


		</div>
        <div id="pagination">
            <?php echo $pagination->getPaginationList(); ?>
        </div>
        <br>
    </div>

    <div id="left" class="column">
	  	<div class="block">
		    <img src="/Template/images/title1.gif" alt="" width="168" height="42" /><br />
		    <?php include ROOT. '/Views/Layouts/navigation.php';?>
		</div>
		<a href="#"><img src="/Template/images/banner1.jpg" alt="" width="172" height="200" /></a>
    </div>

    <div id="right" class="column">
        <a href="#"><img src="/Template/images/banner2.jpg" alt="" width="237" height="216" /></a><br />
        <div class="rightblock">
            <img src="/Template/images/title4.gif" alt="" width="223" height="29" /><br />
            <div class="blocks">
                <img src="/Template/images/top_bg.gif" alt="" width="218" height="12" />
                <form action="#">
                    <p class="line"><span>Login:</span> <input type="text" /></p>
                    <p class="line"><span>Password:</span> <input type="text" /></p>
                    <p class="line center"><a href="/user/registration" class="reg">Registration</a> | <a href="#" class="reg">Forgot password?</a></p>
                    <p class="line center pad20"><a href="#"><img src="/Template/images/enter.gif" alt="" width="69" height="25" /></a></p>
                </form>
                <img src="/Template/images/bot_bg.gif" alt="" width="218" height="10" /><br />
            </div>
            <div class="blocks">
                <img src="/Template/images/top_bg.gif" alt="" width="218" height="12" />
                <div id="news">
                    <img src="/Template/images/title5.gif" alt="" width="201" height="28" />
                    <span class="date">23 november</span>
                    <p>Dolor sit amet, consetetur sadipscing elitr, seddiam nonumy eirmod tempor. invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                    <a href="#" class="more">read more</a>
                </div>
                <img src="/Template/images/bot_bg.gif" alt="" width="218" height="10" /><br />
            </div>
        </div>

    </div>
</div>

	
<?php include ROOT. '/Views/Layouts/footer.php';?>	
