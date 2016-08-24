<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_parent_child_process.php
-- DESCRIPTION: processes adding to parent_child relationship table by 
-- add_parent_child.php
------------------------------------------------------------------------------
-- NOTE! Error validation to ensure a person is not their own parent is done
-- in this script, not in the database itself
------------------------------------------------------------------------------>

<meta http-equiv="refresh" content="2;url=index.html">

<?php
header('Location:index.html');
//Turn on error reporting
ini_set('display_errors', 'On');
//Check to make sure we're not trying to make someone their own parent
if($_POST['parent_id'] == $_POST['child_id']){
	echo "Error: child cannot be own parent.";
	exit;
}
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","database-name","database-password","database-name");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
if(!($stmt = $mysqli->prepare("INSERT INTO parent_child(pid, cid) VALUES (?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ii",$_POST['parent_id'], $_POST['child_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to parent/child relationship table.";
}
?>