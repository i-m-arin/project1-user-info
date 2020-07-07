<?php 
require_once "pdo.php";
require_once "util.php";
session_start();

if(!isset($_SESSION['account'])){
	die("Not logged in");
}

$stmt=$pdo->prepare('SELECT * FROM profile JOIN user ON profile.user_id=:uid');
$stmt->execute(array(':uid'=>$_SESSION['account']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

$stmt2=$pdo->prepare('SELECT * FROM user WHERE user_id=:id');
$stmt2->execute(array(':id'=>$_SESSION['account']));
?>
<head>
	<title>Own Profile Info</title>
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

$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
echo "<center>";
echo '<h1>Profile Information</h1>';
echo '<p>User Name : '.htmlentities($row2['user_name'])."\n";
echo "</p><p>";
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

