<?php
	try{
	$db = new PDO("mysql:host=localhost;dbname=registration_db", "root","");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
	echo "success";
	} catch(PDOException $e) {
		echo "Connection failed: ".$e->getMessage();
	}
?>