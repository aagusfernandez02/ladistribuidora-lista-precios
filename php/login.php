<?php
session_start();

require_once('CreateDB.php');

$db_admins = new CreateDB(
  "ladistribuidora",
  "admins",
  "localhost",
  "root",
  "",
  "CREATE TABLE IF NOT EXISTS admins
  (id INT(4)NOT NULL AUTO_INCREMENT PRIMARY KEY,
  dni INT(8) NOT NULL,
  contrasenia VARCHAR(255) NOT NULL
);");

$dni = $_POST['dni'];
$contrasenia = $_POST['contrasenia'];

if ( $db_admins->checkAdminExists($dni,$contrasenia) ) {
  $_SESSION['admin'] = true;
  $_SESSION['estado_login'] = "LOGIN_OK";
} else {
  $_SESSION['admin'] = false;
  $_SESSION['estado_login'] = "LOGIN_FAIL";
}

header("Location: ../index.php");
die();

?>