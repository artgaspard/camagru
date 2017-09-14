
<body>
	<header>
		<div class="header">
		<a href="../index.php" title="Go back to homepage">HOME</a>
		</div>
<?php
if ($_SESSION['connect'] == 1)
{
	echo '<button id="disconnect" name="disconnect">Disconnect</button>';
	if (isset($_POST['disconnect']))
		$_SESSION['connect'] = 0;
	// utiliser un script js pour recuperer l'event 'disconnect'
}

	$connect = $_SESSION['connect'];
	echo "logged in = $connect";

?>
		</br>
	</header>
