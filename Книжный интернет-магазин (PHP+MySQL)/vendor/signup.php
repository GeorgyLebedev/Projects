<?php
	$Full_name = $_POST['Full_name'];
	$login = $_POST['login'];
	$Email = $_POST['Email'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password_confirm'];

	if ($password == $password_confirm){
		$path = 'uploads/' . time() . $_FILES['Image']['name'];
		if (!move_uploaded_file($_FILES['Image']['tmp_name'],'../' . $path)) {
			$_SESSION['message'] = 'Ошибка при загрузке сообщения';
		header('Location: ../Templates/registr.php');
		}

		$password = md5($password);
		$connect = mysqli_connect('localhost:3306', 'root', 'testmode', 'booksstore');
		if (!$connect) {
		die('Ошибка подключения базы данных');		
	}
		mysqli_query($connect, "INSERT INTO `users` (`Full_name`,`Password`,`Login`,`Email`,`Image`) VALUES ('$Full_name','$password','$login','$Email','$path')");

		$_SESSION['message'] = 'Регистрация прошла успешно';
		header('Location: ../Templates/avtorization.php');
	}
	else{
		$_SESSION['message'] = 'Пароли не совпадают';
		header('Location: ../Templates/registr.php');
		
	}
?>


