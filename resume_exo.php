<?php
	if(isset($_GET['id'])){
		require_once('lib/functions.php');
		$token=exo_get_token();
		$id=intval($_GET['id']);
		$resp=exo_play_item($token,$id);
		$resp_array=json_decode($resp,true);
		if(array_key_exists('errors',$resp_array)){
			//if response has error
			echo '<div class="alert alert-danger alert-dismissable fade in">';
    			echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    			echo '<strong>Errors!</strong><br>';
				foreach($resp_array['errors'] as $e){
					echo  $e.'<br>';
				}
  			echo '</div>';
		}else{
			header('location:index.php?flag=rok');
		}
		
	}else{
		header('location:index.php?flag=noid');
	}
?>