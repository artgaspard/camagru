<?php
if(!isset($_SESSION))
	session_start();
require('../config/database.php');
require('../model/comment.class.php');
require('../model/user.class.php');

$image_id = $_POST['image_id'];
$user_login = $_SESSION['login'];
$comment = $_POST['comment'];

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('USE camagrudb');

	$data = array('image_id' => $image_id, 'user_login' => $user_login, 'comment' => $comment);
	$com = new Comment($data);
	if ($com->create($db))
	{
		$user = new User($data);
		$com_login = $user->com_login($db, $image_id);
		$com_email = $user->com_email($db, $image_id);
		$msg = ''.$com_login.' left a new comment on one of your Camagru picture : '.$comment;
		mail($com_email, 'You\'ve got a new comment on your picture !', $msg);
	}
	else
		echo 'comment creation failed';
	return;
}
catch(PDOException $e) {
	echo 'comment db failed '.$e->getMessage();
}
?>
