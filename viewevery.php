<?php 
require_once "pdo.php";
require_once "util.php";
session_start();

if(!isset($_SESSION['account'])){
	die("Not logged in");
}


$row=false;
$stmt=$pdo->prepare('SELECT * FROM profile WHERE profile_id=:pid');
$stmt->execute(array(':pid'=>$_GET['profile_id']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if($row===false){
 	$_SESSION['error']="No such Profile exist";
 	header("Location: main.php");
 	return;
 }

?>
<head>
	<title>Information</title>
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
</head>

<?php

 echo "<center>";
echo '<h1>Profile Information</h1>';
echo '<p>';
echo "Name : ".htmlentities($row['name'])."\n";
echo "</p><p>";
echo "Email : ".htmlentities($row['email'])."\n";
echo "</p><p>";
echo "Mobile No. : ".htmlentities($row['mobile_no'])."\n";
echo "</p><p>";
echo "Views about this website : <br/>".htmlentities($row['description'])."\n";
echo "<br><br>";

echo '<a href="main.php">
<button style="background-color:#2855bf;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;" >Click here to go to the previous page</button>
</a><br><br>';

?>