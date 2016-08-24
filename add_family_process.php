<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_family_process.php
-- DESCRIPTION: processes adding to family table by add_family.php
------------------------------------------------------------------------------>

<meta http-equiv="refresh" content="2;url=index.html">

<?php
header('Location:index.html');
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","database-name","database-password","database-name");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
if(!($stmt = $mysqli->prepare("INSERT INTO family(name) VALUES (?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("s",$_POST['family_name']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to family table.";
}
?>