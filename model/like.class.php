<?php
if(!isset($_SESSION))
	session_start();

class Like
{
	public $id;
	public $image_id;
	public $user_login;
	public $date;

	public function __construct($data)
	{
		if(is_array($data))
		{
			if(isset($data['id']))
				$this->id = $data['id'];
			if(isset($data['image_id']))
				$this->image_id = $data['image_id'];
			if(isset($data['user_login']))
				$this->user_login = $data['user_login'];
			if(isset($data['date']))
				$this->date = $data['date'];
		}
	}

	public function check($db)
	{
		$image_id = $this->image_id;
		$user_login = $this->user_login;
		$statement = $db->prepare('SELECT id, date FROM Likes WHERE image_id ="'.$image_id.'" AND user_login = "'.$user_login.'"');
		$statement->execute();
		$res = $statement->fetchAll();
		if (count($res) === 0)
			return(false);
		$this->id = $res[0]['id'];
		$this->date = $res[0]['date'];
		return(true);
	}

	public function create($db)
	{
		$image_id = $this->image_id;
		$user_login = $this->user_login;
		
		$statement = $db->prepare("INSERT INTO Likes (image_id, user_login) VALUES (:image_id, :user_login)");
		$statement->bindParam(':image_id', $image_id);
		$statement->bindParam(':user_login', $user_login);
		return($statement->execute());
	}

	public function unlike($db)
	{
		$image_id = $this->image_id;
		$user_login = $this->user_login;

		$statement = $db->prepare('DELETE FROM Likes WHERE image_id ="'.$image_id.'" AND user_login = "'.$user_login.'"');
		return($statement->execute());
	}

	public function allLikes($db)
	{
		$image_id = $this->image_id;

		$statement = $db->prepare('SELECT count(l.image_id) likes FROM Likes l INNER JOIN Images i ON l.image_id = i.id WHERE l.image_id="'.$image_id.'"');
		$statement->execute();
		return($statement->fetchColumn());
	}
}
?>
