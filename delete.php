<?php 
require_once "pdo.php";
require_once "bootstrap.php";
require_once "util.php";
session_start();

if(!isset($_SESSION['account'])){
	die("Not logged in");
}
if(isset($_POST['cancel'])){
	header("Location: main.php");
	return;
}
if(isset($_POST['delete'])){
	$stmt=$pdo->prepare('DELETE FROM user WHERE user_id=:uid');
	$stmt->execute(array(':uid'=>$_SESSION['account']));
	$_SESSION['success']="Account deleted successfully";
	header("Location: index.php");
	return;
}


?>


<!DOCTYPE html>
<html>
<head>
<title>Delete Account</title>
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
<body>
<center>
<h1 style="font-family:serif;font-size:300%;">Are you Sure?</h1><br><br>
<h4 style="font-family:serif;font-size:150%;">Click here to delete your account permanently</h4><br>
<form method="POST">
<input type="submit" value="Delete" name="delete" style="background-color:#cc0000;opacity:0.8;font-size:20px;padding:15px 32px;color:black;border-radius:8px;">
<input type="submit" value="Cancel" name="cancel" style="background-color:green;opacity:0.8;font-size:20px;padding:15px 32px;color:black;border-radius:8px;">
</form>
</body>
</html>