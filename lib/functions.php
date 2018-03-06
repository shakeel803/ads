<?php
	
	/**
	*
	*	This file is having all the functions to connect to ExoClick API. There will be fol functions as follows.
	*	
	**/
	
	/*===================		ExoClick		====================*/
	
	function exo_get_token(){
		//Function to get access token based on API KEY
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://api.exoclick.com/v2/login",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "POST",
  			CURLOPT_POSTFIELDS => "{\r\n  \r\n  \"api_token\": \"5e6ff3dd968750e4e2d6fb84d3ea59b388499772\"\r\n}",
  			CURLOPT_HTTPHEADER => array(
    			"accept: application/json",
    			"cache-control: no-cache",
    			"content-type: application/json"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($err) {
  			die('Error occured '. $err);
		} else {
			if($http_code!=200){
				die('Some unknown problem occured with response code '.$http_code);
			}else if($http_code==200){
				$resp_arr=json_decode($response,true);
				return $resp_arr['token'];
			}
  			
		}
	}//end of exo_get_token()
	
	function exo_play_item($token,$id){
		//ExoClick Play a Campaign
		$curl = curl_init();

		curl_setopt_array($curl, array(
  		CURLOPT_URL => "https://api.exoclick.com/v2/campaigns/play",
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => "",
  		CURLOPT_MAXREDIRS => 10,
  		CURLOPT_TIMEOUT => 30,
  		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  		CURLOPT_CUSTOMREQUEST => "PUT",
  		CURLOPT_POSTFIELDS => "{\r\n\"campaign_ids\":[\r\n".$id."\r\n]\r\n}",
  		CURLOPT_HTTPHEADER => array(
    			"accept: application/json",
    			"authorization: Bearer ".$token,
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $response;
		}
	} //end of exo_play_item($id);
	
	function exo_pause_item($token,$id){
		//ExoClick Pause a campaign
		$curl = curl_init();

		curl_setopt_array($curl, array(
  		CURLOPT_URL => "https://api.exoclick.com/v2/campaigns/pause",
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => "",
  		CURLOPT_MAXREDIRS => 10,
  		CURLOPT_TIMEOUT => 30,
  		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  		CURLOPT_CUSTOMREQUEST => "PUT",
  		CURLOPT_POSTFIELDS => "{\r\n\"campaign_ids\":[\r\n".$id."\r\n]\r\n}",
  		CURLOPT_HTTPHEADER => array(
    			"accept: application/json",
    			"authorization: Bearer ".$token,
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $response;
		}
	} //end of pause_item($id);
	
	function exo_get_campaigns($token){
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://api.exoclick.com/v2/campaigns",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
 	 		CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"authorization: Bearer ".$token,
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			die('CuRL error '.$err);
		} else {
  			if($http_code==200){
				return $response;
			}else{
				die('Coulb not fetch data from ExoClick error code '.$http_code);
			}
		}
	}//end of get_campaigns()
	
	
	
	/*================		DoublePimp		================*/
	
	function dp_get_campaigns(){
		//Get all Campaigns from Double Pimp
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.doublepimp.com/api/campaign?advertiserId=7111&apikey=85e0e1cc-c8e5-4153-bcba-ddf7c282c343",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json",
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
			if($http_code==200){
  				return $response;
			}else{
				die("Error Occured for DoublePimp Call with code ".$http_code);
			}
		}
	}//end of dp_get_campaigns
	
	function dp_get_placements($campaign_id){
		//DoublePimp Get all placements for a specific campaign_id
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.doublepimp.com/api/campaign/".$campaign_id."/placement?advertiserId=7111&apikey=85e0e1cc-c8e5-4153-bcba-ddf7c282c343",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($err) {
  			die('DoublePimp - CuRL error '.$err);
		} else {
  			if($http_code==404){
				die('DoublePimp - Invalid campaign ID, nothing found.');
			}else{
				return $response;
			}
		}
	}//end of dp_get_placements()
	
	function dp_play_placement($id){
		//DoublePimp Play(Activate) a placement
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.doublepimp.com/api/placement/".$id."/status?advertiserId=7111&apikey=85e0e1cc-c8e5-4153-bcba-ddf7c282c343",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "PUT",
  			CURLOPT_POSTFIELDS => "\"Active\"",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $http_code;
		}
	}//end of dp_play_placement()
	
	function dp_pause_placement($id){
		
		//DoublePimp Pause(stop) a placement
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.doublepimp.com/api/placement/".$id."/status?advertiserId=7111&apikey=85e0e1cc-c8e5-4153-bcba-ddf7c282c343",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "PUT",
  			CURLOPT_POSTFIELDS => "\"Paused\"",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $http_code;
		}
	
	}//end of dp_pause_placement()
	
	
	//=================		PopAds Functions		========================
	
	function pop_get_all(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.popads.net/api/campaign_list?key=b9e5b387c5621e899bb0f12d53a68bb12d727d7d",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);
		curl_close($curl);
		
		if($http_code!=200){
			die('Could not complete request to POP Ads due to error#'.$http_code);
		}
		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			return $response;
		}
		
	}//end of pop_get_all()
	
	function pop_resume_item($id="5388028"){
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.popads.net/api/campaign_start?key=b9e5b387c5621e899bb0f12d53a68bb12d727d7d&campaign_id=".$id,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "POST",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);
		if($http_code!=200){
			die('Could not complete request to POP Ads due to error#'.$http_code);
		}
		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			return $response;
		}
		
	
	
	}//end of pop_start_itme()
	
	
	function pop_pause_item($id="5388028"){

		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://www.popads.net/api/campaign_pause?key=b9e5b387c5621e899bb0f12d53a68bb12d727d7d&campaign_id=".$id,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "POST",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: application/json"
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);
		if($http_code!=200){
			die('Could not complete request to POP Ads due to error#'.$http_code);
		}
		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			return $response;
		}
		
	}//end of pop_stop_item()
	
	
	//=================		ufancy model status		========================
	
	function get_online_models(){
		//function to check how many models are online right now...
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://ufancyme.com/html/api/diva/models",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			$models=json_decode($response,true);
			$online=0;
			foreach($models['data'] as $m){
				if($m['attributes']['status']=='online'){
					$online++;
				}
			}//end of foreach()
			return $online;
		}
		
	}//end of get_online_models()
	
	function get_models(){
		//function to get all models
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://ufancyme.com/html/api/diva/models",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
  			),
		));

		$response = curl_exec($curl);
		$http_code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			return $response;
		}
	}//end of get_models();
	
	
	//======================================	FB Functions to Get Data of page(s) =================================//
	//$token="EAAIhxgq1rJ0BAG4aStVXpodOeNA80ZAfVYbBlCDW6YD8z6KOqa8wTzYKi3rLR3DRo5XTtUfpMqfm9yhHDNgtj84eOTEIBUlrcIa0NpRDpBvqNgUgNpfqnFmBMgRuIXumqKG4t7bZBc3BFEj4PWKzQyZAoZCmyz0MXwpqTofjDgZDZD";
	
	function fb_get_events($token,$page_id,$type="upcoming"){
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://graph.facebook.com//v2.12/".$page_id."/events?time_filter=".$type."&access_token=".$token."&limit=10",
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $response;
		}

	}//end of fb_get_events();
	
	//Load_more pages will access this function to load next data
	function fb_get_next_events($url,$type='upcoming'){
		$curl=curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => $url,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
  			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $response;
		}
	}//end of get_next_events()
	
	//To get pic of every event we will run this function
	function fb_get_event_pic($token,$event_id){
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => 		"https://graph.facebook.com//v2.12/".$event_id."/picture?type=large&redirect=0&access_token=".$token,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $response;
		}
	}//end of get_event_pic()
	
	function fb_get_albums($token,$page_id="jaagkashmir"){

		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => 		"https://graph.facebook.com//v2.12/".$page_id."/albums?access_token=".$token,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
  			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return false;
		} else {
  			return $response;
		}
	}//end of get_albums()
	
	function fb_get_page_feed($token,$page_id){
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://graph.facebook.com//v2.12/".$page_id."/feed?access_token=".$token,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			return $response;
		}
	}//end of fb_get_page_feed()
	
	
	function fb_page($token,$page_id){
		
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => "https://graph.facebook.com//v2.12/".$page_id."?access_token=".$token,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			die("cURL Error #:" . $err);
		} else {
  			return $response;
		}
	
		
	}//end of fb_page()
	
	//======================================  Utility functions ===============================//
	
	function make_safe($conn,$str){
		return mysqli_real_escape_string($conn,$str);
	}
	
	function error_msg($msg){ //to show error msg
		echo '<div class="alert alert-danger alert-dismissable fade in">';
    		echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    		echo '<strong>Error!</strong> '.$msg;
		echo '</div>';
	}
	function ok_msg($msg){ //To show success msg
		echo '<div class="alert alert-success alert-dismissable fade in">';
    		echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    		echo '<strong>Success!</strong> '.$msg;
		echo '</div>';
	}
?>