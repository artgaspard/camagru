<?php

class User
{
	public $login;
	public $password;
	public $email;

	public function insertion($db) {
		try {
			$statement = $db->exec("INSERT INTO Users (login, password, email)
				VALUES ($login, $password, $email)");
			}

	catch(PDOException $e) {
		echo "data insertion failed " . $e->getMessage();
		}
	}
}
?>
