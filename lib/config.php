<?php
	$conn=mysqli_connect('localhost','root','','upwork_mehdi');
	if(!$conn){
		die('Db connection error '.mysqli_error($conn));
	}
?>