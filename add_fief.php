<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_fief.php
-- DESCRIPTION: form for adding fief to table
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
			<h1>Add fiefdom</h1>
		</div>
		
		<div>
			<table>
				<tr>
					<td>Existing fiefdoms</td>
				</tr>
				<tr>
					<td>ID</td>
					<td>Name</td>
					<td>Owner</td>
				</tr>
<?php
//creates table of ids, names, and family names of fief owners from fief table
if(!($stmt = $mysqli->prepare("SELECT fief.id, fief.name, family.name FROM fief INNER JOIN family ON fief.owner = family.id ORDER BY id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name, $owner)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $id . "</td><td>" . $name . "</td><td>" . $owner . "</td></tr>";
}
$stmt->close();
?>
			</table>
		</div>
		
		<div>	
			<form method="post" action="add_fief_process.php">
				<fieldset>
					<legend>Add fiefdom</legend>
					<p>Fiefdom name: <input type="text" name="fief_name" /></p>
					<p>Owner: <select name="owner">
<?php
//populates dropdown with names of families from family table
if(!($stmt = $mysqli->prepare("SELECT id, name FROM family"))){
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