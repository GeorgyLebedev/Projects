<?php 
  unset ($_SESSION['user']);
  unset ($_SESSION['role']);
  if (isset($_POST['send']) && $_POST['log']!='' && $_POST['pas']!=''){  
  Connect();
  }
  function Connect(){
  $url="LAPTOP-5PB69LTJ\EX1";
  $_SESSION['url']=$url;
  $connectionInfo = array( "Database"=>"FlowerShop", "UID"=>$_POST["log"], "PWD"=>$_POST["pas"]);
  $conn = sqlsrv_connect( $url, $connectionInfo);
  $_SESSION['coninf']=$connectionInfo;
  if( $conn ){   
  $sql="IF IS_MEMBER ('db_owner') = 1 select 1 else select 0";
  $stmt = sqlsrv_query($conn, $sql);
  if( sqlsrv_fetch( $stmt ) === false) {  
     echo "Error in retrieving row.\n";  
	  die( print_r( sqlsrv_errors(), true)); 
}
  $row = sqlsrv_get_field( $stmt, 0); 
  $_SESSION['role']=$row;
  $sql="select user_name()";
  $stmt = sqlsrv_query($conn, $sql);
   if( sqlsrv_fetch( $stmt ) === false) {  
     echo "Error in retrieving row.\n";  
	  die( print_r( sqlsrv_errors(), true)); 
}
  $_SESSION['user']=sqlsrv_get_field( $stmt, 0); 
  sqlsrv_close( $conn );
	header('Location: index.php?page=main');	
  }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Аутентификация</title>
  </head>
  <body style="background:silver">
  <form method="POST" align="center" style="margin-top:10%">
    <h2>Аутентификация</h2>
	<hr width=20%>
	<h4>Введите свои данные</h4>
	Логин<br>
	<input type="text" placeholder="Login" name="log"/><br>
	Пароль<br>
	<input type="password" placeholder="*********" name="pas"/><p></p>
	<input type="submit" value="Войти" name="send"/><br>
	<?php   if (!(isset($_POST['send']) && $_POST['log']!='' && $_POST['pas']!='')){  
	echo "<b>Введите логин и пароль!</b>";}
	else {
		if(!$conn){
  echo "Неправильный логин или пароль!";
  }
	}
	?>
  </form>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
  <footer style="margin-top:10%">
  <a href="index.php?page=help" style="margin-left: 3%;">
<input type="submit" value="Справка"/> </a>
  </footer>
</html>