<?php
	$connect = mysqli_connect('localhost:3306', 'root', 'testmode', 'booksstore');
	if (!$connect) {
		die('Ошибка подключения базы данных');		
	}
		$book= mysqli_query($connect, "SELECT * FROM BOOKS WHERE ID_BOOK=".$_GET['id']."");
		$book= mysqli_fetch_assoc($book);
		$pub = mysqli_query($connect, "SELECT p.Name, p.Description from books as b join Publishers as p on b.Publisher=p.ID_publisher where b.ID_BOOK=".$_GET['id']."");
		$pub= mysqli_fetch_assoc($pub);
		$aut = mysqli_query($connect, "SELECT a.Name, a.Description from books as b join authors_of_the_books as aob on aob.Book=b.ID_BOOK join autors as a on a.ID_autor=aob.Autor where b.ID_BOOK=".$_GET['id']."");
		$aut= mysqli_fetch_assoc($aut);
		$gen=mysqli_query($connect, "SELECT g.Name, g.Description from books as b join books_genres as bg on bg.book=b.Id_book join genres as g on g.ID_genres=bg.genre where b.ID_BOOK=".$_GET['id']."");
		$gen= mysqli_fetch_assoc($gen);
		$rat=mysqli_query($connect, "SELECT r.Name, r.Description from books as b join ratings as r on b.rating=r.Id_rating where b.ID_BOOK=".$_GET['id']."");
		$rat= mysqli_fetch_assoc($rat);
?>
<!DOCTYPE html> 
<html> 
<head> 
<link rel="shortcut icon" href="Images/icon.ico" type="image/x-icon"> 
<link rel="stylesheet" type="text/css" href="Styles/product.css" /> 
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
<div> 
<img src="<?php echo "Images/".$book['Fphoto']."";?>" align="left"/> 
</div> 
<div> 
<span class="title">Описание товара </span><br> 
<table> 
<tr> <td class="left"> Автор </td> <td class="right" title="<?php echo $aut['Description'] ?>"> <?php echo $aut['Name'] ?> </td> </tr> 
<tr> <td class="left"> Издательство </td> <td class="right" title="<?php echo $pub['Description'] ?>"> <?php echo $pub['Name'] ?> </td> </tr> 
<tr> <td class="left"> Жанр </td> <td class="right"  title="<?php echo $gen['Description'] ?>"> <?php echo $gen['Name'] ?> </td> </tr> 
<tr> <td class="left"> Кол-во страниц </td> <td> <?php echo $book['Pages'] ?></td> </tr> 
<tr> <td class="left"> Возрастные ограничения</td> <td class="right" title="<?php echo $rat['Description'] ?>"> <?php echo $rat['Name'] ?></td> </tr> 
<tr> <td colspan="2"> <?php echo $book['description'] ?>  </td>  </tr> 
</table> 
<div> 

<p class="price">Цена: <?php echo $book['price'] ?>₽ 
<button type="button" class="fbut"> 
Купить 
</button> 
<button type="button" class="sbut"> 
В корзину 
</button></p> 
<footer>
<span class="category" style="text-decoration:underline; font-size:17pt;">Контактная информация:</span><br>
<span class="category">Адрес:</span> <span class="var">Санкт-Петербург, ул. Комсомольская, 45, 2 этаж.</span><br>
<span class="category">Почта: </span><span style="color:black; font-style:italic; font-size:20px">Ru-Book_Worm@gmail.com</span><br>
<span class="category">Время работы:</span> <span class="var">ПН-СБ: с 9:00 до 19:00 (ВС: выходной)</span>
</footer>
</body> 
</html>
