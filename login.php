<?php
require_once "pdo.php";
require_once "util.php";
session_start();

if(isset($_POST['cancel'])){
	header("Location: index.php");
	return;
}

if(isset($_POST['username'])&&isset($_POST['password'])){
	unset($_SESSION['account']);
	if(strlen($_POST['username'])==0||strlen($_POST['password'])==0){
		$_SESSION['error']="Please enter User Name and Password";
		header("Location: login.php");
		return;
	}
	$stmt=$pdo->prepare("SELECT * FROM user WHERE user_name=:un");
	$stmt->execute(array(
		'un'=>$_POST['username']));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($row===false){
		error_log("Login failed: User Name not found ".$_POST['username']);
		$_SESSION['error']="User Name not found";
		header("Location: login.php");
		return;
	}
	$salt='XyZzy12*_';
	$check=hash('md5',$salt.$_POST['password']);
	echo $check;
	if($check===$row['password']){
		$_SESSION['success']="Login successful";
		error_log("Login success: ".$_POST['username']."    ".$_POST['password']);
		$_SESSION['account']=$row['user_id'];
		header("Location: main.php");
		return;
	}
	else{
		error_log("Login failed: Incorrect Password ". $_POST['username']."     ".$_POST['password']);
		$_SESSION['error']="Incorrect Password";
		header("Location: login.php");
		return;
	}


}




?>

<!DOCTYPE html>
<html>
<head>
<title>Login here</title>
</head>
<body>
<style>
h1{text-align:center;
color:black;
font-size:350%;
font-family:serif;
}
input[type=submit]{
background-color:transparent;
opacity:0.8;
font-size:20px;
padding:15px 32px;
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
font-family:serif;
}
</style>

<h1>LOGIN</h1><br><br>
<?php
flash();
?>

<form autocomplete="on" method="post">
<center>
<label for="username">Username:</label><br>
<input type="text" id="username" name="username" placeholder="username" autofocus ><br><br>
<label for="password" style="text-align:right;">Password:</label><br>
<input type="password" id="password" name="password" placeholder="password" ><br><br>
<input type="submit" name= "login" value="Login">
<input type="submit" name= "cancel" value="Cancel" id="cancel">

</form>
</body>
</html>