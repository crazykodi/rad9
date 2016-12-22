<?php $this->load->helper('url'); ?>

<html>
<title>View Services</title>
<head>
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-black.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.1.1.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</head>

<body>
	<script>
		<!-- Close the delete confirmation modal -->
		function closeModal() {
			document.getElementById('deleteConfirm').style.display='none';
		}

		<!-- Display the delete confirmation modal -->
		function modal(id) {
			document.getElementById('deleteConfirm').style.display='block';
			var url = "<?php echo site_url('Services/ServicesController/deleteRecord/'); ?>" + id;
			document.getElementById('deleteLink').setAttribute('href',url);
		}
	</script>

	<!-- Delete confirmation modal -->
	<div id="deleteConfirm" class="w3-modal">
	  <div class="w3-modal-content w3-animate-bottom">
	    <div class="w3-container w3-padding w3-deep-orange">		
			<span onclick="document.getElementById('deleteConfirm').style.display='none'" class="w3-closebtn">&times;</span>
			<h2>Are you sure you want to delete this feature?</h2>      
		</div>
		<div class="w3-container w3-padding-24 w3-center" >	
			<a id="deleteLink" href=''><button class='w3-btn w3-large w3-red'>Yes</button></a>
			&nbsp;
			&nbsp;
			&nbsp;
			<button class='w3-btn w3-large w3-green' onclick='closeModal()'>No</button>
		</div>
	    </div>
	  </div>
	</div>

	<h1 class="w3-padding w3-deep-purple">Services</h1>

	<div class="w3-container w3-padding w3-row ">
		<form class="w3-left w3-third"  method="get" action="<?php echo site_url('Services/ServicesController/search'); ?> ">
			<input class="w3-input w3-col m8 w3-card"  type="text" name="searchText" placeholder="Enter service name..." value="<?php echo (isset($task) ? $searchText : '') ?>" required>
			&nbsp;
			<input type="hidden" name="task" value="search">
			<input class="w3-btn w3-padding" type="submit" value="search">
		</form>
		<div  class="w3-right">
			<button class="w3-btn w3-blue w3-padding" onclick="location.href = '<?php echo site_url("Services/ServicesController/addRecord"); ?>'; ">Add new service</button>
			&nbsp;
			<button class="w3-btn w3-padding" onclick="location.href = '<?php echo site_url("Services/ServicesController"); ?>'; ">Refresh</button>
		</div>
		
	</div>
	
	<?php

	// Retrieve data
	if(isset($allServices)) {
		$results = $allServices;
	}
	else {
		$results = null;
	}
	
	?>

	<!--  Display data -->
	<div class='w3-container'>
		<table class='w3-table-all w3-card-2'>
		<!-- <table class='table table-responsive table-striped table-condensed'> -->
			<thead>
				<tr class='w3-theme'>
					<th>Name</th><th>Description</th><th></th><th></th>
				</tr>
			</thead>
			<tbody>

	<?php
	if($results != null) {
		while($row = $results->fetch_object()) { 
	?>		
					<tr>
					<input type='hidden' name='id' value='" . $row->id . "'></td>
					<td><?php echo $row->name ?></td>
					<td><?php echo$row->description ?></td>					
					<td><a href='<?php echo site_url("Services/ServicesController/editRecord/"), $row->id ?>'> <button class='w3-btn w3-amber'>Edit</button> </a></td>
					<td><button class='w3-btn w3-red' id='btnDelete' onclick='modal(<?php echo $row->id ?>)'>Delete</button> </td>
					</tr>
	<?php				
		}	
	} 
	else {
	?>	
			</tbody>
		</table>
		<h5 class='w3-center w3-deep-orange'> No data to display</h5> <br>
	<?php
	}
	?>
			</tbody>
		</table>
	</div>	

</body>
</html>

<!-- <?php		
	
	if(isset($task)) {
		switch ($task) { 
			case 'search_old':			
				$results = $searchResults;
?>					
				Display data
				<div class='w3-container'>
				<table class='w3-table-all'>
				<thead>
				<tr class='w3-theme'>
				<th>Name</th><th>Description</th><th>Price</th><th></th><th></th>
				</tr>
				</thead>
				<tbody>

				<?php		
				if($results != null) {
					while($row = $results->fetch_object()) { 
				?>
								<tr>
								<input type='hidden' name='id' value='<?php echo $row->id ?>'></td>
								<td><?php echo $row->name ?></td>
								<td><?php echo $row->description ?></td>
								<td><?php echo $row->price ?></td>
								<td><a href='<?php echo site_url("Services/ServicesController/editRecord/"), $row->id ?>'> <button class='w3-btn w3-amber'>Edit</button> </a></td>
								<td><button class='w3-btn w3-red' id='btnDelete' onclick='modal(<?php echo  $row->id ?>)'>Delete</button> </td>
								</tr>
					<?php			
					}	
				} 					
				else { 
					?>
					
					</tbody>
					</table>	
					<h5 class='w3-center w3-deep-orange'> No data to display</h5> <br>
				<?php
				}
				?>

				</tbody>
				</table>
				</div>
				
				<?php
				// Close DB connection				
				$results->free();
								
				break;						
		}
	}
				?> -->