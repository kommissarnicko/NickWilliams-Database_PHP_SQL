<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_fief.php
-- DESCRIPTION: form for adding family to table
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
			<h1>Add family</h1>
		</div>
		
		<div>
			<table>
				<tr>
					<td>Existing families</td>
				</tr>
				<tr>
					<td>ID</td>
					<td>Name</td>
				</tr>
<?php
//creates table of ids, names from family table
if(!($stmt = $mysqli->prepare("SELECT family.id, family.name FROM family ORDER BY name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $id . "</td><td>" . $name . "</td><td></tr>";
}
$stmt->close();
?>
			</table>
		</div>
		
		<div>	
			<form method="post" action="add_family_process.php">
				<fieldset>
					<legend>Add family</legend>
					<p>Family Name: <input type="text" name="family_name" /></p>
					<p><input type="submit" /></p>
				</fieldset>
			</form>
		</div>
		
		<div>
			<p><a href="index.html">Return to main menu</a></p>
		</div>
	</body>
</html>