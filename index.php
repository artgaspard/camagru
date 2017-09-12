<?php
if (!isset($_SESSION))
{
	session_start();
	$_SESSION['connect'] = 0;
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>camagru</title>
	</head>
	<body>
		</br>
		WELCOME TO CAMAGRU
		</br>
		</br>
		<form action="index.php" method="POST">
		<input type="text" name="login" placeholder="Login" value="" required/>
		<br/>
		<input type="password" name="password" placeholder="Password" value ="" required/>
		</br>
		<button type="submit" name="submit" class="pure-button pure-button-primary">Submit</button>
		</br>
		</form>
		Not a member ? <a href="./content/create_account.php">SIGN UP</a>
		</br>
		</br>
		Forgot your password ?
		</br>
		<form action="index.php" method="POST">
		<input type="email" name="emailpw" placeholder="Email">
		</br>
		<button type="submit" name="newpw" class="pure-button pure-button-primary">Send new password</button>
		</br>
		</form>
		</br>
	</body>
	<footer>
	</footer>
</html>

<?php
require("config/setup.php");
include("control/index_control.php");
?>
