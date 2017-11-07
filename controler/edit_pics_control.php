<?php
if (!isset($_SESSION))
	session_start();
require('../model/image.class.php');
require('../config/database.php');

$image = $_POST['image_canvas'];
$image_incrust = $POST['image_incrust'];
$user_login = $_SESSION['login'];

$timestamp = mktime();
$file = $timestamp.'.png';
$filename = '../data/'.$file;

$tmp = explode(',', $image);
$data = $tmp[1];
$data = str_replace(' ','+',$data);
$data = base64_decode($data);

file_put_contents($filename, $data);

$first = imagecreatefrompng($filename);
$second = imagecreatefrompng($image_incrust);
$first_size = getimagesize($filename);
$second_size = getimagesize($image_incrust);

$first_width = $first_size[0];
$first_height = $first_size[1];
$second_width = $second_size[0];
$second_height = $second_size[1];

$res = imagecopyresampled($first, $second, 0, 0, 0, 0, $second_width, $second_height, $first_width, $first_height);
imagepng($first, $filename);

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "USE camagrudb";
	$db->exec($sql);

	$data = array('user_login' => $user_login, 'image_name' => $file);
	$image = new Image($data);
	$image->imageDB($db);
}
catch(PDOException $e) {
	echo 'image insertion fail '.$e->getMessage();
}
?>
