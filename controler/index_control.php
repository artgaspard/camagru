<?php
require("model/user.class.php");

$login = trim($_POST['login']);
$password = trim($_POST['password']);

if (isset($_POST['submit']))
{
	if ($_SESSION['connect'] == 0)
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
							$_SESSION['login'] = $login;
							echo "<meta http-equiv='refresh' content='0'>";
						}
						else
							echo "<p style='text-align:center;font-size:130%;'>Your account isn't activated, please check your mailbox and click on the confirmation link</p>";
					}
					else
						echo "<p style='text-align:center;font-size:130%;'>Wrong password</p>";
				}
				else
					echo "<p style='text-align:center;font-size:130%;'>This username doesn't exist</p>";
			}
			catch(PDOException $e) {
				echo "index_control - login failed " . $e->getMessage();
			}
		}
		else
			echo "You must enter a login and a password";
	}
	else
		echo "<p style='text-align:center;font-size:130%;'>You are already logged in</p>";
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

				$url = "http://".$_SERVER['HTTP_HOST']."/camagru/view/reset_password.php".'?login='.urlencode($login).'&crypt='.urlencode($crypt);
				$msg = "Clic on the following link to change your Camagru password: ".$url;
				mail($email, 'Change your Camagru password', $msg, "From: noreply@camagru.fr");
				echo "<p style='text-align:center;font-size:130%;'>A link has been sent to your email address.</p>";
			}
			else
				echo "<p style='text-align:center;font-size:130%;'>Unknown email address</p>";
		}
		catch(PDOException $e) {
			echo "index_control - new password failed " . $e->getMessage();
		}
	}
	else
		echo "<p style='text-align:center;font-size:130%;'>You must enter an email address</p>";
}
?>
