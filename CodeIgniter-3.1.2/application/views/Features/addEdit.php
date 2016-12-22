<?php
$this->load->Helper('url');
$this->load->helper('form');

// Dynamically create the form according to Create or Update behavior
function createForm($services, $serviceId = '', $txtName = '', $txtDescription = '', $txtPrice = '', $id = '', $title = 'Add new Feature') { ?>
	<html>
	<head>
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
		<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
		
		<title>
			<?php echo $title; ?>
		</title>
	</head>

	<body>	
		<div class="" >	
			<div class="w3-container" id="header">		
				<h2 class="w3-padding w3-col m6 w3-indigo">
					<?php echo $title; ?>
				</h2>
			</div>	
			<div class="w3-container" id="form">
				<form class="w3-container w3-card-4 w3-half w3-light-grey" method="post" action="<?php echo site_url('Features/FeaturesController'); echo ($id == '' ? '/insertRecord' : '/updateRecord') ?>">				
					<br>
					<div>
						<label class="w3-label" for="name">Name:</label>
						<input class="form-control" type="text" id="name" name="name" value="<?php echo $txtName ?>" required>						
					</div>
					<div>
						<label class="w3-label" for="description">Description:</label>				
						<textarea class="form-control" rows="5" id="description" name="description"><?php echo trim($txtDescription); ?></textarea>
					</div>
					<div>
						<label class="w3-label" for="price">Price:</label>
						<input class="form-control" type="number" min="1" max="99999999" id="price" name="price" value="<?php echo $txtPrice ?>" required>
					</div>
					<div>
						<br>
						<label class="w3-label" for="service">Service:</label>
						<?php if(!isset($serviceId)) {
							$serviceId = NULL;
						}
						?> 		
						<?php echo form_dropdown('service',$services, $serviceId, "class='form-control' required"); ?>
					</div>
					<br>
					<div>
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<input type="hidden" name="task" value="<?php if($id == '') { echo "created"; } else { echo "updated"; } ?>">
						<input class="btn btn-success" type="submit" value="Save">				
					</div>
					<br>
				</form>
			</div>	
		</div>
		
		<br>
		<div class="w3-container w3-padding">
			 <button class="btn btn-primary btn-lg" onclick="location.href = '<?php echo site_url("Features/FeaturesController"); ?>'; ">Back to Features</button>
		</div>
	
	</body>
	</html>

<?php } 
	
/*	echo "<pre>";
	var_dump($this->_ci_cached_vars);
	echo "</pre>";
*/
	if(isset($task)) {
		switch ($task) {
			case 'edit':												
				createForm($services, $serviceId, $txtName, $txtDescription, $txtPrice, $id, $title);				
				break;

			case 'updated':
				createForm($services);				
				break;

			case 'created':
				createForm($services);				
				break;			
				
			default:				
				break;
		}		
	}
	else {		
		createForm($services);
	}	
	
?>



