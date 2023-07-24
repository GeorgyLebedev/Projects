<?php
if (!isset($_SESSION['user'])|| !isset($_SESSION['role'])){
header('Location: index.php?page=auth');	
}
?>
<!doctype html>
<html lang="en" style="height:100%;">
  <head>
    <title>FlowerShop</title>
	<style type="text/css"> 
	.left { 
	width: 50%; } 
	.right{  
	width: 50%;  }
	.frame { 
	width: 100%; 
	height: 940px;
	background-color:white;
} 
	</style>
  </head>
  <body style="background:silver; margin:1%">
  <div style="width:100%; display:flex;flex-direction:row; ">
<div class="left">
<a href="index.php?page=main" style="color:white; font-size:20pt">
На главную
</a>
<form method="post" style="padding-top:1%;">
Выберите таблицу:<br>
<select name="table">
<option value="none" <?php if($_POST['table'] == 'none') {echo "selected";}?>> -Не выбрана- </option>
<option value="Adres" <?php if($_POST['table'] == 'Adres') {echo "selected";}?>> Адреса </option>
<option value="Branch"<?php if($_POST['table'] == 'Branch') {echo "selected";}?>> Филиалы </option>
<option value="Clients"<?php if($_POST['table'] == 'Clients') {echo "selected";}?>> Клиенты </option>
<option value="Goods"<?php if($_POST['table'] == 'Goods') {echo "selected";}?>> Товары </option>
<option value="Manufacturers"<?php if($_POST['table'] == 'Manufacturers') {echo "selected";}?>> Производители </option>
<option value="Ordcontent"<?php if($_POST['table'] == 'Ordcontent') {echo "selected";}?>> Содержимое заказов </option>
<option value="Orders"<?php if($_POST['table'] == 'Orders') {echo "selected";}?>> Заказы</option>
<option value="Requestcontent"<?php if($_POST['table'] == 'Requestcontent') {echo "selected";}?>> Содержимое заявок </option>
<option value="Requessts"<?php if($_POST['table'] == 'Requessts') {echo "selected";}?>> Заявки </option>
<option value="Salecontent"<?php if($_POST['table'] == 'Salecontent') {echo "selected";}?>> Содержимое продаж </option>
<option value="Sales"<?php if($_POST['table'] == 'Sales') {echo "selected";}?>> Продажи </option>
<option value="Staff"<?php if($_POST['table'] == 'Staff') {echo "selected";}?>> Сотрудники </option>
<option value="Suppliers"<?php if($_POST['table'] == 'Suppliers') {echo "selected";}?>> Поставщики </option>
<option value="Supply"<?php if($_POST['table'] == 'Supply') {echo "selected";}?>> Поставки </option>
<option value="Supplycontent"<?php if($_POST['table'] == 'Supplycontent') {echo "selected";}?>> Содержимое поставок </option>
</select>
<input type="submit" value="Создать отчет" name="show"/> 
<?php
if ( $_POST['table']!="none" &&  $_POST['table']!=null){ ?>
<p>Введите дополнительные данные: </p>
<p>Название отчета:<br>
<input type=text name="name" min=1 /></p>
<p>Номер документа:<br>
<input type=number name="num" min=1 /></p>
<p>ИНН организации:<br>
<input type=text name="inn" maxlength=9 /></p>
<p>ФИО управляющего:<br>
<input type=text name="FIO" /></p>
<p>Изменить дату:<br>
<input type=date name="date" /></p>
<p><input type=checkbox name="stamp">  Печать организации </input></p>
<p><input type=submit name="add" value="Применить" /> </p>
</form>
<button title="Печать" onclick="print()">
<img style="width:30px; height:30px" src="/Img/print.png"/>
</button>
</div>
<div class="right">
<?php $conn = sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);  ?>
<iframe id="frame" src="Templates/frame.php<?php echo"?table=".$_POST['table']."&num=".$_POST['num']."&inn=".$_POST['inn']."&fio=".$_POST['FIO']."&date=".$_POST['date']."&name=".$_POST['name']."&stamp=".$_POST['stamp']?>" class="frame" frameborder="1" scrolling="yes">Не поддерживается</iframe>	
<?php
}			
?>
</div>
</div>
<footer >
</footer>
<script language="javascript">
function print(){
document.getElementById("frame").contentWindow.focus();
document.getElementById("frame").contentWindow.print();
}
</script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>