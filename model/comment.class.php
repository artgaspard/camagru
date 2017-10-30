<?php
if (!isset($_SESSION))
	session_start;

class Comment
{
	public $id;
	public $comment;
	public $user_login;
	public $image_id;
	public $date;
	
	public function __construct($data)
	{
		if(is_array($data))
		{
			if(isset($data['id']))
				$this->id = $data['id'];
			if(isset($data['comment']))
				$this->comment = htmlspecialchars($data['comment']);
			if(isset($data['user_login']))
				$this->user_login = $data['user_login'];
			if(isset($data['image_id']))
				$this->image_id = $data['image_id'];
			if(isset($data['date']))
				$this->date = $data['date'];
		}
	}

	public function create($db)
	{
		$comment = $this->comment;
		$user_login = $this->user_login;
		$image_id = $this->image_id;

		$statement = $db->prepare('INSERT INTO Comments (comment, user_login, image_id) VALUES (:comment, :user_login, :image_id)');
		$statement->bindParam(':comment', $comment);
		$statement->bindParam(':user_login', $user_login);
		$statement->bindParam(':image_id', $image_id);
		return($statement->execute());
	}

	public function image_comment($db)
	{
		$image_id = $this->image_id;

		$statement = $db->prepare("SELECT id, comment, user_login, image_id FROM Comments WHERE image_id = :image_id ORDER BY date DESC");
		$statement->bindParam(':image_id', $image_id);
		$statement->execute();
		$com = $statement->fetchAll();
		return ($com);
	}
}
