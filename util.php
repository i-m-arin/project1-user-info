<?php

function flash(){
	if(isset($_SESSION['error'])){
		echo '<p style="color:red; text-align:center;">'.htmlentities($_SESSION['error'])."</p>\n";
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['success'])){
		echo '<p style="color:black; text-align:center;">'.htmlentities($_SESSION['success'])."</p>\n";
		unset($_SESSION['success']);
	}
}