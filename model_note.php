<?php
	//header('Content-Type:application/json');
	require_once('lib/config.php');
	require_once('lib/functions.php');
	
	$models=get_models();
	$models=json_decode($models,true);
	$data=array();
	if(isset($_GET['online'])){
		$online=$_GET['online'];
	}else{
		$online=2;
	}
	foreach($models['data'] as $m){					
		//Get notes for this  model
		if($online==1){
			if($m['attributes']['status']=="offline"){
				continue;
			}
		}
		$qry=mysqli_query($conn,"SELECT notes FROM models WHERE id='".$m['id']."'") or die(mysqli_error($conn));
		$is_note_saved="";
		if(mysqli_num_rows($qry)>0){
			//If notes stored for this model fetch the data
			$is_note_saved=1;
			$row=mysqli_fetch_assoc($qry);
			$note=$row['notes'];
		}
		echo $m['attributes']['nickname'].':'.$note.'<br>';
		/*$data[]=array(
			$m['attributes']['nickname']=>$note
		);*/
		}//end of foreach

	//$data=json_encode($data);
	//echo $data;

	
?>
