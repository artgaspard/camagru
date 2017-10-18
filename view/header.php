<div class="header">
<h2><a style="color:white" href="../index.php" title="Go back to homepage">HOME</a></h2>
<h2><a style="color:white;float:left;margin-left:125px;margin-top:-48px;" href="../view/gallery.php" title="Go to gallery">GALLERY</a></h2>
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
