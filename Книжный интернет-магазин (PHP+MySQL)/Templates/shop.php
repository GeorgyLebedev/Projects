<?php
	$connect = mysqli_connect('localhost:3306', 'root', 'testmode', 'booksstore');
	if (!$connect) {
		die('Ошибка подключения базы данных');		
	}
		$goods = mysqli_query($connect, "SELECT * FROM BOOKS");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="Images/icon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="Styles/styleshop.css" />
<meta charset="utf-8">   
<title>
Интернет-магазин Bookworm.ru
</title>
</head>
<body>
<header>
<ul>
<li><a href="/">Главная</a><li>
<li><a href="index.php?page=shop">Магазин</a></li>
<li><a href="index.php?page=basket">Корзина</a></li>
<li><a href="index.php?page=avtorization">Личный кабинет</a></li>
</ul>
</header>
<h1>
Каталог товаров
</h1>
<hr noshade color=white size=3pt>
<?php while($good= mysqli_fetch_assoc($goods)){ ?> 
<div class='goods'> 
<img src="<?php echo "Images/".$good['Photo']."";?>" /> <br> 
<span class="name"><?php echo $good['Title'];?></span> 
<hr>
<p class="description"> 
<?php echo mb_strimwidth($good['description'], 0, 140, "...");?> 
</p> 
<hr>
<span class="price"> Цена: <?php echo $good['price'];?>р </span> 
<a href="index.php?page=product&id=<?php echo $good['ID_book'];?>" class="ref"> 
<button type="button"> 
<?php echo 'Подробнее';?> 
</button> 
</a> 
</div> 
<?php } ?>
<footer>
<span class="category" style="text-decoration:underline; font-size:17pt;">Контактная информация:</span><br>
<span class="category">Адрес:</span> <span class="var">Санкт-Петербург, ул. Комсомольская, 45, 2 этаж.</span><br>
<span class="category">Почта: </span><span style="color:black; font-style:italic; font-size:20px">Ru-Book_Worm@gmail.com</span><br>
<span class="category">Время работы:</span> <span class="var">ПН-СБ: с 9:00 до 19:00 (ВС: выходной)</span>
</footer>
</body>
</html>