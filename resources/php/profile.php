<?php
class profile {

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


}	
?>