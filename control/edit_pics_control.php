<?php
session_start();
require ("../config/database.php");

$user_login = $_SESSION['login'];
$timestamp = mktime();
$image_name = $timestamp.'.png';

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("USE camagrudb");
	
	$statement = $db->prepare("INSERT INTO Images (user_login, image_name) VALUES (:user_login, :image_name)");
	$statement->bindValue(':user_login', $user_login);
	$statement->bindValue(':image_name', $image_name);
	$statement->execute();
	
	echo "Picture saved";
}
catch(PDOException $e) {
	echo "edit_pics_control : image insertion fail " . $e->getMessage();
}
?>
