<?php
/*define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '0000');
define('DB_NAME', 'booksstore');

	$connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($connect->connect_errno) exit('Error connect to DataBase');
	$connect->set_charset('utf-8');
	$connect->close();*/
	$connect = mysqli_connect('localhost:3306', 'root', 'testmode', 'booksstore');
	if (!$connect) {
		die('Ошибка подключения базы данных');		
	}
?>