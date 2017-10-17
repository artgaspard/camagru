<?php

class User
{
	public $login;
	public $password;
	public $email;
	public $crypt;
	public $status;

	public function	__construct($data)
	{
		if (is_array($data))
		{
			if (isset($data['login']))
				$this->login = $data['login'];
			if (isset($data['password']))
				$this->password = $data['password'];
			if (isset($data['email']))
				$this->email = $data['email'];
			if (isset($data['crypt']))
				$this->crypt = $data['crypt'];
			$this->status = 0;
		}
	}

	public function Check_login($db)
	{
		$sql = "SELECT login FROM Users WHERE login = :login";
		$statement = $db->prepare($sql);
		$statement->bindValue('login', $this->login);
		$statement->execute();
		$count = count($statement->fetchAll());
		if ($count > 0)
			return false;
		return true;
	}

	public function Check_email($db)
	{
		$sql = "SELECT email FROM Users WHERE email = :email";
		$statement = $db->prepare($sql);
		$statement->bindValue('email', $this->email);
		$statement->execute();
		$count = count($statement->fetchAll());
		if ($count > 0)
			return false;
		return true;
	}

	public function Check_password($db)
	{
		$sql = "SELECT password FROM Users WHERE login = :login AND password = :password";
		$statement = $db->prepare($sql);
		$statement->bindValue('login', $this->login);
		$statement->bindValue('password', $this->password);
		$statement->execute();
		$count = count($statement->fetchAll());
		if ($count > 0)
			return false;
		return true;
	}

	public function Check_status($db)
	{
		$sql = "SELECT status FROM Users WHERE login = :login";
		$statement = $db->prepare($sql);
		$statement->bindValue('login', $this->login);
		$statement->execute();
		$row = $statement->fetch();
		$stat = $row['status'];
		if ($stat == 1)
			return false;
		return true;
	}

	public function Get_data_email($db)
	{
		$sql = "SELECT login, password, crypt, status FROM Users WHERE email = :email";
		$statement = $db->prepare($sql);
		$statement->bindValue('email', $this->email);
		$statement->execute();
		$data = $statement->fetchAll();
		$res = $data[0];
		$this->login = $res['login'];
		$this->password = $res['password'];
		$this->crypt = $res['crypt'];
		$this->status = $res['status'];
	}
}
?>
