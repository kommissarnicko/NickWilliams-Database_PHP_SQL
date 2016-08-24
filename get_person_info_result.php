<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - get_person_info_result.php
-- DESCRIPTION: returns results for selected person from get_person_info.php
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
			<fieldset>
				<legend>
<?php
//prints person's name as an <h1> header at the top of page
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN family ON person.loyalty = family.id WHERE person.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['person_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $first_name, $middle_name, $last_name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<h1>Viewing " . $first_name . " " . $middle_name . " " . $last_name . "'s attributes</h1>";
}
$stmt->close();
?>
				</legend>
				<p>Loyalty: 
<?php
//prints name referenced on family table for under person.loyalty
if(!($stmt = $mysqli->prepare("SELECT person.id, family.name FROM person INNER JOIN family ON person.loyalty = family.id WHERE person.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['person_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $last_name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo $last_name;
}
$stmt->close();
?>
				 family</p>
				<p>Parents: 
					<ul>
<?php
//prints a list of all names of parents listed for this record in parent_child table
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN parent_child ON parent_child.pid = person.id INNER JOIN family ON person.loyalty = family.id WHERE parent_child.cid = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['person_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $first_name, $middle_name, $last_name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<li>" . $first_name . " " . $middle_name . " " . $last_name . "</li>";
}
$stmt->close();
?>
					</ul>
				</p>
				<p>Children: 
					<ul>
<?php
//prints a list of all names of children listed for this record in parent_child table
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN parent_child ON parent_child.cid = person.id INNER JOIN family ON person.loyalty = family.id WHERE parent_child.pid = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['person_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $first_name, $middle_name, $last_name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<li>" . $first_name . " " . $middle_name . " " . $last_name . "</li>";
}
$stmt->close();
?>
					</ul>
				</p>
				<p>Age: 
<?php
//prints age as listed in person table
if(!($stmt = $mysqli->prepare("SELECT person.id, person.age FROM person WHERE person.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['person_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $age)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo $age;
}
$stmt->close();
?>
				 years old</p>
			</fieldset>
		</div>
		
		<div>
			<p><a href="index.html">Return to main menu</a></p>
		</div>
	</body>
</html>