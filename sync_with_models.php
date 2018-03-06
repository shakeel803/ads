<?php
	/*
	*	Check if all models all offline pause all campaigns
	*/
	require_once('lib/functions.php');
	$online=intval(get_online_models());
	if($online==0){
		//GET ALL Campaigns and Pause all Campaigns
		$exo_token=exo_get_token();
		$exo_camps=json_decode(exo_get_campaigns($exo_token),true); //ExoClick Call
		$dp_camps=json_decode(dp_get_campaigns(),true); //DoublePimp CAll
		$pop_camps=pop_get_all(); //PopAds Call
		$pop_camps=json_decode($pop_camps,true);
		$done=0;
		$errors=0;
		foreach($exo_camps['result'] as $c){
			$p_resp=exo_pause_item($exo_token,$c['id']);
			$p_array=json_decode($p_resp,true);
			if($p_resp==false){
				$errors++;
			}else if(array_key_exists('errors',$p_array)){
				$errors++;
			}else{
				$done++;
			}
		}
		//Stop all DoublePimp
		foreach($dp_camps as $dp_c){
			$placements=dp_get_placements($dp_c['Id']);
			$placements=json_decode($placements,true);
			$pl_errors=0;
			foreach($placements as $p){
				if($p['Status']='Active'){
					$dp_p=dp_pause_placement($p['Id']);
					if($dp_p==false){
						$pl_errors++;
					}
				}
			}
			if($pl_errors>0){
				$errors++;
			}else{
				$done++;
			}
		}//end of each $dp_camps
		
		//Stop all PopAds
		foreach($pop_camps['campaigns'] as $c){
			if($c['status']=="approved"){
				$p_resp=pop_pause_item($c['id']);
				$p_array=json_decode($p_resp,true);
				if($p_resp==false){
					$errors++;
				}else if(array_key_exists('errors',$p_array)){
					$errors++;
				}else{
					$done++;
				}
			}
		}
		
		header('location:index.php?flag=syncok&err='.$errors.'&done='.$done);
		
	}else{
		//Online models != 0 so play all
		
		//GET ALL Campaigns and play all Campaigns
		$exo_token=exo_get_token();
		$exo_camps=json_decode(exo_get_campaigns($exo_token),true); //ExoClick Call
		$dp_camps=json_decode(dp_get_campaigns(),true); //DoublePimp CAll
		$pop_camps=json_decode(pop_get_all(),true); //PopAds Call
		$done=0;
		$errors=0;
		foreach($exo_camps['result'] as $c){
			$p_resp=exo_play_item($exo_token,$c['id']);
			$p_array=json_decode($p_resp,true);
			if($p_resp==false){
				$errors++;
			}else if(array_key_exists('errors',$p_array)){
				$errors++;
			}else{
				$done++;
			}
		}
		//Start all DoublePimp
		foreach($dp_camps as $dp_c){
			$placements=dp_get_placements($dp_c['Id']);
			$placements=json_decode($placements,true);
			$pl_errors=0;
			foreach($placements as $p){
				if($p['Status']='Paused'){
					$dp_p=dp_play_placement($p['Id']);
					if($dp_p==false){
						$pl_errors++;
					}
				}
			}
			if($pl_errors>0){
				$errors++;
			}else{
				$done++;
			}
		}//end of each $dp_camps
		
		//Reusme all PopAds which are paused
		foreach($pop_camps['campaigns'] as $c){
			if($c['status']=="paused"){
				$p_resp=pop_resume_item($c['id']);
				$p_array=json_decode($p_resp,true);
				if($p_resp==false){
					$errors++;
				}else if(array_key_exists('errors',$p_array)){
					$errors++;
				}else{
					$done++;
				}
			}
		}
		
		header('location:index.php?flag=syncpok&err='.$errors.'&done='.$done);
		
	
	}
?>