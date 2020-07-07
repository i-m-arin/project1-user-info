<?php 
require_once "pdo.php";
require_once "util.php";
session_start();

if(!isset($_SESSION['account'])){
	die("Not logged in");
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Home</title>
</head>
<style>

body,html{
background-image:url("https://images7.alphacoders.com/996/thumb-1920-996873.jpg");
height:100%;
background-repeat:no-repeat;
background-attachment:fixed;
background-size:cover;
font-family:serif;
}
</style>
<center>
<body>
	<?php 
		flash();
	?>
<a href="logout.php">
<button style="background-color:orange;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;">Click here to Logout</button>
</a>
<a href="viewown.php">
<button style="background-color:#2855bf;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;" >Click here to view your details</button>
</a><br><br>
<a href="add.php">
<button style="background-color:#cc6699;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;">Click here to submit your details</button>
</a>
<a href="edit.php">
<button style="background-color:#cc66ff;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;">Click here to edit your details</button>
</a><br><br>
<a href="delete.php">
<button style="background-color:#2855bf;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;" >Click here to delete your details</button>
</a><br><br>
</center>
<h3>Here is the list of all the profiles who have submitted their details. Click on any name to view all the details.</h3>

<?php
$stmt=$pdo->prepare("SELECT name,profile_id FROM profile");
$stmt->execute(array());
$rows=$stmt->fetchall(PDO::FETCH_ASSOC);

echo "<ol>";
foreach($rows as $row){
	echo '<li> <a href="viewevery.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['name'])."</a></li>\n";
	echo "<br>";
}
echo "</ol>";

?>

</body>
</html>