<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_lord_vassal_process.php
-- DESCRIPTION: processes adding to lord_vassal relationship table by 
-- add_lord_vassal.php
------------------------------------------------------------------------------
-- NOTE! Error validation to ensure a family is not its own vassal is done
-- in this script, not in the database itself
------------------------------------------------------------------------------>

<meta http-equiv="refresh" content="2;url=index.html">

<?php
header('Location:index.html');
//Turn on error reporting
ini_set('display_errors', 'On');
//Check to make sure we're not trying to make a family their own vassal
if($_POST['lord_id'] == $_POST['vassal_id']){
	echo "Error: lord cannot be their own vassal.";
	exit;
}
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","database-name","database-password","database-name");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
if(!($stmt = $mysqli->prepare("INSERT INTO lord_vassal(lid, vid) VALUES (?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ii",$_POST['lord_id'], $_POST['vassal_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to lord/vassal relationship table.";
}
?>