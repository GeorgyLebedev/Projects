<?php
 require_once ("vendor/connect.php"); 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="Images/icon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="Styles/styleindex.css" />
<meta charset="utf-8">   
<title>
Bookworm</title>
</head>
<body>
<?php $page = $_GET['page']; 
if (!isset($page)) { 
require ('Templates/main.php'); } 
elseif ($page == 'avtorization') {
require('Templates/avtorization.php'); }
elseif ($page == 'registr') {
require('Templates/registr.php'); }
elseif ($page == 'shop') {
require('Templates/shop.php'); } 
elseif ($page == 'basket') {
require('Templates/basket.php'); } 
elseif ($page == 'product') {
$id=$_GET['id'];
require ('Templates/openedproduct.php'); } ?>
</body>
</html>