<?php
if (!isset($_SESSION))
	session_start();

function display_gallery() {

require('../model/image.class.php');
require('../model/like.class.php');
require('../model/comment.class.php');
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

	echo '<div style="overflow-x:auto;">';
	echo '<table><tr><th>Pictures</th><th>User</th><th>Likes</th></tr>';
	foreach ($pics as $name)
	{
		$data = array('user_login' => $user_login, 'image_id' => $name['id']);
		$like = new Like($data);

		echo '<tr>';
		echo "<td><img src='../data/".$name['image_name']."' width=480px height=360px/></td>";
		echo "<td>".$name['user_login']."</td>";
		echo '<td>';
		$nb_likes = $like->allLikes($db);
		echo $nb_likes;
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		if($_SESSION['connect'] == 1) {
			$check = $like->check($db);
			if ($like->check($db))
				echo "<button id='like_button' onclick='unlike(this,".$name['id'].")'>Unlike</button>";
			else
				echo "<button id='like_button' onclick='like(this,".$name['id'].")'>Like</button>";

			echo "<button id='comment_button' onclick='add_comment(this,".$name['id'].")'>Add comment</button>";
		}
		echo '</tr>';
		echo '</td>';
		echo '<tr>';
		echo '<td>';
		$data = array('image_id' => $name['id']);
		$comment = new Comment($data);
		$res_com = $comment->image_comment($db);
		foreach ($res_com as $com)
		{
			echo "<li>".$com['user_login']." commented: ".$com['comment']."</li>";
		}
		echo '</br>';
		echo '</tr>';
		echo '</td>';
	}
	echo '</table>';
	echo '</div>';
}
catch(PDOException $e) {
	echo 'all pics display fail '.$e->getMessage();
}
};
?>
