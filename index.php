<?php
	include("svc-dbconfig.php");
	
	$mysqli = new mysqli($DB_SECRETS["server"], $DB_SECRETS["username"], $DB_SECRETS["password"], $DB_SECRETS["database"]);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	if (!($smt = $mysqli->prepare(
		"SELECT category_id, label, sequence_no FROM lifelogger_categories ORDER BY sequence_no ASC, label ASC"
	))) { 
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$smt->execute();
	$smt->bind_result($dbCategoryId, $dbLabel, $dbSequenceNo);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
	<link rel="stylesheet" href="frameworks/bootstrap-3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="frameworks/bootstrap-3.3.0/css/bootstrap-theme.min.css">
	<script>console.log("loading jquery from ... frameworks/jquery-1.11.1.min.js");</script>
	<script src="frameworks/jquery-1.11.1.min.js"></script>
	<script>console.log("loading jquery from ... frameworks/bootstrap-3.3.0/js/bootstrap.min.js");</script>
	<script src="frameworks/bootstrap-3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<style>
	.mySpecialButton {
		font-size: 150%;
		margin-bottom: 6pt;
		text-align: left;
		width: 100%;
	}
</style>
<script>
	var myNow = new Date("2014-11-06 10:37:15");
	
	console.log(myNow.toLocaleString());
	function submitOption(optionId) {
		if (confirm(optionId)) {
			console.log(optionId);
			console.log($.post("svc-createNewEvent.php", {
				eventTimestamp: (new Date()).toISOString(),
				categoryId: optionId
			}));
		}
	}
</script>
<?php
	include("svc-pg-navbar.php");
	while ($smt->fetch()) {
		echo '<button class="btn btn-default mySpecialButton" onclick="submitOption('
			.$dbCategoryId
			.')">'
			.$dbLabel
			.'</button>'
			.'<br />';
	}
	$smt->close();
	$mysqli->close();
?>
</body>