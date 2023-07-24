<?php 
if ($_SESSION['role']==0){
	header('Location: index.php?page=main');	
} ?>
<!doctype html>
<html lang="en" style="height:100%;">
  <head>
    <title>FlowerShop</title>
  </head>
  <body style="background:silver; margin:1%">
<a href="index.php?page=main" style="color:white; font-size:20pt">
На главную
</a>
<form style="text-align:center; margin:10%"method="POST">
<h3>Создание нового пользователя:</h3> <hr width=40%>
<div>
<p>Логин для входа:<br>
<input type="text" name="login"/></p>
<p>Имя пользователя:<br>
<input type="text" name="uname"/></p>
<p>Пароль:<br>
<input type="password" name="passwd1"/></p>
<p>Повторите пароль:<br>
<input type="password" name="passwd2"/></p>
</div>
<div>
<p>
Выберите роль:
<select name="list">
<option value="user"> Управляющий </option>
<option value="admin"> Администратор </option>
</select></p>
<input type="submit" value="Добавить" name="add"/>
</div>
<?php 
if (check()){
$us=new user($_POST['login'],$_POST['uname'],$_POST['passwd1'],$_POST['list']);
if($us->add()){
	echo "Пользователь ".$_POST['uname']." успешно добавлен!";}
else {echo "Ошибка! Пользователь ".$_POST['uname']." не добавлен!";}
}
function check(){
  if (isset($_POST['add'])) {
	if ($_POST['login']=='' || $_POST['uname']=='' || $_POST['passwd1']=='' || $_POST['passwd2']==''){  
	  echo "<b>Заполните форму!</b>"; return false;}
    elseif ($_POST['passwd1']!=$_POST['passwd2']){
	  echo "<b>Введенные пароли не совпадают!</b>"; return false;}
	elseif (strlen($_POST['passwd1'])<8){
	  echo "<b>Пароль слишком слабый!</b>"; return false;}
	elseif(strlen($_POST['uname'])<8 || strlen($_POST['login'])<8){
	echo "<b>Логин или имя пользователя слишком короткие!</b>"; return false;}
	elseif( preg_match("/[А-Яа-я]/", $_POST['login']) || preg_match("/[А-Яа-я]/", $_POST['uname'])) {  
	 echo "<b>В логине и имени пользователя не может быть кириллических символов!</b>"; return false;}
	else return true; 
  }
  else return false;
}
?>
</form>
<footer >
</footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>