<?php
if (!isset($_SESSION))
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
		<h2>CHANGE YOUR PASSWORD</h2>
		</div>
		</br>
		</br>
		<div class="body">
		<form action="" method="POST">
		<input type="password" name="password" id="password" placeholder="New password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must be at least 6 characters long, and contain at least one number and one uppercase and lowercase letter." required/>
		</br>
		<input type ="password" name="confirmpw" id="confirmpw" placeholder="Confirm new password" required/>
		</br>
		<button type="submit" name="submit" class="pure-button-primary">Submit</button>
		</br>
		</form>
	<script src="password_match.js" type="text/javascript"></script>
	</div>
	</body>
</html>
<?php
include ("../controler/reset_password_control.php");
?>
