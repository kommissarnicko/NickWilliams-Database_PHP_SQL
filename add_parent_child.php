<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_person.php
-- DESCRIPTION: form for creating a parent/child relationship between
-- two existing person records
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
			<h1>Create parent-child relationship</h1>
		</div>
		
		<div>
			<table>
				<tr>
					<td>Existing people</td>
				</tr>
				<tr>
					<td>ID</td>
					<td>First Name</td>
					<td>Middle Name</td>
					<td>Last Name</td>
					<td>Age</td>
				</tr>
<?php
//prints a table of all ids, first/middle names, and last names (loyalty) from person table
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name, person.age FROM person INNER JOIN family ON person.loyalty = family.id ORDER BY family.name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $first_name, $middle_name, $last_name, $age)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $id . "</td><td>" . $first_name . "</td><td>" . $middle_name . "</td><td>" . $last_name. "</td><td>" . $age. "</td></tr>";
}
$stmt->close();
?>
			</table>
		</div>
		
		<div>	
			<form method="post" action="add_parent_child_process.php">
				<fieldset>
					<legend>Select parent and child</legend>
					<p>Parent: <select name="parent_id">
<?php
//populates dropdown with all first, middle names and last names (loyalties) from person table
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN family ON person.loyalty = family.id ORDER BY family.name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $first_name, $middle_name, $last_name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo '<option value=" '. $id . ' "> ' . $first_name . ' ' . $middle_name . ' ' . $last_name . '</option>\n';
}
$stmt->close();
?>
						</select></p>
						<p>Child: <select name="child_id">
<?php
//populates dropdown with all first, middle names and last names (loyalties) from person table
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN family ON person.loyalty = family.id ORDER BY family.name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $first_name, $middle_name, $last_name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo '<option value=" '. $id . ' "> ' . $first_name . ' ' . $middle_name . ' ' . $last_name . '</option>\n';
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