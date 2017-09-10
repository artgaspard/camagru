<?php

require("config/database.php");

try {
	
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "DROP DATABASE camagrudb";
	$db->exec($sql);
}

catch(PDOException $e) {
	echo "drop failed " . $e->getMessage();
	die();
}
?>
