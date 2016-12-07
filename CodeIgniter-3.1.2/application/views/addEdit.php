<?php
require('features.php');
$this->load->Helper('url');

// Dynamically create the form according to Create or Update behavior
function createForm($txtName = '', $txtDescription = '', $txtPrice = '', $id = '') { ?>
	<html>
	<head>
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		
		<title>
			<?php if($id == '') { echo "Add new feature"; } else { echo "Update feature"; } ?>
		</title>
	</head>

	<body>	
		<div class="" >	
			<div class="w3-container" id="header">		
				<h2 class="w3-padding w3-col m6 w3-indigo">
				<!-- <?php if($id == '') { echo "Add new feature"; } else { echo "Update feature"; } ?> -->
				<?php if(empty($id)) { 
					echo "Add new feature"; 
				} 
				else { 
					echo "Update feature"; 
				} ?>
				</h2>
			</div>	
			<div class="w3-container" id="form">
				<form class="w3-container w3-card-4 w3-half w3-light-grey" method="post" action="<?php echo site_url('Welcome'); echo ($id == '' ? '/insertRecord' : '/updateRecord') ?>">
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
					<br>
					<div>
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<input type="hidden" name="task" value="<?php if($id == '') { echo "created"; } else { echo "updated"; } ?>">
						<input class="w3-btn w3-green" type="submit" value="Save">				
					</div>
					<br>
				</form>
			</div>	
		</div>
		
		<br>
		<div class="w3-container w3-padding">
			 <button class="w3-btn w3-blue w3-col m2" onclick="location.href = '<?php echo site_url("Welcome"); ?>'; ">Back to Features</button>
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
				createForm($txtName, $txtDescription, $txtPrice, $id);				
				break;

			case 'updated':
				createForm();				
				break;

			case 'created':
				createForm();				
				break;			
				
			default:				
				break;
		}		
	}
	else {		
		createForm();
	}	
	
?>



