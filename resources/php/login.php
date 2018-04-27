<?php
class login {

	function makeLoginPage($createHeader, $loginHeader, $db) {
		$text = '<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6">
				<h1>'. $loginHeader .'</h1>
				<form id="Download1" class="loginForm" action="?action=submitLogin" method="post">
					<span class="field"> Email: <input id="Download_Code" type="text" name="email" value=""></span>
					<span class="field"> Password: <input id="Download_Code" type="password" name="password" value=""></span>
					<input class="addFriendButton" id="login" type="submit" name="submit" value="Login">
				</form>
			</div>
			<div class="col-xs-6">
				<h1>'. $createHeader .'</h1>
				<form id="Download1" class="loginForm" action="?action=submitAccount" method="post">
					<span class="field"> First Name: <input id="Download_Code" type="text" name="fName" value=""></span>
					<span class="field"> Last Name: <input id="Download_Code" type="text" name="lName" value=""></span>
					<span class="field"> Password: <input id="Download_Code" type="password" name="password" value=""></span>
					<span class="field"> Birthday: <input id="Download_Code" type="date" name="bDate" value=""></span>
					<span class="field"> College: '. $this->pullColleges($db) .'</span>
					<span class="field"> Country: <input id="Download_Code" type="text" name="country" value=""></span>
					<span class="field"> Email: <input id="Download_Code" type="text" name="email" value=""></span>
					<input class="addFriendButton" id="login" type="submit" name="submit" value="Create Account">
				</form>
			</div>
		</div>
		</div>';
		echo $text;
	}

	function pullColleges($db) {
		$text = '<select name="college">';
        $query = "SELECT * FROM college";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
				$text .= '<option value='. $row["collegeID"] .'>'. $row["name"] ."</option>";
			}
		}
		$text .= "</select>";
		return $text;
	}
	function userLogin($db) {
		$email = $_POST["email"];
		$password = $_POST["password"];
	    $query = "Select userID From users Where email ='$email' and password = '$password';";
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

        $querycheck = "Select username From users Where email = '$email'";
        $resultcheck = mysqli_query($db, $querycheck);
        $count = mysqli_num_rows($resultcheck);

        if($count==0) {			
			$query = "INSERT INTO users (fName, lName, password, bDate, collegeID, country, email, srcImg) VALUES('$fName', '$lName', '$password', '$bDate', '$college', '$country', '$email', NULL)";
			echo $query;
			$result = mysqli_query($db,$query);
			if($result) {
				$lastID = mysqli_insert_id($db);
				$_SESSION["userID"] = $lastID;
				$query = "INSERT INTO party (partyID, partyTypeID) VALUES('$lastID', 1)";
				$result = mysqli_query($db, $query);
				if(!$result) {
					$query = "DELETE FROM users WHERE userID = ". $lastID;
					header("location: home.php?create=fail");
				}
				header("location: home.php?register=success");
            }
        } else {
			header("location: index.php?create=fail");
		}
   }
}
?>