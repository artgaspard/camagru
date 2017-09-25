<body>
	<div class="header">
	<a href="index.php" title="Go back to homepage">HOME</a>
	</div>
<?php
if ($_SESSION['connect'] == 1)
{
	echo "<form action='' method='POST'><button id='disconnect' name='disconnect'>Disconnect</button></form>";
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
