<?php
	if(isset($_POST['id'])){
		require_once('../config.php');
		require_once('../functions.php');
		if($_POST['note']=="" || $_POST['note']<0){
			$_POST['note']=5;
		}
		$qry="UPDATE models SET notes='".make_safe($conn,$_POST['note'])."' WHERE id='".$_POST['id']."'";
		if(mysqli_query($conn,$qry)){
			echo '<span class="glyphicon glyphicon-ok"></span>';
		}else{
			echo '<span style="color:red;">Fail</span>';
		}
	}else{
		echo '<span style="color:red">Empty</span>';
	}
?>