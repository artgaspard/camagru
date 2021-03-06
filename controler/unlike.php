<?php
if (!isset($_SESSION))
	session_start();
include('../config/database.php');
include('../model/like.class.php');

$image_id = $_POST['image_id'];
$user_login = $_SESSION['login'];

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('USE camagrudb');

	$data = array('image_id' => $image_id, 'user_login' => $user_login);
	$like = new Like($data);
	if ($like->check($db))
	{
		if (!$like->unlike($db))
		{
			echo 'unlike failed';
			return;
		}
	}
	else
		echo 'unlike success';
	return;
}
catch(PDOException $e) {
	echo 'unlike db failed '.$e->getMessage();
}
?>
