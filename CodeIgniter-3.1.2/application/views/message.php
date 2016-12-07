	<br>
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
	<h3 class='w3-padding w3-green w3-center w3-content w3-animate-bottom' id='successMsg'> Record was successfully <?php echo $task; ?> </h3>;		
	<script>
		setTimeout(function(){
			/*window.location = ('<?php echo site_url('Welcome'); ?>');*/
			document.getElementById('successMsg').style.display='none';
		}, 5000);
	</script>


<!-- <script>
	setTimeout(function(){
		window.location = ('index.php/Welcome');
	}, 5000);
</script>; -->
