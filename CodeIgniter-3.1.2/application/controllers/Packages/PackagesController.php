<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackagesController extends CI_Controller {
	public function index() {
		$this->load->model('Packages/Packages');

		// Create DB connection
		$con = $this->Packages->createDbConnection();
		
		// Populate the form
		$data['allPackages'] = $this->Packages->readData($con);
		$this->Packages->closeDbConnection($con);

		$this->load->view('Packages/View', $data);
	}

	public function editRecord($id)
	{
		$id = $this->test_input($id);

		$data['id'] = $id;
		$data['task'] = 'edit';
		$data['title'] = 'Update Package';
					
		$this->load->model('Packages/Packages');
		// Create DB connection
		$con = $this->Packages->createDbConnection();
		
		// Populate the form
		$record = $this->Packages->getRecord($con, $id);

		$this->Packages->closeDbConnection($con);
		
		if($row = $record->fetch_object()) {
			$data['txtName'] = $row->name;
			$data['txtDescription'] = $row->description;	
			$data['txtPrice'] = $row->price;						
		}
		else {
			echo "No records found <br>";
		}

		// Get the features table
		$data['featuresView'] = $this->getFeaturesTable($id);

		$this->load->view('Packages/AddEdit', $data);
	}

	public function addRecord() 
	{
		$data['title'] = 'Add new Package';		

		// Get the features table
		$data['featuresView'] = $this->getFeaturesTable();
		$this->load->view('Packages/AddEdit', $data);
	}

	public function insertRecord()
	{
		$this->load->model('Packages/Packages');
		// Create DB connection
				
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);
		$price  = $this->input->post('price', true);		
		$features = $this->input->post('features', true); // need an array of IDs
		
		if (empty($features)) {
			// Get the features table
			$data['featuresView'] = $this->getFeaturesTable();

			// Populate the form
			$data['txtName'] = $name;
			$data['txtDescription'] = $description;	
			$data['txtPrice'] = $price;
			$data['id'] = '';
			$data['task'] = 'edit';
			$data['title'] = 'Add new Package';
			$data['error'] = "Please select atleast one feature";
			$this->load->view("Packages/AddEdit", $data);
			return;			
		}

		$con = $this->Packages->createDbConnection();

		$result = $this->Packages->insertData($con, $name, $description,$price);

		// Get the id of the above created package
		$resutl2 = $this->Packages->getLastPackage($con, $name);
		$packageId = $resutl2->fetch_object();
		$packageId = $packageId->id;
			
		$this->Packages->attachFeature($con, $packageId, $features);
		
		// Close DB connection
		$this->Packages->closeDbConnection($con);
		
		// Get the features table
		$data['featuresView'] = $this->getFeaturesTable();

		if($result) {
			// Populate the form
			$data['task'] = "created";
			$this->load->view("Packages/AddEdit", $data);
			$this->load->view("message", $data);
		}				
	}

	public function updateRecord() 
	{
		$this->load->model('Packages/Packages');
								
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);		
		$price  = $this->input->post('price', true);
		$features = $this->input->post('features', true); // need an array of IDs
		$id = $this->input->post('id', true);

		if (empty($features)) {
			// Get the features table
			$data['featuresView'] = $this->getFeaturesTable();
			
			// Populate the form			
			$data['txtName'] = $name;
			$data['txtDescription'] = $description;	
			$data['txtPrice'] = $price;
			$data['id'] = $id;
			$data['task'] = 'edit';
			$data['title'] = 'Update Package';
			$data['error'] = "Please select atleast one feature";
			$this->load->view("Packages/AddEdit", $data);
			return;			
		}
			
		// Create DB connection
		$con = $this->Packages->createDbConnection();

		$result = $this->Packages->updateData($con, $name, $description, $price, $id);

		// Attach the features to the service
		$this->Packages->updateFeatures($con, $id, $features);

		// Close DB connection
		$this->Packages->closeDbConnection($con);

		/*echo "<pre>";
		$dd = $this->input->post(NULL, TRUE);
		var_dump($dd);
		echo "</pre>";*/

		// Get the features table
		$data['featuresView'] = $this->getFeaturesTable();

		if($result) {
			// Populate the form
			$data['task'] = "updated";
			$this->load->view("Packages/AddEdit", $data);
			$this->load->view("message", $data);
		}
	}

	public function deleteRecord($id)
	{
		$this->load->model('Packages/Packages');
								
		// Create DB connection
		$con = $this->Packages->createDbConnection();
		
		$result = $this->Packages->deleteData($con, $id);
		
		// Close DB connection
		$this->Packages->closeDbConnection($con);
		
		if($result) {
			$data['task'] = "deleted";
			$this->index();
			$this->load->view('message', $data);
		}						
	}

	public function search()
	{
		$data['task'] = $this->input->get('task', true);
		$text = $this->input->get('searchText', true);

		$this->load->model('Packages/Packages');

		// Create DB connection
		$con = $this->Packages->createDbConnection();
		
	 	$data['allPackages'] = $this->Packages->search($con, $text);
	 	$data['searchText'] = $text;
		$this->Packages->closeDbConnection($con);
		
		$this->load->view('Packages/View', $data);
	}

	public function getFeaturesTable($id = '')
	{
		$this->load->model('Packages/Packages');
		$con = $this->Packages->createDbConnection();
		$data['allFeatures'] = $this->Packages->getFeaturesOfPackages($con);
		if($id != '') {
			$selected = $this->Packages->getFeaturesOfPackages($con,$id);
			
			if ($selected != null) {
				$idList = array();
				while ($row = $selected->fetch_object()) {
					array_push($idList, $row->id);
				}

				$data['packageFeatures'] = $idList;
			}				 			
		}
		$this->Packages->closeDbConnection($con);

		return $this->load->view('Packages/FeaturesTable', $data, true);
	}

	// Helper method to filter input data
	public function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// Succecc message
	public function message($task) {		
		$this->load->helper('url');
		echo "<br>";
		echo "<h3 class='w3-padding w3-green w3-center w3-content w3-animate-top' id='successMsg'> Record was successfully {$task} </h3>";		
		$siteUrl = site_url("Welcome");
		echo "	<script>
					setTimeout(function(){
						/*window.location = ('{$siteUrl}');*/						
					}, 5000);
				</script>";
	}
}

?>