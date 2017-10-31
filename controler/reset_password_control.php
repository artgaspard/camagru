<?php
require ("../config/database.php");
require ("../model/user.class.php");

if (isset($_POST['submit']))
{
	if (!(empty($_GET['login'])) && !(empty($_GET['crypt'])) && !(empty($_POST['password'])))
	{
		$login = trim($_GET['login']);
		$crypt = trim($_GET['crypt']);
		$password = trim($_POST['password']);
		try
		{
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("USE camagrudb");

			$password = hash('whirlpool', $password);
			$statement = $db->prepare("SELECT crypt FROM Users WHERE login = :login");
			if ($statement->execute(array(':login' => $login)) && $row = $statement->fetch())
				$cryptdb = $row['crypt'];
			if ($crypt == $cryptdb)
			{
				$statement = $db->prepare("UPDATE Users SET password = :password WHERE login = :login");
				$statement->bindValue(':login', $login);
				$statement->bindValue('password', $password);
				$statement->execute();
				echo "<p style='text-align:center;font-size:130%;'>Your password has been successfully changed</p>";
			}
			else
				echo "<p style='text-align:center;font-size:130%;'>Can't change your password (crypt missmatch)</p>";
		}
		catch(PDOException $e) {
			echo "reset_password_control : reset password fail " . $e->getMessage();
		}
	}
	else
		echo "reset_password_control : missing login or crypt or password";
}
?>
