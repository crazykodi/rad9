<?php

/**
* 
*/
class features extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function createDbConnection() {
		// Create DB connection
		@ $con = new mysqli("localhost","testuser","password");
		if($con->connect_error) {
			 die ("couldn't connect. " . $con->connect_error);
		} else {
			//echo nl2br("Conneted \n");
		}

		// Select DB
		$con->select_db("test");
		
		return $con;
	}

	public function closeDbConnection($connection) {
		//$result->free();
		$connection->close();
		//echo "Connection closed! <br>";
	}

	public function insertData($connection,$name,$description,$price,$service_id) {
		$con = $connection;
		$insertQuery = "INSERT INTO features (name,description,price,service_id) VALUES ('$name','$description',$price,$service_id)";
		//$result = $con->query($insertQuery);

		if ($con->query($insertQuery)) {
			//echo "New record created successfully <br>";
			return true;
		} else {
			echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function updateData($connection,$name,$description,$price,$service_id,$id) {
		$con = $connection;
		$updateQuery = "UPDATE features SET name = '$name', description = '$description', price = $price, service_id = $service_id WHERE id = $id";
		//$result = $con->query($updateQuery);
		if ($con->query($updateQuery)) {
			//echo "Record updated successfully <br>";
			return true;
		} else {
			echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function readData($connection) {
		$con = $connection;
		$selectQuery = "SELECT * FROM features";
		$result = $con->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($con));
		}
		
		if($result->num_rows > 0) {
			return $result;		
		}
		else {
			echo "No data";
			return null;
		}		
	}

	public function getRecord($connection,$id) {
		$con = $connection;
		//echo "ID to modify: " . $id;
		$selectQuery = "SELECT * FROM features WHERE id = " . $id;
		$result = $con->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($con));
		}
		
		if($result->num_rows > 0) {
			return $result;
		}
		else {
			echo "No data";
			return null;
		}		
	}

	public function search($connection,$name) {
		$con = $connection;
		
		$searchQuery = "SELECT * FROM features WHERE name like '%" . $name . "%'";
		$result = $con->query($searchQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($con));
		}
		
		if($result->num_rows > 0) {
			return $result;
		}
		else {
			//echo "No data";
			return null;
		}
	}

	public function deleteData($connection,$id) {
		$con = $connection;
		$deleteQuery = "DELETE FROM features where id = $id";
		
		if ($con->query($deleteQuery)) {
			//echo "Record deleted successfully <br>";
			return true;
		} else {
			echo "Error: " . $deleteQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

}

?>