<?php
	$connect = mysqli_connect('localhost:3306', 'root', 'testmode', 'booksstore');
	if (!$connect) {
		die('Ошибка подключения базы данных');		
	}
	session_start();
	$login = $_POST['login'];
	$password = md5($_POST['password']);

	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
	if (mysqli_num_rows($check_user) > 0) {
	 	
	 	$user = mysqli_fetch_assoc($check_user);
	 	/*print_r($check_user);
	 	print_r($user);*/
	 	$_SESSION['user'] = [
	 		"Full_name" => $user['Full_name'],
	 		"Image" => $user['Image'],
	 		"Email" => $user['Email']
	 	];

	 	header('Location: /profile.php');
	 } 
	 else{
	 	$_SESSION['message'] = 'Не верный логин или пароль';
		header('Location: ../Templates/avtorization.php');
	 }

?>