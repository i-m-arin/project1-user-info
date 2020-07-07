<?php 
require_once "pdo.php";
require_once "util.php";
session_start();

if(!isset($_SESSION['account'])){
	die("Not logged in");
}

$stmt=$pdo->prepare('SELECT * FROM profile WHERE user_id=:uid');
$stmt->execute(array(':uid'=>$_SESSION['account']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['cancel'])){
	header("Location: main.php");
	return;
}
if(isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['mobno'])&&isset($_POST['description'])){
	if(strlen($_POST['name'])==0||strlen($_POST['email'])==0||strlen($_POST['mobno'])==0||strlen($_POST['description'])==0){
		$_SESSION['error']="Please enter all the details.";
		header("Location: add.php");
		return;
	}
	$stmt=$pdo->prepare('INSERT INTO profile(name,email,mobile_no,description,user_id) VALUES (:nm,:em,:mob,:des,:uid)');
	$stmt->execute(array(
		':nm'=>$_POST['name'],
		':em'=>$_POST['email'],
		':mob'=>$_POST['mobno'],
		':des'=>$_POST['description'],
		':uid'=>$_SESSION['account']));
	error_log("Profile added: ".$_POST['name']);
	$_SESSION['success']="Profile added successfully";
	header("Location: main.php");
	return;

}


?>


<!DOCTYPE html>
<html>
<head>
<title>Details</title>
<style>
	body,html{
		background-image:url("https://images7.alphacoders.com/996/thumb-1920-996873.jpg");
		height:100%;
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-size:cover;
		font-family:serif;
}
h3{
text-align:center;
font-family:serif;
color:#3333ff;
font-size:200%;
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
<body>
	<?php
	if($row!==false){
		echo "<center>";
		echo "<h1>You have already submitted your details.Now you can edit your details if you want.</h1>";
		echo "<br><br>";
		echo '<a href="edit.php">
<button style="background-color:#cc66ff;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;">Click here to edit your details</button>';
		echo "<br><br>";
	echo '<a href="main.php">
<button style="background-color:#2855bf;opacity:0.7;font-size:15px;padding:13px 30px;color:white;border-radius:8px;" >Click here to go back to previous page</button>
</a><br><br>';

	}
	else{

	?>
<h3 style="text-align:center">Please enter all the details:</h3>
<?php
	flash();
?>
<form method="POST">
<center>
<label>Name</label><br>
<input type="text" id="name" name="name" placeholder="Enter your full name" autofocus ><br><br>
<label>Email ID</label><br>
<input type="email" id="email" name="email" placeholder="Enter your email id" ><br><br>
<label>Mobile No.</label><br>
<input type="tel" id="mobno" name="mobno"pattern="[0-9]{10}" placeholder="Enter your Mobile No."  ><br><br>
<label>Your views about this website</label><br>
<textarea name="description" rows="10" cols="50" placeholder="Enter text here" ></textarea><br><br>
<input type="submit" id="submit" name="submit">
<input type="submit" name= "cancel" value="Cancel" id="cancel">

</form>
<?php
}
?>
</body>
</html>