<?php
if (!isset($_SESSION)) {
	session_start();
}
require('../model/image.class.php');

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

$dst_x = 0;
$dst_y = 0;
$src_x = 0;
$src_y = 0;
$res = imagecopyresampled($first, $second, $dst_x, $dst_y, $src_x, $src_y, $second_width, $second_height, $first_width, $first_height);
imagepng($first, $filename);

$data = array('user_login' => $user_login, 'image_name' => $file);

$image = new Image($data);
if ($image->imageDB() == false)
	echo 'image insertion failed ';

?>
