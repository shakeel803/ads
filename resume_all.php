<?php
	
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		require_once('lib/functions.php');
		$list=explode(',',$id);
		$total=count($list);
		$done=0;
		foreach($list as $i){
			$current_id=explode('-',$i);
			if($current_id[0]=='exo'){
				//play for ExoClick
				$token=exo_get_token();
				$exo_resp=exo_play_item($token,$current_id[1]);
				if($exo_resp!=false){
					$done++;
				}
			}else if($current_id[0]=='dp'){
				//resume for DoublePimp
				$dp_placements=dp_get_placements($current_id[1]);
				$dp_placements=json_decode($dp_placements,true);
				foreach($dp_placements as $dp_p){
					if(dp_play_placement($dp_p['Id'])){
						$done++;
					}
				}
			}else if($current_id[0]=='pop'){
				//resume PopAds
				$pop_resp=pop_resume_item($current_id[1]);
				if($pop_resp!=false){
					$done++;
				}
			}
		}
		
		if($done==$total){
			header('location:index.php?flag=rall_ok');
			die();
		}
	}else{
		header('location:index.php?flag=noid');
		die();
	}
	
?>