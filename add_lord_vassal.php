<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_lord_vassal.php
-- DESCRIPTION: form for creating a lord/vassal relationship between
-- two existing family records
------------------------------------------------------------------------------>

<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","database-name","database-password","database-name");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS 340 Database Project</title>
	</head>
	
	<body>
		<div>
			<h1>Create lord-vassal relationship</h1>
		</div>
		
		<div>
			<table>
				<tr>
					<td>Existing families</td>
				</tr>
				<tr>
					<td>ID</td>
					<td>Family Name</td>
				</tr>
<?php
//prints a table of all family names from family table
if(!($stmt = $mysqli->prepare("SELECT family.id, family.name FROM family ORDER BY family.name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $id . "</td><td>" . $name . "</td></tr>";
}
$stmt->close();
?>
			</table>
		</div>
		
		<div>	
			<form method="post" action="add_lord_vassal_process.php">
				<fieldset>
					<legend>Select lord and vassal</legend>
					<p>Lord: <select name="lord_id">
<?php
//populates dropdown with all family names from family table
if(!($stmt = $mysqli->prepare("SELECT id, name FROM family ORDER BY name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
}
$stmt->close();
?>
						</select></p>
					<p>Vassal: <select name="vassal_id">
<?php
//populates dropdown with all family names from family table --THAT DO NOT HAVE A LORD YET!--
if(!($stmt = $mysqli->prepare("SELECT family.id, family.name FROM family WHERE family.id NOT IN(SELECT family.id FROM family INNER JOIN lord_vassal ON family.id = lord_vassal.vid)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
}
$stmt->close();
?>
						</select></p>
					<p><input type="submit" /></p>
				</fieldset>
			</form>
		</div>
		
		<div>
			<p><a href="index.html">Return to main menu</a></p>
		</div>
	</body>
</html>