<?php
if(!isset($_SESSION))
	 session_start();
include ("header.php");
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body>
	</br>
	<div id="title">
	<h2>ACCOUNT STATUS :</h2>
	</div>
	</br>
</body>
</html>

<?php
include("../controler/account_validation_control.php");
?>
