<?php

require '/../config/setup.php';
require '/../class/user.class.php';

$login = trim($_POST['login']);
$password = trim($_POST['password']);

if (isset($_POST['submit']))
{
	if (!(empty($login) && !(empty($password)))
	{
		try
		{
			$password = hash('whirlpool', $password);
			$data = array('login' => $login, 'password' => $password)
			$user = new User($data);
			if ($user->Check_login($db) == true)
			{
				echo "username exists";
				//if (check password)
			}
			else
				echo "This username doesn't exist";
		}
		catch(PDOException $e) {
			echo "index_control - login failed " . $e->getMessage();
		}
	}
	else
		echo "You must enter a login and a password";
}
?>
