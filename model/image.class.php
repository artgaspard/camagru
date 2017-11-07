<?php
if(!isset($_SESSION))
	session_start();

class Image
{
	public $id;
	public $user_login;
	public $image_name;
	public $image;
	public $image_type;

	public function __construct($data)
	{
		if(is_array($data))
		{
			if(isset($data['id']))
				$this->id = $data['id'];
			if(isset($data['user_login']))
				$this->user_login = $data['user_login'];
			if(isset($data['image_name']))
				$this->image_name = $data['image_name'];
		}
	}

	public function imageDB($db)
	{
		$user_login = $this->user_login;
		$image_name = $this->image_name;	
		
		$statement = $db->prepare("INSERT INTO Images (user_login, image_name) VALUES (:user_login, :image_name)");
		$statement->bindParam(':user_login', $user_login);
		$statement->bindParam(':image_name', $image_name);
		$statement->execute();
	}

	public function userPics($db)
	{
		$user_login = $this->user_login;

		$statement = $db->prepare("SELECT image_name, user_login FROM Images WHERE user_login = :user_login ORDER BY date DESC");
		$statement->bindParam(':user_login', $user_login);
		$statement->execute();
		$res = $statement->fetchAll();
		return ($res);
	}

	public function deletePics($db)
	{
		$user_login = $this->user_login;
		$image_name = $this->image_name;

		$statement = $db->prepare("DELETE FROM Images WHERE user_login = :user_login AND image_name = :image_name");
		$statement->bindParam(':user_login', $user_login);
		$statement->bindParam(':image_name', $image_name);
		$statement->execute();
	}

	public function allPics($db)
	{
		$user_login = $this->user_login;
		$image_name = $this->image_name;

		$statement = $db->prepare("SELECT user_login, image_name FROM Images ORDER BY date DESC");
		$statement->bindParam(':user_login', $user_login);
		$statement->bindParam(':image_name', $image_name);
		$statement->execute();
		$res = $statement->fetchAll();
		return ($res);
	}

	public function totalPics($db)
	{
		$statement = 'SELECT count(*) AS total FROM Images';
		$total = $db->query($statement)->fetchColumn();
		return($total); 
	}

	public function pagePics($db, $first_entry, $pics_per_page)
	{
		$statement = $db->prepare("SELECT id, user_login, image_name FROM Images ORDER BY date DESC LIMIT :first_entry, :pics_per_page");
		$statement->bindParam(':first_entry', $first_entry, PDO::PARAM_INT);
		$statement->bindParam(':pics_per_page', $pics_per_page, PDO::PARAM_INT);
		$statement->execute();
		$res = $statement->fetchAll();
		$statement->closeCursor();
		return($res);
	}
}
?>
