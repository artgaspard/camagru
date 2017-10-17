<?php
session_start();

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

	public function imageDB($db)
	{
		$user_login = $this->user_login;
		$image_name = $this->image_name;	
		
		$statement = $db->prepare("INSERT INTO Images (user_login, image_name) VALUES (:user_login, :image_name)");
		$statement->bindParam(':user_login', $user_login);
		$statement->bindParam(':image_name', $image_name);
		$statement->execute();
	
		echo "Picture saved";
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
}
?>
