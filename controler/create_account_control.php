<?php
require("../config/database.php");
require("../model/user.class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$login = trim($_POST['login']);
	$password = trim($_POST['password']);
	$email = trim($_POST['email']);

	if (!(empty($login)) || !(empty($password)) || !(empty($email))) 
	{
		try
		{
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "USE camagrudb";
			$db->exec($sql);

			$password = hash('whirlpool', $password);
			$crypt = sha1(microtime(TRUE)*100000);
			$status = 0;
			$data = array('login' => $login, 'password' => $password, 'email' => $email, 'crypt' => $crypt, 'status' => $status);

			$user = new User($data);
			if ($user->Check_login($db) == false)
				echo "<p style='text-align:center;font-size:130%;'>Username already exists</p>";
			else if ($user->Check_email($db) == false)
				echo "<p style='text-align:center;font-size:130%;'>Email already exists</p>";
			else
			{
				$sql = "INSERT INTO Users (login, password, email, crypt, status) VALUES (:login, :password, :email, :crypt, :status)";
				$statement = $db->prepare($sql);
				$statement->bindValue('login', $login, PDO::PARAM_STR);
				$statement->bindValue('password', $password, PDO::PARAM_STR);
				$statement->bindValue('email', $email, PDO::PARAM_STR);
				$statement->bindValue('crypt', $crypt, PDO::PARAM_STR);
				$statement->bindValue('status', $status, PDO::PARAM_INT);
				$statement->execute();

// change url path if necessary

				$url = "http://".$_SERVER['HTTP_HOST']."/camagru/view/account_validation.php".'?login='.urlencode($login).'&crypt='.urlencode($crypt);
				$msg = "Clic on the following link to confirm your subscription to Camagru: ".$url;
				mail($email, 'Activate your Camagru account', $msg, "From: noreply@camagru.fr");
				echo "<p style='text-align:center;font-size:130%;'>Thanks for subscribing to Camagru, a confirmation link has been sent to your email address.</p>";
			}
		}

		catch(PDOException $e) {
			echo "account_control - data insertion failed " . $e->getMessage();
		}
	}
}
?>
