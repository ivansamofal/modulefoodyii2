<h1>Блюдо: <?=$model->name?></h1>

<h2>Ингредиенты для блюда:</h2>
<ul>
<?foreach( $ingredients as $ingredient ):?>
	<li><?=$ingredient['name']?></li>
	
<?endforeach;?>
</ul>