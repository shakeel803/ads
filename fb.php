<?php	require_once('header.php'); ?>
    <div class="container">
    	<h3 class="text-info">Fetch Data from FB</h3>
         <div class="row">
         	<form role="form" method="post" action="fetch_fb.php">
            	<div class="form-group">
                	<label for="page_id">Input Fb Page ID</label>
                    <input type="text" name="page_id" id="page_id" class="form-control" required>
                </div>
                <div class="form-group">
                	<label for="token">Fb Access Token</label>
                    <input type="text" name="token" id="token" class="form-control" required>
                </div>
                <div class="form-group">
                	<button type="submit" class="btn btn-primary" name="btn">Process</button>
                </div>
            </form>
         </div> 
    </div>
<?php	require_once('footer.php');  ?>