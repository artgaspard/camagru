<?php

require("database.php");

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS camagrudb";
	$db->exec($sql);
	$sql = "USE camagrudb";
	$db->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS Users (
		id int AUTO_INCREMENT NOT NULL,
		login VARCHAR(60) NOT NULL,
		password VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL,
		crypt VARCHAR(255) NOT NULL,
		status INT,
		PRIMARY KEY (id)
		)";
	$db->exec($sql);
}

catch(PDOException $e) {
	echo "connection failed " . $e->getMessage();
	die();
}
?>
