<?php
class login {

	function connect() {
		$dbhost = "";
		$dbuser = "akpsfzgp_akpsiLA";
		$dbpass = "akpsihonor&integrity!";
		$dbname = "akpsfzgp_akpsight";
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		// Testing connection success/failure
		if(mysqli_connect_errno()) {
			die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"); 
		}
		return $connection;
	}

	function close($connection) {
		mysqli_close($connection);
	}

	function grab($connection, $query) {		
		$result = mysqli_query($connection, $query); // True or false if query works and finds record
		if ($result && mysqli_affected_rows($connection) == 1) { 	// Tests if anything was found && if something was successfully changed with connection 
			$array = mysqli_fetch_array($result); // Gets all values needed from specific query according to name

			$_SESSION['logged'] = "Yes";
		}
	}

	
?>