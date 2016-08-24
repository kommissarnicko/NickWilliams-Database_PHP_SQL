<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - get_person_info.php
-- DESCRIPTION: allows user to select person to get information about
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
			<h1>View a person's attributes</h1>
		</div>
		
		<div>	
			<form method="post" action="get_person_info_result.php">
				<fieldset>
					<legend>Select person to view</legend>
					<p>Person: <select name="person_id">
<?php
//populates dropdown menu with all names from person table
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
					<p><input type="submit" value="View" /></p>
				</fieldset>
			</form>
		</div>
		
		<div>
			<p><a href="index.html">Return to main menu</a></p>
		</div>
	</body>
</html>