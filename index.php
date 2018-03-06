<?php	require_once('header.php'); ?>
    <div class="container">
		
    		
        		<h3 class="text-info">Manage Campaigns</h3>
                
               	<?php
					//Msgs
					if(isset($_GET['flag'])){
						$flag=$_GET['flag'];
						if($flag=="pok"){
							echo '<div class="alert alert-warning alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> Campaign paused..';
							echo '</div>';
						}else if($flag=="rok"){
							echo '<div class="alert alert-success alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> Campaign resumed..';
							echo '</div>';
						}else if($flag=="noid"){
							echo '<div class="alert alert-danger alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Warning!</strong> No campaign id passed to process..';
							echo '</div>';
						}else if($flag=="pall_ok"){
							echo '<div class="alert alert-warning alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> All selected campaigns paused...';
							echo '</div>';
						}else if($flag=="rall_ok"){
							echo '<div class="alert alert-success alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> All selected campaigns resumed...';
							echo '</div>';
						}else if($flag=="syncpok"){
							echo '<div class="alert alert-info alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> Campaigns played using sync with models ( '.$_GET['done'].' played)';
							echo '</div>';
						}else if($flag=="syncok"){
							echo '<div class="alert alert-success alert-dismissable fade in">';
    							echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    							echo '<strong>Success!</strong> Campaigns paused using sync with models ( '.$_GET['done'].' paused)';
							echo '</div>';
						}
					}
					
					
					require_once('lib/functions.php');
					$token=exo_get_token();
					
					$resp=exo_get_campaigns($token);
					$resp_dp=dp_get_campaigns();
					$resp_pop=pop_get_all();
					
					$exo_campaigns=json_decode($resp,true);
					$dp_camps=json_decode($resp_dp,true);
					$pop_camps=json_decode($resp_pop,true);
					if(empty($exo_campaigns) && empty($dp_camps) && empty($pop_camps)){
						echo '<div class="alert alert-danger alert-dismissable fade in">';
    						echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    						echo '<strong>Errors!</strong> No campaigns found..';
						echo '</div>';	
					}else{
						
							
				?>
                <div class="table-responsive">
                	
                    <script type="text/javascript">
                    	
						function chkAll(){
							$('input:checkbox').each(function(index, element) {
                                if($('#checkAll').prop('checked')==true){
									$(this).prop('checked',true);
								}else{
									$(this).prop('checked',false);
								}
                            });
						}
						
						function resume_all(){
							var ids='';
							$('input:checkbox').each(function(index, element) {
								if($(this).prop('id')!='checkAll'){
									
                                	if($(this).prop('checked')){
										if(ids==''){
											ids=ids+$(this).val();
										}else{
											ids=ids+','+$(this).val();
										}
									}
								}
                            });
							if(ids==''){
								return false;
							}else{
								var href=$('#resume_all').prop('href');
								$('#resume_all').prop('href',href+'?id='+ids);
								//alert($('#resume_all').prop('href'));
								return true;
							}
						}
						function pause_all(){
							var ids='';
							$('input:checkbox').each(function(index, element) {
                                if($(this).prop('id')!='checkAll'){
									
                                	if($(this).prop('checked')){
										if(ids==''){
											ids=ids+$(this).val();
										}else{
											ids=ids+','+$(this).val();
										}
									}
								}
                            });
							if(ids==''){
								return false;
							}else{
								var href=$('#pause_all').prop('href');
								$('#pause_all').prop('href',href+'?id='+ids);
								//alert($('#pause_all').prop('href'));
								return true;
							}
						}
                    </script>
                    
                <a href="resume_all.php" id="resume_all" onClick="return resume_all();" class="btn btn-primary btn-sm">Resume Selected</a>&nbsp;
                <a href="pause_all.php" id="pause_all" onClick=" return pause_all();" class="btn btn-warning btn-sm">Pause Selected</a>
                <br>
                <table id="datatable" class="table table-striped">
                	<thead>
                    	<tr>
                        	<th><input type="checkbox" id="checkAll" onChange="chkAll();"></th>
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
                            <td><input type="checkbox" name="chk[]" value="<?php echo 'exo-'.$r['id'];  ?>"></td>
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
                            <td><input type="checkbox" name="chk[]" value="<?php echo 'dp-'.$r['Id'];  ?>"></td>
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
						
						foreach($pop_camps['campaigns'] as $r){
							
						?>
                        	<tr>
                            <td>
                            	<?php if($r['status']!="out_of_money"){ ?>
                            	<input type="checkbox" name="chk[]" value="<?php echo 'pop-'.$r['id'];  ?>">
                                <?php } ?>
                            </td>
                        	<td><?php echo $r['id']; ?></td>
                            <td><?php echo $r['name']; ?></td>
                            <td>
							<?php
								if($r['status']=='paused'){
									echo '<span title="Paused" class="glyphicon glyphicon-alert"></span>';
								}else if($r['status']=="approved"){
									echo '<span title="Played" class="glyphicon glyphicon-ok"></span>';
								}else if($r['status']=="out_of_money"){
									echo '<span title="Out of money" class="glyphicon glyphicon-info-sign"></span>';	
								}
							?>
                            </td>
                            <td><?php echo 'PopAds' ?></td>
                            <td>
                            	<?php
								if($r['status']=='paused'){	
									echo '<a href="resume_pop.php?id='.$r['id'].'" onClick="this.innerHTML=\'Processing…\';" class="btn btn-primary btn-xs">Resume</a>';
								}else if($r['status']=="approved"){
									echo '<a href="pause_pop.php?id='.$r['id'].'" onClick="this.innerHTML=\'Processing…\';" class="btn btn-warning btn-xs">Pause</a>';
								}else if($r['status']=="out_of_money"){
									echo '<span class="text-danger">Out of money</span>';
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
                </div>
                <?php
					}//end of table
				?>
          
    </div>
<?php	require_once('footer.php');  ?>