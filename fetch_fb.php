<?php	require_once('header.php'); ?>
    <div class="container">
    	<?php
		 	if(isset($_POST['btn'])){
				//If form is submitted
				require_once('lib/functions.php');
				$token=$_POST['token'];
				$page_id=$_POST['page_id'];
				if(empty($page_id) || empty($token)){
					error_msg('Please fill in all the details. <a href="#" onClick="history.back();">Go back</a>');
				}else{
					$page=fb_page($token,$page_id);
					$upcoming_events=fb_get_events($token,$page_id);
					$past_events=fb_get_events($token,$page_id,"past");
					$albums=fb_get_albums($token,$page_id);
					$feed=fb_get_page_feed($token,$page_id);
				}
			}
			
			$page_data=json_decode($page,true);
			if(array_key_exists('error',$page_data)){
				error_msg($page_data['error']['message']);
			}else{
				echo '<h2>Fetched Data of <span class="text-info">'.$page_data['name'].'</span> fb page.</h2>';
			}
		 ?>
    	
         
         <div class="row">
         	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            	<h3 class="text-warning">Upcoming Events</h3>
                <?php
                	if($upcoming_events==false){
						error_msg("No data found for upcoming events..");
					}else{
						
						$upcoming_events_arr=json_decode($upcoming_events,true);
						//print_r($upcoming_events_arr);
						if(array_key_exists('error',$upcoming_events_arr)){
							error_msg($upcoming_events_arr['error']['message']);
						}else{
							foreach($upcoming_events_arr['data'] as $ev){ ?>
								<div class="jumbotron">
                            		<div class="text-success">
                                		<h4><?php echo $ev['name']; ?></h4>
                                	</div>
                            	</div>
							<?php
                        	}
						}
					}
				?>
					
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            	<h3 class="text-warning">Past Events</h3>
                <?php
                	if($past_events==false){
						error_msg("No data found for past events..");
					}else{
						
						$past_events_arr=json_decode($past_events,true);
						//print_r($upcoming_events_arr);
						
						if(array_key_exists('error',$past_events_arr)){
							error_msg($past_events_arr['error']['message']);
						}else{
							foreach($past_events_arr['data'] as $ev){ ?>
								<div class="jumbotron">
									<div class="text-success">
										<h4><?php echo $ev['name']; ?></h4>
									</div>
								</div>
							<?php
							}
						}
					}
				?>
					
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            	<h3 class="text-warning">Photo Albums</h3>
                <?php
                	if($albums==false){
						error_msg("No data found for photo albums..");
					}else{
						
						$albums_arr=json_decode($albums,true);
						//print_r($albums_arr);
						
						if(array_key_exists('error',$albums_arr)){
							error_msg($albums_arr['error']['message']);
						}else{
							foreach($albums_arr['data'] as $alb){ ?>
								<div class="jumbotron">
									<div class="text-success">
										<h4><?php echo $alb['name']; ?></h4>
									</div>
								</div>
							<?php
							}
						}
					}
				?>
					
            </div>
            
         </div>
         <div class="row">
         	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            	<h3 class="text-warning">Page Feed</h3>
                <?php
					$feed_aa=json_decode($feed,true);
					
					if(array_key_exists('error',$feed_aa)){
						error_msg($feed_aa['error']['message']);
					}else{
						foreach($feed_aa['data'] as $f){
							if(array_key_exists('message',$f)){
								echo '<p>'.$f['message'].'</p>';
							}
						}
					}
				?>
            </div>
         </div>
    </div>
<?php	require_once('footer.php');  ?>