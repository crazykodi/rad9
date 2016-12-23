<?php $this->load->helper('url'); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
	<title>Home</title>
</head>
<body>
	<div class="w3-container w3-teal">
	  <h1>Home Page</h1>
	</div>

	<div class="3-display-container">
		<div class="w3-display-middle">
			<button class="w3-btn w3-blue w3-padding" name="services" onclick="location.href = '<?php echo site_url("Services/ServicesController"); ?>'; ">Services</button>
			<button class="w3-btn w3-blue w3-padding" name="features" onclick="location.href = '<?php echo site_url("Features/FeaturesController"); ?>'; ">Features</button>
		</div>
	</div>	
</body>
</html>