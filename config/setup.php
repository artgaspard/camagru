<?php

require("database.php");

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS camagrudb";
	$db->exec($sql);
//	$sql = "USE camagrudb;
//			CREATE TABLE 'id' (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY)";
//	$db->exec($sql);
	echo "connection success";
}

catch(PDOException $e) {
	echo "connection failed " . $e->getMessage();
	die();
}
 
?>
