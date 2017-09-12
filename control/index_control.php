<?php
require("class/user.class.php");

$login = trim($_POST['login']);
$password = trim($_POST['password']);

if (isset($_POST['submit']))
{
	if (!(empty($login)) && !(empty($password)))
	{
		try
		{
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("USE camagrudb");

			$password = hash('whirlpool', $password);
			$data = array('login' => $login, 'password' => $password);
			$user = new User($data);
			
			if ($user->Check_login($db) == false)
			{
				if ($user->Check_password($db) == false)
				{
					if ($user->Check_status($db) == false)
					{
						$_SESSION['connect'] = 1;
						echo "You are now logged in Camagru";
					}
					else
						echo "Your account isn't activated, please check your mailbox and click on the confirmation link";
				}
				else
					echo "Wrong password";
			}
			else
				echo "This username doesn't exist";
		}
		catch(PDOException $e) {
			echo "index_control - login failed " . $e->getMessage();
		}
//	$connect = $_SESSION['connect'];
//	echo " connection = $connect";
	}
	else
		echo "You must enter a login and a password";
}

else if (isset($_POST['newpw']))
{
	$email = trim($_POST['emailpw']);
	if (!(empty($email)))
	{
		try
		{
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("USE camagrudb");

			$data = array('email' => $email);
			$user = new User($data);
			if ($user->Check_email($db) == false)
			{
				$user->Get_data_email($db);
				$login = $user->login;
				$crypt = $user->crypt;

				$url = "http://".$_SERVER['HTTP_HOST']."/camagru/git/content/reset_password.php".'?login='.urlencode($login).'&crypt='.urlencode($crypt);
				$msg = "Clic on the following link to change your Camagru password: ".$url;
				mail($email, 'Change your Camagru password', $msg, "From: noreply@camagru.fr");
				echo "A link has been sent to your email address. ";
			}
			else
				echo "Unknown email address";
		}
		catch(PDOException $e) {
			echo "index_control - new password failed " . $e->getMessage();
		}
	}
	else
		echo "You must enter an email address";
}
?>
