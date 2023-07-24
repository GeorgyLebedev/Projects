<?php
if (!isset($_SESSION['user'])|| !isset($_SESSION['role'])){
header('Location: index.php?page=auth');	
}
function gettable(string $name){
switch($name){
case 'Adres': $obj=new Adres();
return $obj;
break;
case 'Branch': $obj=new Branch();
return $obj;
break;
case 'Clients': $obj=new Clients();
return $obj;
break;
case 'Goods': $obj=new Goods();
return $obj;
break;
case 'Manufacturers': $obj=new Manufacturers();
return $obj;
break;
case 'Ordcontent': $obj=new Ordcontent();
return $obj;
break;
case 'Orders': $obj=new Orders();
return $obj;
break;
case 'Requestcontent': $obj=new Requestcontent();
return $obj;
break;
case 'Requessts': $obj=new Requests();
return $obj;
break;
case 'Salecontent': $obj=new Salecontent();
return $obj;
break;
case 'Sales': $obj=new Sales();
return $obj;
break;
case 'Staff': $obj=new Staff();
return $obj;
break;
case 'Suppliers': $obj=new Suppliers();
return $obj;
break;
case 'Supply': $obj=new Supply();
return $obj;
break;
case 'Supplycontent': $obj=new Supplycontent();
return $obj;
break;
}
}
?>
<!doctype html>
<html lang="en" style="height:100%;">
  <head>
    <title>FlowerShop</title>
  </head>
  <body style="background:silver; margin:1%">
