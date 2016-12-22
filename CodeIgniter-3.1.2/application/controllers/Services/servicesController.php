<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServicesController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Services/services');

		// Create DB connection
		$con = $this->services->createDbConnection();
		
		// Populate the form
		$data['allServices'] = $this->services->readData($con);
		$this->services->closeDbConnection($con);

		$this->load->view('Services/view', $data);
	}

	public function editRecord($id)
	{
		$data['id'] = $id;
		$data['task'] = 'edit';
		$data['title'] = 'Update Service';

		$id = $this->test_input($id);
					
		$this->load->model('Services/services');
		// Create DB connection
		$con = $this->services->createDbConnection();
		
		// Populate the form
		$record = $this->services->getRecord($con, $id);

		$this->services->closeDbConnection($con);
		
		if($row = $record->fetch_object()) {
			$data['txtName'] = $row->name;
			$data['txtDescription'] = $row->description;							
		}
		else {
			echo "No records found <br>";
		}

		// Get the features table
		$data['featuresView'] = $this->getFeaturesTable($id);

		$this->load->view('Services/addEdit', $data);
	}

	public function addRecord() 
	{
		$data['title'] = 'Add new Service';		
		$this->load->view('Services/addEdit', $data);
	}

	public function insertRecord()
	{
		$this->load->model('Services/services');
		// Create DB connection
		$con = $this->services->createDbConnection();
		
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);		
		$id = $this->input->post('id', true);

		$result = $this->services->insertData($con, $name, $description);
		
		// Close DB connection
		$this->services->closeDbConnection($con);
		
		if($result) {
			// Populate the form
			$data['task'] = "created";
			$this->load->view("Services/addEdit", $data);
			$this->load->view("message", $data);
		}				
	}

	public function updateRecord() 
	{
		$this->load->model('Services/services');
		// Create DB connection
		$con = $this->services->createDbConnection();
				
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);		
		$id = $this->input->post('id', true);
				
		$result = $this->services->updateData($con, $name, $description, $id);

		// Attach the features to the service
		$featurelist = $this->input->post('select', true);
		if ($featurelist != null) {
			foreach ($featurelist as $key => $value) {			
				echo $value . "<br>";
				$result2 = $this->services->attachFeature($con,$id,$value);	
			}
		}

		// Close DB connection
		$this->services->closeDbConnection($con);

		/*echo "<pre>";
		$dd = $this->input->post(NULL, TRUE);
		var_dump($dd);
		echo "</pre>";*/

		if($result) {
			// Populate the form
			$data['task'] = "updated";
			$this->load->view("Services/addEdit", $data);
			$this->load->view("message", $data);
		}
	}

	public function deleteRecord($id)
	{
		$this->load->model('Services/services');
								
		// Create DB connection
		$con = $this->services->createDbConnection();
		
		$result = $this->services->deleteData($con, $id);
		
		// Close DB connection
		$this->services->closeDbConnection($con);
		
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

		$this->load->model('Services/services');

		// Create DB connection
		$con = $this->services->createDbConnection();
		
	 	$data['allServices'] = $this->services->search($con, $text);
	 	$data['searchText'] = $text;
		$this->services->closeDbConnection($con);
		
		$this->load->view('Services/view', $data);
	}

	public function getFeaturesTable($id = '')
	{
		$this->load->model('Services/services');
		$con = $this->services->createDbConnection();
		$data['serviceFeatures'] = $this->services->getFeaturesOfService($con,$id);
		$this->services->closeDbConnection($con);

		return $this->load->view('Services/featuresTable', $data, true);
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

