<?php
session_start();
unset($_SESSION['user']);
header('Location: ../Templates/avtorization.php');
?>