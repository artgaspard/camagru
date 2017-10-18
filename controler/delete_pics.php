<?php
session_start();
require('../model/image.class.php');
require('../config/database.php');

$user_login = $_SESSION['login'];
$image_name = $_POST['image_name'];
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('USE camagrudb');

	$img_data = basename($image_name);
	$data = array('user_login' => $user_login, 'image_name' => $img_data);
	$image = new Image($data);
	$pics = $image->deletePics($db);
	unlink('../data/'.$img_data);
}
catch(PDOException $e) {
	echo 'delete pics fail '.$e->getMessage();
}
?>
