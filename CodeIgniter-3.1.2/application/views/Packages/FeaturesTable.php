<?php
// Retrieve data		
	if(isset($allFeatures)) {
		$results = $allFeatures;
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
				<th></th>		
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
					<td><input type="checkbox" name="features[]" value="<?php echo $row->id ?>" <?php if(isset($packageFeatures)) { 
						if(in_array($row->id, $packageFeatures)) { 
							echo "checked"; 
						} 
					} ?> class="group-required"></td>					
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