<?php
$this->load->Helper('url');

// Dynamically create the form according to Create or Update behavior
function createForm($featuresView, $txtName = '', $txtDescription = '', $txtPrice = '', $id = '', $title = 'Add new Package', $error = '') { ?>
	<html>
	<head>
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		
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
				<form class="w3-container w3-card-4 w3-half w3-light-grey" method="post" action="<?php echo site_url('Packages/PackagesController'); echo ($id == '' ? '/insertRecord' : '/updateRecord') ?>">				
					<br>
					<div>
						<label class="w3-label" for="name">Name:</label>
						<input class="w3-input" type="text" id="name" name="name" value="<?php echo $txtName ?>" required>						
					</div>
					<div>
						<label class="w3-label" for="description">Description:</label>				
						<textarea class="w3-input" id="description" name="description"><?php echo trim($txtDescription); ?></textarea>
					</div>
					<div>
						<label class="w3-label" for="price">Price:</label>
						<input class="w3-input" type="number" min="1" max="99999999" id="price" name="price" value="<?php echo $txtPrice ?>" required>
					</div>
					<div>
						<?php echo $featuresView; ?>
						<span>
							<p class="w3-red w3-tag"><?php if (isset($error)) {
								echo $error;
								} ?>
							</p>
						</span>
					</div>					
					<br>
					<div>
						<input type="hidden" name="id" value="<?php echo $id ?>">						
						<input class="w3-btn w3-green" type="submit" value="Save">				
					</div>
					<br>
				</form>
			</div>	
		</div>		
		
		<br>
		<div class="w3-container w3-padding">
			 <button class="w3-btn w3-blue w3-col m2" onclick="location.href = '<?php echo site_url("Packages/PackagesController"); ?>'; ">Back to Packages</button>
		</div>
	
	</body>
	</html>

<?php } 
	
	/*echo "<pre>";
	var_dump($this->_ci_cached_vars);
	echo "</pre>";*/

	if(isset($task)) {
		$errorMsg = '';
		if(isset($error)) {
			$errorMsg = $error; 
		}

		switch ($task) {
			case 'edit':	
				createForm($featuresView, $txtName, $txtDescription, $txtPrice, $id, $title, $errorMsg);				
				break;

			case 'updated':
				createForm($featuresView);				
				break;

			case 'created':
				createForm($featuresView);				
				break;			
				
			default:				
				break;
		}		
	}
	else {		
		$errorMsg = '';
		if(isset($error)) {
			$errorMsg = $error; 
		}

		createForm($featuresView, null, null, null, null, 'Add new Package', $errorMsg);
	}	
	
?>



