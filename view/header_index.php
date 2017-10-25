<?php
if (!isset($_SESSION))
	session_start();
if ($_SESSION['connect'] == 1) {
	$link = './view/edit_pics_2.php';
}
else {
	$link = './index.php';
}
?>
<div class="header">
<h2><a style="color:white" href="index.php">HOME</a></h2>
<h2><a style="color:white;float:left;margin-left:125px;margin-top:-48px;" href="view/gallery.php">GALLERY</a></h2>
<h2><a style="color:white;float:left;margin-left:290px;margin-top:-48px;" href='<?php echo "$link";?>' title="Use Camagru">CAMAGRU</a></h2>

<?php
if ($_SESSION['connect'] == 1)
{
	echo "<form action='' method='POST'><button id='disconnect' name='disconnect' style='float:right;margin-top:-45px;font-size:20px;'>Disconnect</button></form>";
	if (isset($_POST['disconnect']))
	{
		$_SESSION['connect'] = 0;
		unset($_SESSION['connect']);
		echo "<meta http-equiv='refresh' content='0'>";
	}
}
else
	$_SESSION['connect'] = 0;
?>
</div>
