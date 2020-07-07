<?php 
require_once "pdo.php";
require_once "util.php";
session_start();

$stmt2=$pdo->prepare('SELECT * FROM user WHERE user_id=:id');
$stmt2->execute(array(':id'=>$_SESSION['account']));
$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
$_SESSION['success']="Logout Successful";
error_log("Logout successful :".htmlentities($row2['user_name']));
session_destroy();
header("Location: index.php");
return;