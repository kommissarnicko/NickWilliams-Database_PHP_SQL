<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - get_fief_info_result.php
-- DESCRIPTION: returns results for selected fief from get_fief_info.php
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
//populates <h1> header with name of fief at top of page
if(!($stmt = $mysqli->prepare("SELECT fief.id, fief.name FROM fief WHERE fief.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['fief_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<h1>Viewing fiefdom of " . $name . " attributes</h1>";
}
$stmt->close();
?>
				</legend>
				<p>Owned by: 
<?php
//prints name referenced on fief table for under fief.owner
if(!($stmt = $mysqli->prepare("SELECT fief.id, family.name FROM fief INNER JOIN family ON fief.owner = family.id WHERE fief.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['fief_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo $name;
}
$stmt->close();
?>
				 family</p>
				<p>Assets: 
					<ul>
<?php
//prints a list of all asset attributes for this record as referenced on fief_asset table
if(!($stmt = $mysqli->prepare("SELECT asset.id, asset.name, asset.description, fief_asset.quantity FROM asset INNER JOIN fief_asset ON fief_asset.aid = asset.id INNER JOIN fief ON fief_asset.fid = fief.id WHERE fief.id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['fief_id']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $name, $description, $quantity)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<li>" . $name . ", quantity " . $quantity . ", described as " . $description . "</li>";
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