<?php
header("Refresh:45");
if (!isset($_SESSION['user'])|| !isset($_SESSION['role'])){
header('Location: index.php?page=auth');	
}
?>
<!doctype html>
<html lang="en" >
  <head>
    <title>FlowerShop</title>
  </head>
  <body style=" background:silver; display: flex; flex-direction: column;">
<h1 align="center">База данных FlowerShop</h1>
<div style="margin: auto 3%; display:flex;flex-direction:row; flex: 1 0 auto;">
<div align="left" style="width:50%;">
<p style="font-size:18pt"> Текущее время: <?php echo date("H:i") ?><br>
<?php echo date("d.m.Y") ?> </p>
<a href="index.php?page=reports">
<input type="button" value="Создание и печать отчетов"/> </a>
</div>
<div align="right" style="width:50%; margin-left:50%">
<p style="font-size:18pt">Добро пожаловать,<br>
<?php 
$role= $_SESSION['role'];
if ($role==1){
echo "Администратор";}
else{
echo "Управляющий";}
?>
</p>
<p>
<?php if ($role==1){ ?>
<a href="index.php?page=useradd">
<input type="button" value="Добавить пользователя"/> </a> </p>
<form method="POST">
<p>
<input type="submit" name="copy" value="Создать резервную копию"/> </p>
<p> <input type=number name=nfile min=1 max=1000 placeholder="№ файла" style="width:90px"/>
<input type="submit" name="rec" value="Восстановить БД"/> </p>
</form>
<?php
if (isset($_POST["copy"])){
$conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
if ($conn){
	$code=null;
	$numf=null;
	$sql="BACKUP DATABASE [FlowerShop] TO  DISK = N'C:\Program Files\Microsoft SQL Server\MSSQL13.EX1\MSSQL\Backup".'\r'."eserve',  DISK = N'C:\Program Files\Microsoft SQL Server\MSSQL13.EX1\MSSQL\Backup\FlowerShop.bak' WITH NOFORMAT, NOINIT,  NAME = N'FlowerShop-Полная База данных Резервное копирование', SKIP, NOREWIND, NOUNLOAD";
	$sql=mb_convert_encoding($sql,"Windows-1251","UTF-8");
	sqlsrv_configure("WarningsReturnAsErrors", 1);	
	$stmt = sqlsrv_query($conn, $sql);
	if (($errors=sqlsrv_errors())!=null){
		foreach ($errors as $error){
	$numf=substr($error['message'],-3,-1);
	$code=$error['code'];}}
	sqlsrv_configure("WarningsReturnAsErrors", 0);	
	$stmt = sqlsrv_query($conn, $sql);
	if ($stmt!==false){
	  while ($nres=sqlsrv_next_result($stmt)){
	}}
	if ($code!="4035"){
echo "Ошибка! Резервное копирование не выполнено!";}
else { echo "Копия успешно создана!<br> Файл резервной копии №".$numf."";}sqlsrv_close($conn);}}
if (isset($_POST["rec"])){
	if (empty($_POST['nfile'])){echo "Вы не ввели номер файла резервной копии!";} else{
		$num=$_POST['nfile'];
$conn= sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
if ($conn){
	$sql="use master";
		$stmt = sqlsrv_query($conn, $sql);
$sql="alter database Flowershop set single_user with rollback immediate";
	$stmt = sqlsrv_query($conn, $sql);
sqlsrv_configure("WarningsReturnAsErrors", 0);	
	$sql="RESTORE DATABASE [FlowerShop] FROM  DISK = N'C:\Program Files\Microsoft SQL Server\MSSQL13.EX1\MSSQL\Backup\FlowerShop.bak',  DISK = N'C:\Program Files\Microsoft SQL Server\MSSQL13.EX1\MSSQL\Backup".'\r'."eserve' WITH RECOVERY, FILE =".$num.",  NOUNLOAD	";
	$stmt = sqlsrv_query($conn, $sql);
	if ($stmt!==false){
	  while ($nres=sqlsrv_next_result($stmt)){
	}}
	if ($stmt===false){
echo "Ошибка! Восстановление не удалось!";}
else { echo "База данных успешно восстановлена!";	$stmt = sqlsrv_query($conn, "alter database Flowershop set multi_user");
}sqlsrv_close($conn);}}}} ?>
</div>
</div>
<a href="index.php?page=mod" style="color:white;margin:5%;font-size:26pt;text-align:center ">
<p>Перейти к работе с таблицами</p>
</a>

<footer style='margin-top:5%'>
<a href="index.php?page=help" style="margin-left: 3%;">
<input type="submit" value="Справка"/> </a>
<a href="index.php?page=auth" style="position:fixed; margin-left:80%; color:white; font-size:18pt">
Завершить работу </a>
</footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>