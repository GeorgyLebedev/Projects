<?php require ("../classes.php"); 
$table=$_GET['table'];
session_start();
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
} ?>
<link rel="stylesheet" type="text/css" href="frame.css" />
<html>
  <head>
    <title>FlowerShop</title>
  </head>
  <body>
  <header>
  Общество с ограниченной ответственностью "ЯрЦвет"<br>
  <?php
  $conn = sqlsrv_connect( $_SESSION['url'], $_SESSION['coninf']);
  if( $conn ){ 
  $sql="select top 1 * from Branch"; 
  $stmt = sqlsrv_query($conn, $sql);
	if(!$stmt===false){
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
$adr=$row['City'].", ".$row['Street'].", ".$row['House'];
$adr=mb_convert_encoding($adr, 'UTF-8', 'windows-1251');
$num=$row['Phonenum'];
}	
	}
  } ?>
  Адрес филиала: <?php echo $adr ?> <br>
  Номер телефона: <?php echo $num ?> <br>
  <?php if (!empty($_GET['fio'])){
  echo "ФИО управляющего: ".$_GET['fio']; echo "<br>";
  } 
  if (!empty($_GET['inn'])){
  echo "ИНН организации: ".$_GET['inn'];
  } 
  ?>
  </header>
  <hr>
  <h4><?php if (!empty($_GET['name'])){
  echo $_GET['name'];
  } else{
  echo "Отчет";}
  ?></h4>
  Дата составления: <?php 
  if (empty($_GET['date'])){ echo date("d-m-Y H:i");} else { echo $_GET['date'];} ?><br>
  <?php if (!empty($_GET['num'])){
  echo "Документ №".$_GET['num'];
  } 
  ?> <br>
  <?php
$obj=gettable($table);
$cols=$obj->cols;	
$stmt=$obj->select();
if(!$stmt===false){
	echo "<table class=out>";
			foreach($cols as $n){
				if ($n!="OwnerUser"){
				echo "<th class=tab>".$n."</th>";}
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				echo "<tr>";
				foreach($cols as $n){
					if ($n!="OwnerUser"){
					if (gettype($row[$n])=="string"){
					$text=mb_convert_encoding($row[$n], 'UTF-8', 'windows-1251');}
					elseif (gettype($row[$n])=="object")
					{
						$text=$row[$n]->format('Y-m-d H:i:s');
					} 
					else $text=$row[$n];
					echo "<td class=tab>".$text."</td>"; 
					}
				}
	  echo "</tr>";
	}
	echo "</table>";
			}
?>
  </body>
  <footer>
      Подпись____________ 
   <?php   if (!empty($_GET['stamp'])){
  echo " <p style=text-align:right><img style=width:100px;height:auto src=../Img/stamp.png /></p>";
  }  ?>
 
  </footer>
  </html>
