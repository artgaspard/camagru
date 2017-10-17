<?php
session_start();
require('../model/image.class.php');
require('../config/database.php');

	$user_login = $_SESSION['login'];
	try {
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->exec('USE camagrudb');

		$data = array('user_login' => $user_login);
		$image = new Image($data);
		$pics = $image->userPics($db);
		
		echo '<table>';
		foreach ($pics as $name)
		{
			echo '<tr>';
			echo "<td><img  src='../data/".$name['image_name']."'/></td>";
			echo '</tr>';
		}
		echo '</table>';
	}
	catch(PDOException $e) {
		echo 'pics display fail '.$e->getMessage();
	}

?>

