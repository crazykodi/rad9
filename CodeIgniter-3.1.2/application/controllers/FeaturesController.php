<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->model('features');

		// Create DB connection
		$con = $this->features->createDbConnection();
		
		// Populate the form
		$data['allFeatures'] = $this->features->readData($con);
		$this->features->closeDbConnection($con);

		$this->load->view('view', $data);
	}

	public function editRecord($id)
	{
		$data['id'] = $id;
		$data['task'] = 'edit';

		$id = $this->test_input($id);
					
		$this->load->model('features');
		// Create DB connection
		$con = $this->features->createDbConnection();
		
		// Populate the form
		$record = $this->features->getRecord($con, $id);

		$this->features->closeDbConnection($con);
		
		if($row = $record->fetch_object()) {
			$data['txtName'] = $row->name;
			$data['txtDescription'] = $row->description;
			$data['txtPrice'] = $row->price;					
		}
		else {
			echo "No records found <br>";
		}

		$this->load->view('addEdit', $data);
	}

	public function addRecord() 
	{
		$this->load->view('addEdit');
	}

	public function insertRecord()
	{
		$this->load->model('features');
		// Create DB connection
		$con = $this->features->createDbConnection();
		
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);
		$price  = $this->input->post('price', true);
		$id = $this->input->post('id', true);

		$result = $this->features->insertData($con, $name, $description, $price);
		
		// Close DB connection
		$this->features->closeDbConnection($con);
		
		if($result) {
			// Populate the form
			$data['task'] = "created";
			$this->load->view("addEdit", $data);
			$this->load->view("message", $data);
		}
				
	}

	public function updateRecord() 
	{
		$this->load->model('features');
		// Create DB connection
		$con = $this->features->createDbConnection();
				
		$name = $this->input->post('name', true);
		$description = $this->input->post('description', true);
		$price  = $this->input->post('price', true);
		$id = $this->input->post('id', true);
				
		$result = $this->features->updateData($con, $name, $description, $price, $id);
		
		// Close DB connection
		$this->features->closeDbConnection($con);
				
		if($result) {
			// Populate the form
			$data['task'] = "updated";
			$this->load->view("addEdit", $data);
			$this->load->view("message", $data);
		}
	}

	public function deleteRecord($id)
	{
		$this->load->model('features');
		// Get variables
		//$id = $this->input->get('id', true);
						
		// Create DB connection
		$con = $this->features->createDbConnection();
		
		$result = $this->features->deleteData($con, $id);
		
		// Close DB connection
		$this->features->closeDbConnection($con);
		
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

		$this->load->model('features');

		// Create DB connection
		$con = $this->features->createDbConnection();
		
	 	$data['allFeatures'] = $this->features->search($con, $text);
	 	$data['searchText'] = $text;
		$this->features->closeDbConnection($con);
		
		$this->load->view('view', $data);
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