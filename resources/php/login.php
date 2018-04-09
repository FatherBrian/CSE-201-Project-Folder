<?php
class login {

	function userLogin($db) {
		$email = $_POST["email"];
		$password = $_POST["password"];
	    $query = "Select userID From user Where email ='$email' and password = '$password';";
	    $result = mysqli_query($db, $query);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['userID'] = $row["userID"];
			header("location: home.php");
		} else {
			header("location: index.php?login=fail");
		}
	}

    function createAccount($db) {
		$fName = $_POST["fName"];
		$lName = $_POST["lName"];
		$password = $_POST["password"];
		$bDate = $_POST["bDate"];
		$college = $_POST["college"];
		$country = $_POST["country"];
		$email = $_POST["email"];

        $querycheck = "Select username From user Where email = '$email'";
        $resultcheck = mysqli_query($db, $querycheck);
        $count = mysqli_num_rows($resultcheck);

        if($count==0) {
			$query = "INSERT INTO user (fName, lName, password, bDate, college, country, email) VALUES('$fName', '$lName', '$password', '$bDate', '$college', '$country', '$email')";
			$result = mysqli_query($db,$query);
			if($result) {
				$lastID = mysqli_insert_id($db);
				$_SESSION["userID"] = $lastID;
				header("location: home.php?register=success");
            }
        } else {
			header("location: index.php?create=fail");
		}
   }
}
?>