<!-----------------------------------------------------------------------------
-- NAME: Nickolas A. Williams
-- DATE: 11/06/2015
-- COURSE: CS 340-400
-- FINAL PROJECT - get_fief_info.php
-- DESCRIPTION: allows user to select family to get information about
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
			<h1>View a family's attributes</h1>
		</div>
		
		<div>	
			<form method="post" action="get_family_info_result.php">
				<fieldset>
					<legend>Select family to view</legend>
					<p>Family: <select name="family_id">
<?php
//populates dropdown menu with all names from fief table
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
 echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
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