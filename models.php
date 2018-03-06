<?php
	require_once('header.php');
	require_once('lib/config.php');
	require_once('lib/functions.php');
	
	$models=get_models();
	
	if(isset($_GET['online'])){
		$online=$_GET['online'];
	}else{
		$online=3;
	}
	
?>

	<style>
    	.table-striped > tbody > tr:nth-child(2n) > td, .table-striped > tbody > tr:nth-child(2n) > th {
   			background-color:#FFF;
		}
		.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
   			background-color:#FFF;
		}
    </style>

	<script type="text/javascript">
    	
		function update_notes(model,notes){
			//alert('Modle ID: '+model+' and notes = '+notes);
			if(notes=='' || notes<0){
				$('#'+model).val(5);
			}
			$.ajax({
				type:'POST',
				url:"lib/ajax/update_notes.php",
				data:{id:model,note:notes},
				beforeSend: function(){
					$('#'+model+'loader').html('<img src="assets/img/sun.gif" height="32">');
				},
				success: function(data){
					$('#'+model+'loader').html(data);
				},
				error: function(){
					$('#'+model+'loader').html('<span class="glyphicon glyphicon-exclamation-sign"></span>');
				}
			});
		}//end of update_notes
		
		
    </script>
	
	<div class="container">
  		<h2 class="text-info">
        	<?php
				if($online==1)
					echo "Online ";
				else if($online==2)
					echo "Offline ";
				else if($online==3)
					echo "All ";
			?>
            Models
        </h2>
        <?php if($online!=1){ ?>
        <a href="models.php?online=1" class="btn btn-success">Online</a>
        <?php } ?>
        <?php if($online!=2){ ?>
        <a href="models.php?online=2" class="btn btn-warning">Offline</a>
		<?php } ?>
        <?php if($online!=3){ ?>
        <a href="models.php" class="btn btn-primary">All</a>
        <?php } ?>
		<?php
			if($models==false){
			}else{  
		?>                                                                                    
  		<div class="table-responsive">          
  			<table id="datatable" class="table table-sm table-dark">
    			<thead style="background:#000; color:#FFF;">
                  <tr>
                    <th>Image</th>
                    <th>Nickname</th>
                    <th>Country</th>
                    <th>Note</th>
                  </tr>
                </thead>
                <tbody>
                	<?php
						$models=json_decode($models,true);
						if($online!=2){
						foreach($models['data'] as $m){
							
							if($m['attributes']['status']=='online'){
								//Get notes for this  model
								$qry=mysqli_query($conn,"SELECT notes FROM models WHERE id='".$m['id']."'") or die(mysqli_error($conn));
								$is_note_saved=0;
								if(mysqli_num_rows($qry)>0){
									//If notes stored for this model fetch the data
									$is_note_saved=1;
									$row=mysqli_fetch_assoc($qry);
									$note=$row['notes'];
									}else{
										//Record not present for this model make an entry for this model in db
										$insert_sql="INSERT INTO models 
										SET id='".$m['id']."',nickname='".make_safe($conn,$m['attributes']['nickname'])."'";
										if(mysqli_query($conn,$insert_sql)){
										}else{
											die('Error creating notes record in db '.mysqli_error($conn));
										}
									}
									?>
									<tr>
                    <td><img class="img-circle img-responsive img-thumbnail" style="max-height:50px;" src="<?php echo $m['attributes']['broadcaster-profile-picture']; ?>"></td>
                    <td><?php echo $m['attributes']['nickname']; ?></td>
                    <td>
                    <img class="img-circle img-responsive img-thumbnail" style="max-height:50px;" src="https://lipis.github.io/flag-icon-css/flags/4x3/<?php echo $m['attributes']['country'].'.svg'; ?>"></td>
                    <td><input style="min-width:200px;" id="<?php echo $m['id']; ?>" onchange="update_notes(this.id,this.value);" type="number" value="<?php if($is_note_saved==1) echo $note; else echo 5; ?>" class="form-control"><span id="<?php echo $m['id']; ?>loader"></span></td>
                  </tr>						
						
						<?php	
							}//end of if online
							
					
						}//end of foreach
						}// end of if(online!=0)
						
						if($online!=1){
						foreach($models['data'] as $m){
							
							
							
							if($m['attributes']['status']=='offline'){
								//Get notes for this  model
								$qry=mysqli_query($conn,"SELECT notes FROM models WHERE id='".$m['id']."'") or die(mysqli_error($conn));
								$is_note_saved=0;
								if(mysqli_num_rows($qry)>0){
									//If notes stored for this model fetch the data
									$is_note_saved=1;
									$row=mysqli_fetch_assoc($qry);
									$note=$row['notes'];
									}else{
										//Record not present for this model make an entry for this model in db
										$insert_sql="INSERT INTO models 
										SET id='".$m['id']."',nickname='".make_safe($conn,$m['attributes']['nickname'])."'";
										if(mysqli_query($conn,$insert_sql)){
										}else{
											die('Error creating notes record in db '.mysqli_error($conn));
										}
									}
									?>
									<tr>
                    <td><img class="img-circle img-responsive img-thumbnail" style="max-height:50px;" src="<?php echo $m['attributes']['broadcaster-profile-picture']; ?>"></td>
                    <td><?php echo $m['attributes']['nickname']; ?></td>
                    <td>
                    <img class="img-circle img-responsive img-thumbnail" style="max-height:50px;" src="https://lipis.github.io/flag-icon-css/flags/4x3/<?php echo $m['attributes']['country'].'.svg'; ?>"></td>
                    <td><input style="min-width:200px;" id="<?php echo $m['id']; ?>" onchange="update_notes(this.id,this.value);" type="number" value="<?php if($is_note_saved==1) echo $note; else echo ''; ?>" class="form-control"><span id="<?php echo $m['id']; ?>loader"></span></td>
                  </tr>						
						
						<?php	
								}//end of if offline
							
							}//end of foreach
						}//end of if online==false)
				  ?>
                </tbody>
              </table>
		</div>
        <?php
			}
		?>
	</div>
	

<?php require_once('footer.php'); ?>