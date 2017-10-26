<?php
if (!isset($_SESSION))
	session_start();
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>camagru</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
</head>
<body>
<?php
include("view/header_index.php");
?>
	</br>
	<div id="title">
	<h1>WELCOME TO CAMAGRU</h1>
	</div>
	</br>
	</br>
	<div id="use_button">
	<button type='button'>
<?php
if ($_SESSION['connect'] == 1) {
	$link = "view/edit_pics_2.php";
	$message = "<p style='text-align:center;font-size:120%;'></p>";
}
else {
	$link = "index.php";
	$message = "<p style='text-align:center;font-size:120%;'>You must be logged-in to use Camagru</p>";
}
?>
	<a style='font-size:30px;' href='<?php echo "$link";?>'>Use Camagru now !</a></button>
	</div>
<?php
echo "</br></br><p style='text-align:center'>$message</p>";
?>
		</br>
	<div class="body">
		<form action="index.php" method="POST">
		<input type="text" name="login" placeholder="Login" value="" required/>
		<br/>
		<input type="password" name="password" placeholder="Password" value ="" required/>
		</br>
		<button type="submit" name="submit" class="pure-button pure-button-primary">Submit</button>
		</br>
		</form>
		Not a member ? <a href="./view/create_account.php">SIGN UP</a>
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
	</div>
	</body>
	<footer>
	</footer>
</html>

<?php
require("config/setup.php");
include("controler/index_control.php");
?>
