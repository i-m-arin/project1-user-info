<?php
require_once "pdo.php";
require_once "util.php";
session_start();
?>


<!DOCTYPE html>
<html>
<head>
<title>Hello User!</title>
<style>
body,html{
	background-image:url("https://wallpaperaccess.com/full/707141.jpg");
	height:100%;
	background-repeat:no-repeat;
	background-attachment:fixed;
	background-size:cover;
}

</style>

</head>
<body>
	<?php
		flash();
	?>
<center>
<h1 style="color:white;font-size:500%;">WELCOME :)</h1><br><br>
<a href="login.php" >
<button style="background-color:white;opacity:0.5;font-size:30px;padding:15px 32px;border-radius:8px;color:black;">Already a user?Login</button>
</a><br><br>
<a href="signup.php">
<button style="background-color:white;opacity:0.5;font-size:30px;padding:15px 32px;color:black;border-radius:8px;">New User?Signup</button>
</a><br><br>
</body>
</html>