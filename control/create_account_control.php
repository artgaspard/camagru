<?php

require("../config/database.php");
require("../class/user.class.php");

$login = $_POST['login'];
$password = $_POST['password'];
$email = $_POST['email'];

	$data = array('login' => $login, 'password' => $password, 'email' => $email);
	
	$user = new User($data);

	$db = new PDO($DB_DSN."dbname=camagrudb", $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
