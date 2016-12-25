<?php

/**
* 
*/
class Packages extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function createDbConnection() {
		// Create DB connection
		$this->load->database();
		
		// @ $con = new mysqli("localhost","testuser","password");
		@ $con = new mysqli($this->db->hostname, $this->db->username, $this->db->password);
		if($con->connect_error) {
			 die ("couldn't connect. " . $con->connect_error);
		} else {
			//echo nl2br("Conneted \n");
		}

		// Select DB
		$con->select_db($this->db->database);
		
		return $con;
	}

	public function closeDbConnection($connection) {
		//$result->free();
		$connection->close();
		//echo "Connection closed! <br>";
	}

	public function insertData($connection,$name,$description,$price,$isTemp = 0) {
		$con = $connection;
		$insertQuery = "INSERT INTO packages (name,description,price,isTemp) VALUES ('$name','$description',$price,$isTemp)";
		//$result = $con->query($insertQuery);

		if ($con->query($insertQuery)) {
			//echo "New record created successfully <br>";
			return true;
		} else {
			echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function updateData($connection,$name,$description,$price,$id) {
		$con = $connection;
		$updateQuery = "UPDATE packages SET name = '$name', description = '$description', price = $price WHERE id = $id";
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
		$selectQuery = "SELECT * FROM packages";
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
		$selectQuery = "SELECT * FROM packages WHERE id = " . $id;
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
		
		$searchQuery = "SELECT * FROM packages WHERE name like '%" . $name . "%'";
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
		$deleteQuery = "DELETE FROM packages where id = $id";
		
		if ($con->query($deleteQuery)) {
			//echo "Record deleted successfully <br>";
			return true;
		} else {
			echo "Error: " . $deleteQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function attachFeature($connection,$packageId,$features) {
		if(!isset($features)) {
			echo "features is not set";
		}

		$con = $connection;
		
/*		var_dump($packageId);
		echo "<br>";
		var_dump($features);*/

		$insertValues = array();
		foreach ($features as $feature) {
			array_push($insertValues, "(".$packageId.",".$feature.")");
		}

		$insertIds = join(",", $insertValues);

		$updateQuery = "INSERT INTO package_feature (package_id, feature_id) VALUES $insertIds";

		if ($con->query($updateQuery)) {
			return true;
		} else {
			echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
			return false;
		}
	}

	public function updateFeatures($connection, $packageId, $features) {
		$featureIds = join(",",$features);
		$deleteQuery = "DELETE FROM package_feature WHERE package_id = $packageId AND feature_id not IN ($featureIds)";

		$insertValues = array();
		foreach ($features as $feature) {
			array_push($insertValues, "(".$packageId.",".$feature.")");
		}

		$insertIds = join(",", $insertValues);
		$insertQuery = "INSERT IGNORE INTO package_feature (package_id, feature_id) VALUES $insertIds";

		if ($connection->query($deleteQuery)) {
			if ($connection->query($insertQuery)) {
				return true;
			}
			else {
				echo "Error: " . $insertQuery . "<br>" . mysqli_error($connection);
				return false;
			}
		} 
		else {
			echo "Error: " . $deleteQuery . "<br>" . mysqli_error($connection);
			return false;
		}
	}

	public function getPackages($connection) {
		$con = $connection;
		$selectQuery = "SELECT id,name FROM packages";
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

	public function getFeaturesOfPackages($connection, $packageId = '') {
		if($packageId == '') {
			$selectQuery = "SELECT * FROM features";
		}
		else {
			$selectQuery = "SELECT f.* FROM features f JOIN package_feature pf ON f.id = pf.feature_id JOIN packages p ON p.id = pf.package_id WHERE p.id = $packageId";
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

	public function getLastPackage($connection, $name) {
		$selectQuery = "SELECT id FROM packages WHERE name = '$name' ORDER BY id DESC LIMIT 1";
		$result = $connection->query($selectQuery);
		if(!$result) {
			die ("Database error occured. " . mysqli_error($connection));
		}
		
		if($result->num_rows > 0) {			
			return $result;		
		}
		else {
			echo "No packages with the name " . $name;
			return null;
		}	
	}

}

?>