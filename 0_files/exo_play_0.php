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
							$resp=exo_play_item($id); //API CALL
							if($resp==false){
								//Some error occurred while calling
								echo '<div class="alert alert-danger alert-dismissable fade in">';
    								echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    								echo '<strong>Failed!</strong> Could not connect to ExoClick API.';
  								echo '</div>';
							}else{
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
									echo '<div class="alert alert-success alert-dismissable fade in">';
    									echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    									echo '<strong>Success! (ID: '.$id.')</strong> '.$resp_array['message'];
  									echo '</div>';
								}
							}//end of ese part of if($resp==false)
						}//end of ese part of if form is valid
					}
				?>
        		<form action="" method="post">
                	<div class="form-group">
                    	<h3>ExoClick Activate Campaigns</h3>
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