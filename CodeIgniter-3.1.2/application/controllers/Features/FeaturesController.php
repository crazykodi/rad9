<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeaturesController extends CI_Controller {

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
		$this->load->model('Features/Features');

		// Create DB connection
		$con = $this->Features->createDbConnection();
		
		// Populate the form
		$data['allFeatures'] = $this->Features->readData($con);		

		$this->Features->closeDbConnection($con);

		$this->load->view('Features/View', $data);
	}

	public function editRecord($id)
	{
		$data['id'] = $id;
		$data['task'] = 'edit';
		$data['title'] = 'Update feature';

		$id = $this->test_input($id);
					
		$this->load->model('Features/Features');
		// Create DB connection
		$con = $this->Features->createDbConnection();
		
		// Populate the form
		$record = $this->Features->getRecord($con, $id);

		$data['services'] = $this->getServices($con);

		$this->Features->closeDbConnection($con);
		
		if($row = $record->fetch_object()) {
			$data['txtName'] = $row->name;
			$data['txtDescription'] = $row->description;
			$data['txtPrice'] = $row->price;					
			$data['serviceId'] = $row->service_id;
		}
		else {
			echo "No records found <br>";
		}

		$this->load->view('Features/AddEdit', $data);
	}

	public function addRecord() 
	{
		$data['title'] = 'Add new feature';

		$this->load->model('Services/Services');
		$con = $this->Services->createDbConnection();
		$data['services'] = $this->getServices($con);

		$this->load->view('Features/AddEdit', $data);
	}

	public function insertRecord()
	{
		$this->load->model('Features/Features');
		// Create DB connection
		$con = $this->Features->createDbConnection();
		
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);
		$price  = $this->input->post('price', true);
		$id = $this->input->post('id', true);
		$service_id = $this->input->post('service', true);

		$result = $this->Features->insertData($con, $name, $description, $price, $service_id);

		$data['services'] = $this->getServices($con);
		
		// Close DB connection
		$this->Features->closeDbConnection($con);
		
		if($result) {
			// Populate the form
			$data['task'] = "created";
			$this->load->view("Features/AddEdit", $data);
			$this->load->view("message", $data);
		}				
	}

	public function updateRecord() 
	{
		$this->load->model('Features/Features');
		// Create DB connection
		$con = $this->Features->createDbConnection();
				
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);
		$price  = $this->input->post('price', true);
		$id = $this->input->post('id', true);
		$service_id = $this->input->post('service', true);

		$result = $this->Features->updateData($con, $name, $description, $price, $service_id, $id);

		$data['services'] = $this->getServices($con);
		
		// Close DB connection
		$this->Features->closeDbConnection($con);
				
		if($result) {
			// Populate the form
			$data['task'] = "updated";
			$this->load->view("Features/AddEdit", $data);
			$this->load->view("message", $data);
		}
	}

	public function deleteRecord($id)
	{
		$this->load->model('Features/Features');
		// Get variables
		//$id = $this->input->get('id', true);
						
		// Create DB connection
		$con = $this->Features->createDbConnection();
		
		$result = $this->Features->deleteData($con, $id);
		
		// Close DB connection
		$this->Features->closeDbConnection($con);
		
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

		$this->load->model('Features/Features');

		// Create DB connection
		$con = $this->Features->createDbConnection();
		
	 	$data['allFeatures'] = $this->Features->search($con, $text);
	 	$data['searchText'] = $text;
		$this->Features->closeDbConnection($con);
		
		$this->load->view('Features/View', $data);
	}

	public function getServices($con) {
		// Get the services name and id
		$this->load->model('Services/Services');
		$services = $this->Services->getServices($con);
		
		return $services;
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