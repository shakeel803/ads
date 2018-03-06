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
				//pause for ExoClick
				$token=exo_get_token();
				$exo_resp=exo_pause_item($token,$current_id[1]);
				if($exo_resp!=false){
					$done++;
				}
			}else if($current_id[0]=='dp'){
				//pause for DoublePimp
				$dp_placements=dp_get_placements($current_id[1]);
				$dp_placements=json_decode($dp_placements,true);
				foreach($dp_placements as $dp_p){
					if(dp_pause_placement($dp_p['Id'])){
						$done++;
					}
				}
			}else if($current_id[0]=='pop'){
				//Pause PopAds
				$pop_resp=pop_pause_item($current_id[1]);
				if($pop_resp!=false){
					$done++;
				}
			}
		}
		
		
		header('location:index.php?flag=pall_ok&done='.$done);
		die();
	}else{
		header('location:index.php?flag=noid');
		die();
	}
	
?>