<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - get_fief_info_result.php
-- DESCRIPTION: returns results for selected family from get_family_info.php
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
//populates <h1> header with name of family at top of page
if(!($stmt = $mysqli->prepare("SELECT family.id, family.name FROM family WHERE family.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['family_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<h1>Viewing " . $name . " Family's attributes</h1>";
}
$stmt->close();
?>
				</legend>
				<p>Vassals: 
					<ul>
<?php
//prints a list of all family names for this record referenced as vassals on lord_vassal table
if(!($stmt = $mysqli->prepare("SELECT family.id, family.name FROM family INNER JOIN lord_vassal ON lord_vassal.vid = family.id WHERE lord_vassal.lid = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['family_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<li>" . $name . "</li>";
}
$stmt->close();
?>
					</ul>
				</p>
				<p>Liege: 
					<ul>
<?php
//prints family name for this record referred to as lord on lord_vassal table
if(!($stmt = $mysqli->prepare("SELECT family.id, family.name FROM family INNER JOIN lord_vassal ON lord_vassal.lid = family.id WHERE lord_vassal.vid = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['family_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<li>" . $name . "</li>";
}
$stmt->close();
?>
					</ul>
				</p>
				<p>Owned fiefdoms:
					<ul>
<?php
//prints a list of all fief names referenced as owned by this record on fief table
if(!($stmt = $mysqli->prepare("SELECT fief.id, fief.name FROM fief WHERE fief.owner = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['family_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<li>" . $name . "</li>";
}
$stmt->close();
?>
					</ul>
				 </p>
				 <p>Family members:
					<ul>
<?php
//prints a list of all persons who have this family listed as their loyalty
if(!($stmt = $mysqli->prepare("SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN family ON person.loyalty = family.id WHERE family.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['family_id']))){
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
			</fieldset>
		</div>
		
		<div>
			<p><a href="index.html">Return to main menu</a></p>
		</div>
	</body>
</html>