<?php	require_once('header.php'); ?>
    <div class="container">
		<div class="row">
    		<div class="col-lg-12">
            	<?php
					if(isset($_POST['btn'])){
						//If submit is pressed
						$id=(int)$_POST['id'];
						if(empty($id) || $id<=0){
							echo '<div class="alert alert-danger alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Error!</strong> Invalid / No campaign ID given.';
  							echo '</div>';
						}else{
							require_once('lib/functions.php');
							$resp=dp_get_placements($id); //API CALL
							if($resp==false){
								//Error calling api.
								echo '<div class="alert alert-danger alert-dismissable fade in">';
    								echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    								echo '<strong>Error!</strong> Could not connect successfully to DoublePimp API.';
  								echo '</div>';
							}else{
								//API call executed
								if($resp==404){
									//Invalid Campaign ID given
									echo '<div class="alert alert-danger alert-dismissable fade in">';
    									echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    									echo '<strong>Nothing Found!</strong><br> Invalid campaign ID given, nothing found for ('.$id.').';
  										echo '</div>';
								}else{
									//Valid Campaign ID and response is there
									$placements_array=json_decode($resp,true);
									if(!empty($placements_array)){
										//Some placements are there and found
										$total=0; //total campaigns(paused) found...
										$done=0; //count successful activation of placement
										$errors=0; //count errors
										foreach($placements_array as $p){
											
											if($p['Status']=="Paused"){
												$total++;
												//Activate this placement
												$total++;
												echo '<p>Placement ID: '.$p['Id'].'</p>';
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
											echo '<div class="alert alert-success alert-dismissable fade in">';
    											echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    											echo '<strong>Success!</strong> Campaign activated.';
  											echo '</div>';
										}else if($total>$done){
											echo '<div class="alert alert-success alert-dismissable fade in">';
    											echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    											echo '<strong>Success!</strong>'.$done.' placements activated of '.$total.'.';
  											echo '</div>';
										}
									}else{
										//No placements found for campaign id
										echo '<div class="alert alert-warning alert-dismissable fade in">';
    										echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    										echo '<strong>Empty!</strong> No placements available for given campaign ID.';
  										echo '</div>';
									}//end of else if no placemnets found for given campaign ID
								}//end of valid campaign id given else
							}//end of else part of if($resp==false)
							
						}//end of ese part of if form is valid
					}
				?>
        		<form action="" method="post">
                	<div class="form-group">
                    	<h3>DoublePimp Activate Campaigns</h3>
                    </div>
                	<div class="input-group">
   						<input placeholder="Campaign ID to play" name="id" type="number" class="form-control" required>
  		 				<span class="input-group-btn">
        					<button class="btn btn-primary" name="btn" type="submit">Play</button>
   						</span>
					</div>
        		</form>
        	</div>
    	</div>
    </div>
<?php	require_once('footer.php');  ?>