<?php
if (!isset($_SESSION))
	session_start();

function display_gallery() {

require('../model/image.class.php');
require('../model/like.class.php');
require('../config/database.php');

$user_login = $_SESSION['login'];
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('USE camagrudb');

	$data = array('user_login' => $user_login);
	$image = new Image($data);

	$pics_per_page = 5;
	$total = $image->totalPics($db);
	$nb_pages = ceil($total/$pics_per_page);
	echo '<p align="center">Page : ';
	for ($i=1; $i<=$nb_pages; $i++)
	{
		echo '<a href="gallery.php?page='.$i.'">' . $i . '</a> ';
	}
	echo '</p>';
	if (isset($_GET['page']) && is_numeric($_GET['page']) && ($_GET['page']>0))
	{
		$page = intval($_GET['page']);
		if ($page > $nb_pages)
		{
			$page = $nb_pages;
		}
	}
	else
	{
		$page = 1;
	}
	$first_entry = $page * $pics_per_page-$pics_per_page;
	$pics = $image->pagePics($db, $first_entry, $pics_per_page);

	echo '<table><tr><th>Pictures</th><th>User</th><th>Likes</th></tr>';
	foreach ($pics as $name)
	{
		echo '<tr>';
		echo "<td><img src='../data/".$name['image_name']."'/></td>";
		echo "<td>".$name['user_login']."</td>";
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		$data = array('user_login' => $user_login, 'image_id' => $name['id']);
		$like = new Like($data);
	$check = $like->check($db);
	echo ('check ='.$check);
		if ($like->check($db))
			echo "<button id='like_button' onclick=''>Unlike</button>";
		else
			echo "<button id='like_button' onclick='like(this,".$name['id'].")'>Like</button>";
	}
		echo '</tr>';
		echo '</td>';
	echo '</table>';
}
catch(PDOException $e) {
	echo 'all pics display fail '.$e->getMessage();
}
}
?>
