<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - add_asset.php
-- DESCRIPTION: form for adding asset to table
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
			<h1>Add asset</h1>
		</div>
		
		<div>
			<table>
				<tr>
					<td>Existing assets</td>
				</tr>
				<tr>
					<td>ID</td>
					<td>Name</td>
					<td>Description</td>
				</tr>
<?php
//creates table of ids, names, descriptions from asset table
if(!($stmt = $mysqli->prepare("SELECT asset.id, asset.name, asset.description FROM asset ORDER BY name"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name, $description)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr><td>" . $id . "</td><td>" . $name . "</td><td>" . $description . "</td></tr>";
}
$stmt->close();
?>
			</table>
		</div>
		
		<div>	
			<form method="post" action="add_asset_process.php">
				<fieldset>
					<legend>Add asset type</legend>
					<p>Asset name: <input type="text" name="asset_name" /></p>
					<p>Description: <input type="text" name="asset_description" /></p>
					<p><input type="submit" /></p>
				</fieldset>
			</form>
		</div>
		
		<div>
			<p><a href="index.html">Return to main menu</a></p>
		</div>
	</body>
</html>