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
		<h2>CREATE YOUR CAMAGRU ACCOUNT</h2>
		</div>
		<div class="body">
		<form action="create_account.php" method="POST">
		<input type="text" name="login" placeholder="Login" value="" required/>
		</br>
		<input type="password" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must be at least 6 characters long, and contain at least one number and one uppercase and lowercase letter." required/>
		</br>
		<input type ="password" name="confirmpw" id="confirmpw" placeholder="Confirm Password" required/>
		</br>
		<input type="email" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email must match the following example: someone@something.com" required/>
		</br>
		</br>
		<button type="submit" class="pure-button pure-button-primary">Submit</button>
		</form>
	<script src="password_match.js" type="text/javascript"></script>
		</div>
	</body>
</html>

<?php
include("../controler/create_account_control.php")
?>
