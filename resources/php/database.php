<?php
class database {

	function connect() {
		$user_agent = getenv("HTTP_USER_AGENT");

		if(strpos($user_agent, "Win") !== FALSE) { 
			$dbhost = "";
			$dbuser = "root";
			$dbpass = "";
			$dbname = "collegebook";	
		} elseif(strpos($user_agent, "Mac") !== FALSE) {
			$dbhost = "";
			$dbuser = "root";
			$dbpass = "root";
			$dbname = "collegebook";
		}
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
}

?>