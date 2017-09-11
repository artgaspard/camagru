<?php
require("../config/database.php");

if (!(empty($_GET['login'])) || !(empty($_GET['crypt'])))
{
	$login = trim($_GET['login']);
	$crypt = trim($_GET['crypt']);

	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "USE camagrudb";
		$db->exec($sql);

		$statement = $db->prepare("SELECT crypt, status FROM Users WHERE login = :login");
		if ($statement->execute(array(':login' => $login)) && $row = $statement->fetch())
		{
			$cryptdb = $row['crypt'];
			$status = $row['status'];
		}
		if ($status == 1)
			echo "Account already activated";
		else
		{
			if ($crypt == $cryptdb)
			{
				$statement = $db->prepare("UPDATE Users SET status = 1 WHERE login = :login");
				$statement->bindValue(':login', $login, PDO::PARAM_STR);
				$statement->execute();
				echo "Congratulations, your account has been activated :) ";
			}
			else
				echo "Your account can't be activated (crypt missmatch)";
		}
	}

	catch(PDOException $e) {
		echo "validation_control : data matching failed " . $e->getMessge();
	}
}
else
	echo "validation_control : missing login or crypt ";
?>
