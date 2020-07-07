<?php
require_once "pdo.php";
require_once "util.php";
session_start();

if(isset($_POST['cancel'])){
	header("Location: index.php");
	return;
}

if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password2'])){
	unset($_SESSION['account']);
	if(strlen($_POST['username'])==0||strlen($_POST['password'])==0||strlen($_POST['password2'])==0){

		$_SESSION['error']="Please enter User Name and Password";
		header("Location: signup.php");
		return;
	}
	if($_POST['password']!==$_POST['password2']){

		$_SESSION['error']="Password and Confirm Password did not match";
		header("Location: signup.php");
		return;
	}

	$stmt=$pdo->prepare("SELECT * FROM user WHERE user_name=:us");
	$stmt->execute(array(':us'=>$_POST['username']));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($row!==false){
		$_SESSION['error']="User Name already exist.";
		header("Location: signup.php");
		return;
	}
	$salt='XyZzy12*_';
	$check=hash('md5',$salt.$_POST['password']);
	$stmt=$pdo->prepare("INSERT INTO user(user_name,password) VALUES (:us,:pw)");
	$stmt->execute(array(
		':us'=>$_POST['username'],
		':pw'=>$check));
	$_SESSION['account']=$pdo->lastInsertId();
	$_SESSION['success']="Account created successfully";
	error_log("Signup success ".$_POST['username']."    ".$_POST['password']);
	header("Location: main.php");
	return;


}




?>

<!DOCTYPE html>
<html>
<head>
<title>Login here</title>
</head>
<body>
<style>
h1{
text-align:center;
font-family:serif;
color:black;
font-size:350%;
}
input[type=submit]{
background-color:transparent;
opacity:0.7;
font-size:15px;
padding:13px 30px;
color:black;
border-radius:8px;
box-shadow:0 6px 6px rgb(0,0,0,0.6);
cursor: pointer;
border: 1px solid #3498db;
font-family:serif;
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
body,html{
background-image:url("https://images7.alphacoders.com/996/thumb-1920-996873.jpg");
height:100%;
background-repeat:no-repeat;
background-attachment:fixed;
background-size:cover;
}
</style>

<h1>Signup</h1><br><br>
<?php
flash();
?>

<form autocomplete="on" method="post">
<center>
<label for="username">Username:</label><br>
<input type="text" id="username" name="username" placeholder="username" autofocus ><br><br>
<label for="password" style="text-align:right;">Password:</label><br>
<input type="password" id="password" name="password" placeholder="password" ><br><br>
<label for="password2" style="text-align:right;"></label><br>
<input type="password" id="password2" name="password2" placeholder="Confirm Password" ><br><br>

<input type="submit" name= "create" value="Create Account">
<input type="submit" name= "cancel" value="Cancel" id="cancel">

</form>
</body>
</html>