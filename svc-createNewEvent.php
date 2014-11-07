<?php
	include("svc-dbconfig.php");
	$postEventTimestamp = $_POST['eventTimestamp'];
	$postCategoryId     = $_POST['categoryId'];
	
	$mysqli = new mysqli($DB_SECRETS["server"], $DB_SECRETS["username"], $DB_SECRETS["password"], $DB_SECRETS["database"]);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	if (!($smt = $mysqli->prepare(
		"INSERT INTO lifelogger_events (event_timestamp, category_id) VALUES (?, ?)"
	))) { 
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$smt->bind_param("si", $postEventTimestamp, $postCategoryId)) {
		echo "Binding parameters failed: (" . $smt->errno . ") " . $smt->error;
	}
	$smt->execute();
	
	$mysqli->close();
?>