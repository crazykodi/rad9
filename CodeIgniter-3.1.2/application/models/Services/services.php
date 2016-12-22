<?php

/**
* 
*/
class services extends CI_Model
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

	public function insertData($connection,$name,$description) {
		$con = $connection;
		$insertQuery = "INSERT INTO services (name,description) VALUES ('$name','$description')";
		//$result = $con->query($insertQuery);

		if ($con->query($insertQuery)) {
			//echo "New record created successfully <br>";
			return true;
		} else {
			echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function updateData($connection,$name,$description,$id) {
		$con = $connection;
		$updateQuery = "UPDATE services SET name = '$name', description = '$description' WHERE id = $id";
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
		$selectQuery = "SELECT * FROM services";
		$result = $con->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($con));
		}
		
		if($result->num_rows > 0) {
			return $result;		
		}
		else {
			// echo "No data";
			return null;
		}		
	}

	public function getRecord($connection,$id) {
		$con = $connection;		
		$selectQuery = "SELECT * FROM services WHERE id = " . $id;
		$result = $con->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($con));
		}
		
		if($result->num_rows > 0) {
			return $result;
		}
		else {
			// echo "No data";
			return null;
		}		
	}

	public function search($connection,$name) {
		$con = $connection;
		
		$searchQuery = "SELECT * FROM services WHERE name like '%" . $name . "%'";
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
		$deleteQuery = "DELETE FROM services where id = $id";
		
		if ($con->query($deleteQuery)) {
			//echo "Record deleted successfully <br>";
			return true;
		} else {
			echo "Error: " . $deleteQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function attachFeature($connection,$serviceId,$featureId) {
		$con = $connection;
		$updateQuery = "UPDATE features SET service_id = $serviceId WHERE id = $featureId";

		if ($con->query($updateQuery)) {
			return true;
		} else {
			echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function getServices($connection) {
		$con = $connection;
		$selectQuery = "SELECT id,name FROM services";
		$result = $con->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($con));
		}
		
		if($result->num_rows > 0) {
			$array = array();
			while($row = $result->fetch_object()) {
				$array[$row->id] = $row->name;				
			}
			
			return $array;		
		}
		else {
			// echo "No data";
			return null;
		}	
	}

	public function getFeaturesOfService($connection, $serviceId) {
		if($serviceId == '') {
			$selectQuery = "SELECT * FROM features";
		}
		else {
			$selectQuery = "SELECT * FROM features WHERE service_id = $serviceId";
		}

		$result = $connection->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($connection));
		}
		
		if($result->num_rows > 0) {
			return $result;		
		}
		else {
			// echo "No data";
			return null;
		}		
	}

}

?>