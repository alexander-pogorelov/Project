<?php include ROOT. '/Views/Layouts/header.php';?>

	
<div id="container">
    <div id="center" class="column">
	    <div id="content">
		    <div id="about">
                <p class="tree"><a href="/">Главная</a>  >  <a href="<?php echo '/category/' . $productItem['id_category'];?>"><?php echo $productItem['category'];?></a>  >  <?php echo $productItem['brand'] . ' ' . $productItem['vendor_code'];?></p>
				<div class="photos">
					<img src="<?php echo (file_exists(ROOT.'/Template/images/'.$productItem['id_product'].'_medium.jpg')) ? '/Template/images/'.$productItem['id_product'].'_medium.jpg' : '/Template/images/none_medium.jpg';?>" alt=""  /><br />
					<a href="#" class="moreph">more photos</a>
					<a href="#" class="comments">View Comments (27)</a>

				</div>
				<div class="description">

					<p>
						<u><?php echo $productItem['singular_category'] . ' ' .$productItem['brand'] . ' ' . $productItem['vendor_code'];?></u>
					</p>
					<p>
						<!--<span class="price"><?php echo number_format($productItem['price'], 0, '', ' ') . ' б.р.';?></span>-->
						<span class="price"><?php echo ($productItem['product_arh'] || $productItem['category_arh'])? 'Товара нет в наличии': number_format($productItem['price'], 0, '', ' ') . ' б.р.';?></span>
					</p>
                    <p>ID товара: <?php echo $productItem['id_product'];?>

                    </p>
					<p><?php echo $productItem['simple_descrip'];?></p>
					<p><strong>Short features:</strong></p>
					<ul id="features">
						<li class="color"><span>Dolor sit amet</span>1234</li>
						<li><span>Consetetur sadipscing</span>1234</li>
						<li class="color"><span>Seddiam</span>1234</li>
						<li><span>Nonumy eirmod</span>1234</li>
						<li class="color"><span>Dolor sit amet</span>1234</li>
						<li><span>Lorem ipsum dolor</span>1234</li>
						<li class="color"><span>Dolor sit amet</span>1234</li>
						<li><span>Seddiam</span>1234</li>
						<li class="color"><span>Nonumy eirmod</span>1234</li>
					</ul>
					<br>
					<?php if (!$productItem['product_arh'] && (!$productItem['category_arh'])): ?>
						<a href="/"><img src="/Template/images/button-3182.png" alt="" class="allProducts" id="/cart/addAjax/<?php echo $productItem['id_product'];?>"/><img src="/Template/images/carts.gif" alt="" class="allProducts" id="<?php echo $productItem['id_product'];?>"/></a>
					<?php endif;?>
				</div>
			</div>
			<img src="/Template/images/title6.gif" alt="" width="537" height="23" class="pad25" />
			<div class="stuff">
                <?php foreach ($similarProducts as $similarProductItem): ?>
				<div class="item">
					<img src="<?php echo (file_exists(ROOT.'/Template/images/'.$similarProductItem['id_product'].'_small.jpg')) ? '/Template/images/'.$similarProductItem['id_product'].'_small.jpg' : '/Template/images/none_small.jpg';?>" alt="" width="" height="" />
					<a href="/product/<?php echo $similarProductItem['id_product'];?>" class="name"><?php echo $similarProductItem['singular_category'] . ' ' .$similarProductItem['brand'] . ' ' . $similarProductItem['vendor_code'];?></a>
					<span><?php echo number_format($similarProductItem['price'], 0, '', ' ') . ' б.р.';?></span>
					<a href="/"><img src="/Template/images/zoom.gif" alt="" width="53" height="19" /></a>
					<a href="/"><img class="allProducts" id ="/cart/addAjax/<?php echo $similarProductItem['id_product'];?>" src="/Template/images/cart.gif" alt="" width="71" height="19" /></a>
				</div>
                <?php endforeach; ?>
			</div>

		</div>

    </div>
	<div id="left" class="column">
	  	<div class="block">
		<img src="/Template/images/title1.gif" alt="" width="168" height="42" /><br />

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
					<p class="line center"><a href="#" class="reg">Registration</a> | <a href="#" class="reg">Forgot password?</a></p>
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