<a href="index.php?page=main" style="color:white; font-size:20pt">
На главную
</a>
<form method="post" style="padding-top:1%;">
<div style="width:100%; display:flex;flex-direction:row; ">
<div align="left" style="width:30%";>
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
<input type="submit" value="Показать" name="show"/> <br> <br>
<?php
if ($_POST['table']!="none" &&  $_POST['table']!=null){
	$obj=gettable($_POST['table']);
	$cols=$obj->cols;	
	$stmt=$obj->select();
if(!$stmt===false){ ?>
	Выберите действие:<br>
<select name="action" id="act">
<option value="none"<?php if (isset($_POST['show'])) {echo "selected"; unset($_POST['action']); }?>> -Не выбрано- </option>
<option value="insert"<?php if($_POST['action'] == 'insert') {echo "selected";}?>> Добавить строку </option>
<option value="alter"<?php if($_POST['action'] == 'alter') {echo "selected";}?>> Изменить строку </option>
<option value="delete"<?php if($_POST['action'] == 'delete') {echo "selected";}?>> Удалить строку </option>
</select> <br> <br>
<?php 
$disp1=isset($_POST[upd])? "block": "none";
$disp2=isset($_POST[ins])? "block": "none";
$disp3=isset($_POST[del])? "block": "none";
echo "<span id=update style=display:".$disp1.">";
	echo "Выберите поле<br> для изменения: ";
	echo "<select name=field id=opt >";
	$ind=0;
	foreach($cols as $n){
		if($ind>=1 && $n!="OwnerUser"){
			if($_POST['field']==$n){
			echo "<option selected>".$n."</option>";
			} else {
			echo "<option>".$n."</option>";}
		} $ind++;
	}
	echo "</select><br><br>";
	echo "Введите ".$cols[0].": <br><input type=text name=".$cols[0]." /><br><br>";
	echo "Введите новое значение:<br> <input type=text name=newval id=nval />
	<input type=number style=width:60pt;display:none id=year name=year placeholder=Год />
	 <input type=number min=1 max=12 style=width:60pt;display:none id=mon name=month placeholder=Месяц />
	 <input type=number min=1 max=31 style=width:60pt;display:none id=day name=day placeholder=День />
	 <input type=number min=0 max=23 style=width:60pt;display:none id=hour name=hour placeholder=Часы />
	 <input type=number min=0 max=59 style=width:60pt;display:none id=mins name=mins placeholder=Минуты /><br>";
	echo "<input type=submit value=Изменить name=upd />";
	echo "</span>";
echo "<span id=insert style=display:".$disp2.">";
	echo "<table>";
		$ind=0;
	foreach($cols as $n){
		if($ind>=1 && $n!="OwnerUser" && $n!="Instock" && $n!="Salesum"){
	echo "<tr>";
	if(strpos($n, "date")||strpos($n, "time")){
	echo "<td>".$n.":</td> 
	<td> <input type=number  style=width:60pt name=year$n placeholder=Год />
	 <input type=number min=1 max=12 style=width:60pt name=month$n placeholder=Месяц />
	 <input type=number min=1 max=31 style=width:60pt name=day$n placeholder=День />
	 <input type=number min=0 max=23 style=width:60pt name=hour$n placeholder=Часы />
	 <input type=number min=0 max=59 style=width:60pt name=mins$n placeholder=Минуты /></td>";
	}
	else{
	echo "<td>".$n.":</td> <td> <input type=text name=".$n." /></td>";}
	echo "</tr>";	
		} $ind++;
	}
	echo "</table>";
	echo "<input type=submit value=Добавить name=ins />";
	echo "</span>";
echo "<span id=delete style=display:".$disp3.">";
echo "Введите ".$cols[0].": <input type=text name=id /><br>";
	echo "<input type=submit value=Удалить name=del />";
	echo "</span>";
			?>
</form>
<?php }
if (isset($_POST[ins])){
$input=array();
	$ind=0;
	foreach($cols as $n ){
		if(strpos($n, "date")||strpos($n, "time")){
		$_POST[$n]=$_POST["year".$n].$_POST["month".$n].$_POST["day".$n];
		if ($_POST["hour".$n]!="" && $_POST["mins".$n]!=""){
		$_POST[$n]=$_POST[$n]." ".$_POST["hour".$n].":".$_POST["mins".$n].":00";
		} elseif($_POST["hour".$n]!=""){
			$_POST[$n]=$_POST[$n]." ".$_POST["hour".$n].":00:00";}}
		if($ind>=1 && $n!="OwnerUser"){
			$input[$n]=$_POST[$n];
		} $ind++;	
	}
$obj->set($input);
if($obj->insert()){
echo "Строка успешно добавлена!";} 
else{
echo "Введены неверные данные!";}
unset($_POST[ins]);
}
if (isset($_POST[del])){
if($obj->del($_POST[id])){
echo "Строка успешно удалена!";} 
else{
echo "Ошибка! Строка не удалена!";}
unset($_POST[del]);
}
if (isset($_POST[upd])){
	if ($_POST[year]!="" && $_POST[month]!="" && $_POST[day]!=""){
	$_POST[newval]=$_POST[year].$_POST[month].$_POST[day];
		if ($_POST[hour]!="" && $_POST[mins]!=""){
		$_POST[newval]=$_POST[newval]." ".$_POST[hour].":".$_POST[mins].":00";
		} elseif($_POST[hour]!=""){
			$_POST[newval]=$_POST[newval]." ".$_POST[hour].":00:00";}}
if($obj->update($_POST[$cols[0]],$_POST[field],$_POST[newval])){
echo "Строка успешно изменена!";} 
else{
echo "Ошибка! Строка не изменена!";}
unset($_POST[upd]);
}
echo "</div>";	
	$stmt=$obj->select();
echo "<div align=right>";
	echo "<table class=out>";
			foreach($cols as $n){
				echo "<th style=background-color:#9da1aa class=tab>".$n."</th>";
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				echo "<tr>";
				foreach($cols as $n){
					if ($n=="Photo"){
					 echo "<td class=tab><img src=/Photos/$row[$n]><br>$row[$n]</td>";  
					}
					else{
					if (gettype($row[$n])=="string"){
					$text=mb_convert_encoding($row[$n], 'UTF-8', 'windows-1251');}
					elseif (gettype($row[$n])=="object")
					{
						$text=$row[$n]->format('Y-m-d H:i:s');
					} 
					else $text=$row[$n];
					echo "<td class=tab>".$text."</td>"; } 
				}
	  echo "</tr>";
	}
	echo "</table></div>";
			}
?>
<footer >
</footer>
<script language="javascript">
act.onclick=function(){
	document.getElementById('insert').style.display='none';
	document.getElementById('update').style.display='none';
	document.getElementById('delete').style.display='none';
	let op=document.getElementById("act").options.selectedIndex;
	switch(op){
		case 0:
		break;
		case 1:
		document.getElementById('insert').style.display='block';
		break;
		case 2:
		document.getElementById('update').style.display='block';
		break;
		case 3:
		document.getElementById('delete').style.display='block';
		break;
	}
}
opt.onclick=function(){
	let n = document.getElementById("opt").options.selectedIndex;
	let value = document.getElementById("opt").options[n].value;
	if ((value.indexOf("date")!=-1) || (value.indexOf("time")!=-1)){
	document.getElementById('nval').style.display='none';
	document.getElementById('year').style.display='inline';
	document.getElementById('mon').style.display='inline';
	document.getElementById('day').style.display='inline';
	document.getElementById('hour').style.display='inline';
	document.getElementById('mins').style.display='inline';
	}
	else {
	document.getElementById('nval').style.display='block';
	document.getElementById('year').style.display='none';
	document.getElementById('mon').style.display='none';
	document.getElementById('day').style.display='none';
	document.getElementById('hour').style.display='none';
	document.getElementById('mins').style.display='none';
	}
}
</script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>