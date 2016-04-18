<ul id="navigation">
	<?php foreach ($categories as $categoryItem): ?>

		<li class="<?php if ($categoryItem['id_category']==$categoryId) echo "color"; ?>" >

		<!--<li class="" >-->
			<a href="/category/<?php echo $categoryItem['id_category']; ?>"><?php echo $categoryItem['category']; ?></a>
		</li>
	<?php endforeach; ?>


</ul>