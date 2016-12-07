<?php

function createDbConnection() {
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

function closeDbConnection($connection) {
	//$result->free();
	$connection->close();
	//echo "Connection closed! <br>";
}

function insertData($connection,$name,$description,$price) {
	$con = $connection;
	$insertQuery = "INSERT INTO features (name,description,price) VALUES ('$name','$description',$price)";
	//$result = $con->query($insertQuery);

	if ($con->query($insertQuery)) {
		//echo "New record created successfully <br>";
		return true;
	} else {
		echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
		return false;
	}
}

function updateData($connection,$name,$description,$price,$id) {
	$con = $connection;
	$updateQuery = "UPDATE features SET name = '$name', description = '$description', price = $price WHERE id = $id";
	//$result = $con->query($updateQuery);
	if ($con->query($updateQuery)) {
		//echo "Record updated successfully <br>";
		return true;
	} else {
		echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
		return false;
	}
}

function readData($connection) {
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

function getRecord($connection,$id) {
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

function search($connection,$name) {
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

function deleteData($connection,$id) {
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


?>