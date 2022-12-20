<?php
session_start();
$_SESSION['admin'] = false;
$_SESSION['estado_login'] = "LOGOUT";
header("Location: ../index.php");
die();
?>