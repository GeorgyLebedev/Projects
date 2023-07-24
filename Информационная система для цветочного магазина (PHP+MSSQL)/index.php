<?php 
require_once ("classes.php");
session_start();
$page = $_GET['page']; 
if (!isset($page) || $page == 'auth') { 
require ('Templates/auth.php'); } 
elseif ($page == 'main') {
require('Templates/main.php'); }
elseif ($page == 'mod') {
require('Templates/mod.php'); }
elseif ($page == 'reports') {
require('Templates/reports.php'); }
elseif ($page == 'useradd') {
require ('Templates/useradd.php'); } 
elseif ($page == 'help') {
require ('Templates/help.php'); } ?>
<!DOCTYPE html>
<html lang="ru" >
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="Templates/styles.css" />
<title>
FlowerShop
</title>
</head>
<body>
<header>
</header>
<footer>
</footer>
</body>
</html>