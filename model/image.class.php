<?php
session_start();
require ("../config/database.php");

class Image
{
	public $user_login;
	public $image_name;

	public function __construct($data)
	{
		if(is_array($data))
		{
			if(isset($data['user_login']))
				$this->user_login = $data['user_login'];
			if(isset($data['image_name']))
				$this->image_name = $data['image_name'];
		}
	}

	public function imageDB()
	{
		try {
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("USE camagrudb");
	
			$statement = $db->prepare("INSERT INTO Images (user_login, image_name) VALUES (:user_login, :image_name)");
		echo 'TEST';
			$statement->bindValue(':user_login', $user_login);
			$statement->bindValue(':image_name', $image_name);
			$statement->execute();
	
			echo "Picture saved";
			return true;
		}
		catch(PDOException $e) {
			echo "model - image.class : image insertion fail " . $e->getMessage();
			return false;
		}

	}
}
?>
