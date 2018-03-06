<?php	require_once('header.php'); ?>
    <div class="container">
		<div class="row">
    		<div class="col-sm-10">
        		<h3 class="text-info">Manage Campaigns</h3>
                
               	<?php
					//Msgs
					if(isset($_GET['flag'])){
						$flag=$_GET['flag'];
						if($flag=="pok"){
							echo '<div class="alert alert-success alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> Campaign paused..';
							echo '</div>';
						}else if($flag=="rok"){
							echo '<div class="alert alert-success alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> Campaign resumed..';
							echo '</div>';
						}else if($flag=="noid"){
							echo '<div class="alert alert-warning alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Warning!</strong> No campaign id passed to process..';
							echo '</div>';
						}
					}
					
					
					require_once('lib/functions.php');
					$token=exo_get_token();
					
					$resp=exo_get_campaigns($token);
					$resp_dp=dp_get_campaigns();
	
					$exo_campaigns=json_decode($resp,true);
					$dp_camps=json_decode($resp_dp,true);
					if(empty($exo_campaigns) && empty($dp_camps)){
						echo '<div class="alert alert-danger alert-dismissable fade in">';
    						echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    						echo '<strong>Errors!</strong> No campaigns found..';
						echo '</div>';	
					}else{
						
							
				?>
                <table id="datatable" class="table table-bordered">
                	<thead>
                    	<tr>
                        	<th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Network</th>
                            <th>Actions</th>
               			</tr>
					</thead>
                    <?php
						foreach($exo_campaigns['result'] as $r){
						?>
                        	<tr>
                        	<td><?php echo $r['id']; ?></td>
                            <td><?php echo $r['name']; ?></td>
                            <td>
							<?php
                            	if($r['status']==0){
									echo '<span class="glyphicon glyphicon-alert"></span>';
								}else{
									echo '<span class="glyphicon glyphicon-ok"></span>';
								}
							?>
                            </td>
                            <td><?php echo 'ExoClick' ?></td>
                            <td>
                            	<?php
									if($r['status']==0){
										echo '<a href="resume_exo.php?id='.$r['id'].'" onClick="this.innerHTML=\'Processing…\';" class="btn btn-primary btn-xs">Resume</a>';
									}else{
										echo '<a href="pause_exo.php?id='.$r['id'].'" onClick="this.innerHTML=\'Processing…\';" class="btn btn-warning btn-xs">Pause</a>';
									}
								?>
                            </td>
                        </tr>
                        <?php		
						}
						//Print
						foreach($dp_camps as $r){
						?>
                        	<tr>
                        	<td><?php echo $r['Id']; ?></td>
                            <td><?php echo $r['Name']; ?></td>
                            <td>
							<?php
								$placements=dp_get_placements($r['Id']);
								$placements=json_decode($placements,true);
								$is_active=0;
								foreach($placements as $p){
									if($p['Status']=="Active"){
										$is_active=1;
										break;
									}
								}
                            	if($is_active==0){
									echo '<span class="glyphicon glyphicon-alert"></span>';
								}else{
									echo '<span class="glyphicon glyphicon-ok"></span>';
								}
							?>
                            </td>
                            <td><?php echo 'DoublePimp' ?></td>
                            <td>
                            	<?php
								if($is_active==0){	
									echo '<a href="resume_dp.php?id='.$r['Id'].'" onClick="this.innerHTML=\'Processing…\';" class="btn btn-primary btn-xs">Resume</a>';
								}else{
									echo '<a href="pause_dp.php?id='.$r['Id'].'" onClick="this.innerHTML=\'Processing…\';" class="btn btn-warning btn-xs">Pause</a>';
								}
									
								?>
                            </td>
                        </tr>
                        <?php		
						}
					?>
                    	
					<tbody>
                    </tbody>
            	</table>
                <?php
					}//end of table
				?>
               
        	</div>
    	</div>
    </div>
<?php	require_once('footer.php');  ?>