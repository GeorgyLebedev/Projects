<!doctype html>
<html lang="ru">
<head>
 <meta charset="UTF-8">
 <title>Авторизация и регистрация</title>
 <link rel="stylesheet" href="../Styles/avtorization.css">
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
<!-- Форма авторизации -->
<div class="container">
 <div class="content">
 <div class="title__LogIn"><h1>Вход</h1></div>
 <form class="forma" action="../vendor/signin.php" method="post">
 <label>Логин</label>
 <input type="text" name="login" placeholder="Введите логин">
 <label>Пароль</label>
 <input type="password" name="password" placeholder="Введите пароль">
 <button type="submit" class="button">Войти</button>
 <p>
 У вас нет аккаунта? - <a class="registr" href="index.php?page=registr">зарегистрируйтесь!</a>
 </p>
 <?php 
 	if ($_SESSION['message']){
 		echo '<p class="msg">' . $_SESSION['message'] . '</p>';
 	}
 	unset($_SESSION['message']);
 	?>
 </div>

 </form>
 </div>
 <footer>
<span class="category" style="text-decoration:underline; font-size:17pt;">Контактная информация:</span><br>
<span class="category">Адрес:</span> <span class="var">Санкт-Петербург, ул. Комсомольская, 45, 2 этаж.</span><br>
<span class="category">Почта: </span><a href="" style="color:black; font-style:italic;">Ru-Book_Worm@gmail.com</a><br>
<span class="category">Время работы:</span> <span class="var">ПН-СБ: с 9:00 до 19:00 (ВС: выходной)</span>
</footer>

</body>
</html>
