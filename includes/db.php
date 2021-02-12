<?php

	$dsn = "mysql:host=localhost;dbname=rsblog";

	try {
		$pdo = new PDO($dsn, 'root', '');
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

?>