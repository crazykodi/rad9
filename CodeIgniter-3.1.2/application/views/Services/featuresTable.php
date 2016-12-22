<?php
// Retrieve data		
	if(isset($serviceFeatures)) {
		$results = $serviceFeatures;
	}
	else {
		$results = null;
	}
	
?>

<!--  Display data -->
<div class='w3-container'>
	<h2>Features</h2>
	<table class='w3-table-all w3-card-2'>
		<thead>
			<tr class="w3-teal">
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>				
			</tr>
		</thead>
		<tbody>
			<?php
			if($results != null) {
				while($row = $results->fetch_object()) { 
			?>		
				<tr>				
					<td><?php echo $row->name ?></td>
					<td><?php echo$row->description ?></td>
					<td><?php echo$row->price ?></td>					
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