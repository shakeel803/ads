<?php
	
	if(isset($_GET['id'])){
		$id=intval($_GET['id']);
		require_once('lib/functions.php');
		$resp=dp_get_placements($id);
		
		$placements_array=json_decode($resp,true);
		//print_r($placements_array);
		if(!empty($placements_array)){
		  //Some placements are there and found
		  $total=0; //total campaigns(paused) found...
		  $done=0; //count successful activation of placement
		  $errors=0; //count errors
		  foreach($placements_array as $p){
			  
			  if($p['Status']=="Paused"){
				  $total++;
				  
				  //echo '<p>Placement ID: '.$p['Id'].'</p>';
				  $act_resp=dp_play_placement($p['Id']);
				  if($act_resp==false){
					  $errors++;
					  //continue;
				  }else{
					  if($act_resp==204){
						  $done++;
						  //continue;
					  }
				  }//end of else part of if($act_resp==false)
			  }//end of if
		  }//end of foreach($placements_array as $p)
		  if($total==$done){
			  header('location:index.php?flag=rok');
		  }
	  }else{
		  //No placements found for campaign id
		  echo '<div class="alert alert-warning alert-dismissable fade in">';
			  echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
			  echo '<strong>Empty!</strong> No placements available for given campaign ID.';
		  echo '</div>';
		  die();
	  }//end of else if no placemnets found for given campaign ID
  
		
	}else{
		header('location:exo.php?flag=noid');
	}
	
?>