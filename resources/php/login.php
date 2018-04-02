<?php
class login {

	function connect() {
		$dbhost = "";
		$dbuser = "root";
		$dbpass = "";
		$dbname = "collegebook";
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

	function grab($connection) {		
		$query = "Select * From user Where username = 'nick'";
		$result = mysqli_query($connection, $query); // True or false if query works and finds record
		if ($result && mysqli_affected_rows($connection) == 1) { 	// Tests if anything was found && if something was successfully changed with connection 
			$array = mysqli_fetch_array($result); // Gets all values needed from specific query according to name
			echo "This worked!";
			$_SESSION['logged'] = "Yes";
		}
	}

	function userLogin($db) {
		$username = $_POST["username"];
		$password = $_POST["password"];
	    $query = "Select userID From user Where username ='$username' and password = '$password';";
	    $result = mysqli_query($db, $query);
		if (mysqli_num_rows($result) > 0) {
			$_SESSION['login_user'] = $myusername;
			header("location: home.php");
		} else {
			header("location: index.php?login=fail");
		}
    }


    function createAccount($db) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$email = $_POST["email"];

        $querycheck = "Select username From user Where username = '$username'";
        $resultcheck = mysqli_query($db, $querycheck);
        $count = mysqli_num_rows($resultcheck);

        if($count==0) {
			$query = "INSERT INTO user (username,password,email) VALUES('$username', '$password', '$email')";
			$result = mysqli_query($db,$query);
			if($result){
				header("location: home.php?register=success");
            }
        } else {
			header("location: index.php?create=fail");
		}
   }
}
?>