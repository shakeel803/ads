<?php
	if(isset($_GET['id'])){
		require_once('lib/functions.php');
		$id=intval($_GET['id']);
		$resp=pop_resume_item($id);
		$resp_array=json_decode($resp,true);
		if(array_key_exists('errors',$resp_array)){
			//if response has error
			echo '<div class="alert alert-danger alert-dismissable fade in">';
    			echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    			echo '<strong>Errors!</strong><br>';
				$resp_array['errors']['title'];
  			echo '</div>';
		}else{
			header('location:index.php?flag=rok');
		}
		
	}else{
		header('location:index.php?flag=noid');
	}
?>