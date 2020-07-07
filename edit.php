<?php 
require_once "pdo.php";
require_once "util.php";
session_start();

if(!isset($_SESSION['account'])){
	die("Not logged in");
}
if(isset($_POST['cancel'])){
	header("Location: main.php");
	return;
}
if(isset($_POST['name'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])&&isset($_POST['mobno'])&&isset($_POST['description'])){
	if(strlen($_POST['name'])==0||strlen($_POST['email'])==0||strlen($_POST['mobno'])==0||strlen($_POST['description'])==0||strlen($_POST['username'])==0||strlen($_POST['password'])==0){
		$_SESSION['error']="Please enter all the details.";
		header("Location: edit.php");
		return;
	}
	$stmt=$pdo->prepare("SELECT * FROM user WHERE user_name=:us");
	$stmt->execute(array(':us'=>$_POST['username']));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($row['user_name']===$_POST['username']||$row===false){
		$salt='XyZzy12*_';
		$check=hash('md5',$salt.$_POST['password']);

		$stmt=$pdo->prepare("UPDATE user SET user_name=:un,password=:pd WHERE user_id=:uid");
	$stmt->execute(array(
		':un'=>$_POST['username'],
		':pd'=>$check,
		':uid'=>$_SESSION['account']));

	$stmt=$pdo->prepare("SELECT profile_id FROM profile JOIN user ON profile.user_id=:uid");
	$stmt->execute(array(':uid'=>$_SESSION['account']));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$profile_id=$row['profile_id'];
	$stmt=$pdo->prepare("UPDATE profile SET name=:nm,email=:em,mobile_no=:mob,description=:des WHERE profile_id=:prof");
	$stmt->execute(array(
		':nm'=>$_POST['name'],
		':em'=>$_POST['email'],
		':mob'=>$_POST['mobno'],
		':des'=>$_POST['description'],
		':prof'=>$profile_id));
	$_SESSION['success']="Profile updated successfully";
	error_log("profile updated: ".$_POST['username']."   ".$_POST['password']);
	header("Location: main.php");
	return;
	}
		$_SESSION['error']="User Name already exist.";
		header("Location: edit.php");
		return;
		
	
}

?>
<head>
	<title>Edit Page</title>
<style>

	body,html{
		background-image:url("https://images7.alphacoders.com/996/thumb-1920-996873.jpg");
		height:100%;
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-size:cover;
		font-family:serif;
}
input[type=submit]{
background-color:green;
opacity:0.7;
font-size:15px;
padding:13px 30px;
color:black;
border-radius:8px;
}
input[type=text] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  font-family:serif;
}
input[type=password] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  font-family:serif;
}
input[type=email] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  font-family:serif;
  }
  input[type=tel] {
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    font-family:serif;
}
#cancel{
	background-color:red;
}

</style>
</head>

<h3 style="text-align:center">Edit your details:</h3>
<?php
	flash();
	$stmt=$pdo->prepare('SELECT * FROM profile JOIN user ON profile.user_id=:uid');
$stmt->execute(array(':uid'=>$_SESSION['account']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

$stmt2=$pdo->prepare('SELECT * FROM user WHERE user_id=:id');
$stmt2->execute(array(':id'=>$_SESSION['account']));
$row2=$stmt2->fetch(PDO::FETCH_ASSOC);

$name=$row['name'];
$email=$row['email'];
$mob=$row['mobile_no'];
$user=$row2['user_name'];

?>
<form method="POST">
<center>
<label>Name</label><br>
<input type="text" id="name" name="name" value="<?=$name?>" autofocus ><br><br>
<label>User Name</label><br>
<input type="text" id="username" name="username" value="<?=$user?>"><br><br>
<label>Password</label><br>
<input type="password" id="password" name="password" value="" ><br><br>
<label>Email ID</label><br>
<input type="email" id="email" name="email" value="<?=$email?>"><br><br>
<label>Mobile No.</label><br>
<input type="tel" id="mobno" name="mobno"pattern="[0-9]{10}" value="<?=$mob?>"  ><br><br>
<label>Your views about this website</label><br>
<textarea name="description" rows="10" cols="50" ></textarea><br><br>

<input type="submit" id="update" name="Update">
<input type="submit" name= "cancel" value="Cancel" id="cancel">

</form>