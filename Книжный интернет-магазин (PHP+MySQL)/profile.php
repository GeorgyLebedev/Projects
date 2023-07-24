<?php
	session_start();
?>
<!doctype html>
<html lang="ru">
<head>
 <meta charset="UTF-8">
 <title>Профиль</title>
 <link rel="stylesheet" href="Styles/profile.css">
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
<!-- Профиль -->
<div class="container">
<div class="content">

 <form>
  <div class="title"><h1>Профиль</h1></div>
 <img src="<?= $_SESSION['user']['Image'] ?>" with="200" height='350'>
 <h2><?= $_SESSION['user']['Full_name'] ?></h2>
 <a href="#" class="email"><?= $_SESSION['user']['Email'] ?></a>
 <a href="vendor/logout.php" class="logout">Выход</button></a>
 </div>
</div>
<footer>
<span class="category" style="text-decoration:underline; font-size:17pt;">Контактная информация:</span><br>
<span class="category">Адрес:</span> <span class="var">Санкт-Петербург, ул. Комсомольская, 45, 2 этаж.</span><br>
<span class="category">Почта: </span><a href="" style="color:black; font-style:italic;">Ru-Book_Worm@gmail.com</a><br>
<span class="category">Время работы:</span> <span class="var">ПН-СБ: с 9:00 до 19:00 (ВС: выходной)</span>
</footer>
