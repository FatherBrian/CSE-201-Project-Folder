<?php
class page {
	
	// Functions meant to generate html text
	function head() {
		$text = ' <!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1"> 
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/
			bootstrap.min.css">
			<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
			<link rel="stylesheet" href="../resources/css/style.css">
		</head>';
		echo $text;
	}

	function title() {
		$text = '<header class="bgimage">
			<div class="Header container-fluid">
				<a href="/CSE-201-Project-Folder/website" style="text-decoration:none; color:black;"><h1> CollegeBook </h1></a>
			</div>
		</header>';
		echo $text;
	}
		
	function footer() {
		$text = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="/resources/js/script.js"></script>
		<script src="/resources/js/bootbox.min.js"></script>';
			echo $text;
	}

	function navLogin() {
		$text = '<nav style="margin-bottom:10px;" class="navbar navbar-inverse navbar-static-top">
		  <div class="container-fluid">

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="navbar-header" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="dropdown">
				<li><a href="/CSE-201-Project-Folder/website/index.php">Login</a></li>
				</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>';
		echo $text;
	}

	function nav($connection, $db) {
		$img = $db->getProfilePic($connection);
		$text = '<nav style="margin-bottom:10px" class="navbar navbar-inverse navbar-static-top">
		  <div class="container-fluid">

			<!-- Collect the nav links, forms, and other content for toggling -->
			  <ul class="nav navbar-nav">
				<li class="dropdown">
				<li>
					<a href="/CSE-201-Project-Folder/website/profile.php?id='. $_SESSION["userID"] . '">
					<span><img style="width:30px;" src="'. $img .'"/></span>
					Profile</a></li>
				</li>
				<li>
				    <form action="/CSE-201-Project-Folder/website/searchResults.php" style="padding-top:20px;" method="post">
				    <input type="search" name="searchEntry" value="" placeholder="Enter a name">
				    <input type="submit" name="submitEntry" value="Search">
				    </form></li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li><a style="padding-top:20px;" href="/CSE-201-Project-Folder/website/college.php?id='. $_SESSION["collegeID"] .'">College</a></li>
				<li><a style="padding-top:20px;" href="/CSE-201-Project-Folder/website/requests.php">Requests</a></li>
				<li><a style="padding-top:20px;" href="/CSE-201-Project-Folder/website/connections.php">Connections</a></li>
				<li><a style="padding-top:20px;" href="/CSE-201-Project-Folder/website/message.php">Messages</a></li>
				<li><a style="padding-top:20px; margin-right:15px;" href="/CSE-201-Project-Folder/website/logout.php">Logout</a></li>
			  </ul>
		  </div><!-- /.container-fluid -->
		</nav>';
		echo $text;
	}
	
	
	
	// Profile-specific functions
    function generateButtons($connection, $page, $profileType) {
		$id = $_GET['id'];
		if ($profileType == 1) $type = "Friend";
		else $type = "Group";
		
		$text = $this->displayPicture($connection, $type);
		if ($text == NULL) {
			$status = $this->getConnectionStatus($connection, $id, $profileType);
			$text .= $this->displayStatus($status, $id, $type);
		}
        return $text;
    }

	function getConnectionStatus($connection, $otherID, $profileType) {
        $id = $_SESSION['userID'];
		if ($id == $otherID && $profileType == 1) { return "Same person"; }
        $query = "SELECT * FROM connections WHERE userID = '$id' AND otherID = '$otherID' AND otherPartyTypeID = '$profileType'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) return "Connection";
		else {
			$query2 = "SELECT * FROM request WHERE (requesterID = '$id' AND requesteeID = '$otherID' AND requesteePartyTypeID = '$profileType')";
			$result2 = mysqli_query($connection, $query2);
			if(mysqli_num_rows($result2) > 0) { return "Sent Request"; } 
			$query3 = "SELECT * FROM request WHERE (requesterID = '$otherID' AND requesteeID = '$id' AND requesteePartyTypeID = '$profileType')";
			$result3 = mysqli_query($connection, $query3);
			if(mysqli_num_rows($result3) > 0) { return "Recieved Request"; } 			
			else { return "No Sent Request"; }
		}
	}
	
	function displayStatus($status, $id, $type) {
        $text = '';
        if($status == "Connection") {
            $text .= '<form action="?id='. $id .'&action=delete" method="post">';
			$text .= '<input class="buttonDesign1" type="submit" value="Remove ' . $type .'"></form>';
        } else if ($status == "Sent Request") {
            $text .= '<form action="?id='. $id .'&action=removeRequest" method="post">';
			$text .= '<input class="buttonDesign1" type="submit" value="Remove ' . $type .' Request"></form>';
		} else if ($status == "No Sent Request") {
            $text .= '<form action="?id='. $id .'&action=sendRequest" method="post">';
			$text .= '<input class="buttonDesign1" type="submit" value="Send ' . $type .' Request"></form>';			
		} else if ($status == "Recieved Request") {
            $text .= '<form action="?id='. $id .'&action=add" method="post">';
			$text .= '<input class="buttonDesign1" type="submit" value="Accept ' . $type .' Request"></form>';			
		}
		return $text;
	}
	
	function displayPicture($connection, $type) {
		$id = $_GET["id"];
		if ($type == "Group") $canUpload = $this->isGroupManager($connection);
		else if ($_SESSION["userID"] == $id) $canUpload = True;
		else $canUpload = False;

		$text = NULL;
		if ($canUpload) {
			$text .= '<form action="?id='. $id .'&action=uploadImg" class="profileForm" method="post" enctype="multipart/form-data">';
			$text .= 'Select New Image: <input type="file" class="uploadImgButton" name="srcImg" id="srcImg" accept="image/*">';
			$text .= '<input class="buttonDesign1 uploadImg" value="Upload Image" type="submit"></form>';
		}
		return $text;
	}
	
	function isGroupManager($connection) {
		$id = $_SESSION["userID"];
		$groupID = $_GET["id"];
		$query = "Select * From groups Where managerID = '$id' And groupID = '$groupID'";
		// echo $query;
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) return True;
		else return False;
	}
	
	function processAction($connection, $type) {
		if (isset($_GET['action'])) { $action = $_GET['action']; } 
		else { $action = "none"; }
		
		if ($action == 'uploadImg') { $this->uploadImage($connection, $type, $_FILES); }
		if ($action == 'uploadSuccess') { $this->uploadImage($connection, $type, $_FILES); }

		if ($action=='add') { $this->acceptConnection($connection, $type); } 
		elseif ($action=='delete') { $this->deleteConnection($connection, $type); }
		elseif ($action=='removeRequest') { $this->removeRequest($connection, $type); }
		elseif ($action=='sendRequest') { $this->sendRequest($connection, $type); }
	}
	
	function uploadImage($connection, $type, $img) {
		print_r($img);
		$dir = dirname(__FILE__) . "/../img/";
		$uploadFile = $dir . basename($img['srcImg']['name']);
		
		if (move_uploaded_file($img['srcImg']['tmp_name'], $uploadFile)) $message = "File is valid, and was successfully uploaded.\n";
		else $message = "Upload failed";
		
		$id = $_GET["id"];
		if ($type == "profile") {
			$query = "UPDATE users SET srcImg = '". basename($img['srcImg']['name']) ."' WHERE userID = ". $id;
			mysqli_query($connection, $query);
			header ("location: ". $type .".php?id=". $id);
		} else {
			$query = "UPDATE groups SET srcImg = '". basename($img['srcImg']['name']) ."' WHERE groupID = ". $id;
			mysqli_query($connection, $query);
			header ("location: ". $type .".php?id=". $id);			
		}
		
	}
	
    function acceptConnection($connect, $type) {
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];
		if ($type == "profile") $typeID = 1;
		else $typeID = 2;

        $query = "INSERT INTO connections (userID, otherID, otherPartyTypeID) VALUES ('$id', '$otherID', '$typeID')";
        mysqli_query($connect, $query);
        // $query2 = "INSERT INTO connections (userID, otherID, otherPartyTypeID) VALUES ('$otherID', '$id', '$typeID')";
        // mysqli_query($connect, $query2);

        $query = "DELETE FROM request WHERE (requesterID = '$otherID' and requesteeID = '$id' and requesteePartyTypeID = '$typeID')";
        mysqli_query($connect, $query);
		
		header ("location: ". $type .".php?id=". $otherID);
    }

    function deleteConnection($connect, $type) {
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];
		if ($type == "profile") $typeID = 1;
		else $typeID = 2;

        $query = "DELETE FROM connections WHERE (userID = '$id' and otherID = '$otherID' and otherPartyTypeID = '$typeID')";
        // $query = "DELETE FROM connections WHERE (userID = '$id' and otherID = '$otherID' and otherPartyTypeID = '$typeID') OR (userID = '$otherID' and otherID = '$id' and otherPartyTypeID = '$typeID')";
        mysqli_query($connect, $query);
		header ("location: ". $type .".php?id=". $otherID);
	}
	
    function sendRequest($connect, $type) {
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];
		if ($type == "profile") $typeID = 1;
		else $typeID = 2;

        $query = "INSERT INTO request (requesterID, requesteeID, requesteePartyTypeID) VALUES ('$id', '$otherID', '$typeID')";
        mysqli_query($connect, $query);
		header ("location: ". $type .".php?id=". $otherID);
    }

    function removeRequest($connect, $type){
        $id = $_SESSION['userID'];
		$otherID = $_GET['id'];
		if ($type == "profile") $typeID = 1;
		else $typeID = 2;

        $query = "DELETE FROM request WHERE requesterID = '$id' and requesteeID = '$otherID' and requesteePartyTypeID = '$typeID'";
        mysqli_query($connect, $query);
		header ("location: ". $type .".php?id=". $otherID);
    }

	
	//General Input Functions
	function show_subitem() {
		$text = '$(document).ready(function () {
					var subitem = $(".subitem");
					$(\'.item\').on("click", "li", function () {
						subitem.hide();
						$(".subitem", this).show();
					});
				});';
		echo $text;
	}
		
	function send_text($title, $alert, $class) {
		$text = '$(document).on("click", $class, function(e) {
					bootbox.prompt({
						title: $title,
						value: "Type here",
						callback: function(result) {               
							if (result === null) {                    	  
							} else {
								bootbox.alert($alert);                          
							}
						}
					});
				});';
		echo $text;
	}

	// Navegation bar and queries to build it out
	function nav_Involvement($connection) { // Builds involvement bar options for navegation
		$userID = $_SESSION['id'];
		$query = " SELECT Committees.committeeName
					FROM UserCommittee
					INNER JOIN Committees ON UserCommittee.committeeID = Committees.committeeID
					WHERE UserCommittee.userID = " . $userID . ";";
		$result = mysqli_query($connection, $query);
		$text = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Committee Involvement <span class="caret"></span></a>';
		$text .= '<ul class="dropdown-menu">';
		if (mysqli_query($connection, $query)) {  
			while($row = mysqli_fetch_assoc($result)) {
				$committeeName = $row["committeeName"];
				$committeeLink = str_replace(" ", "-", $row["committeeName"]);
				$text .= '<li><a href="/Committee-Involvement/' . $committeeLink . '/index.php">' . $committeeName . '</a></li>';
			}
		}
		$text  .= '</ul>';
		return $text;
	}


	function nav_Management($connection) { // Builds involvement bar options for navegation
		$userID = $_SESSION['id'];
		$query = " SELECT Committees.committeeName
					FROM UserCommittee
					INNER JOIN Committees ON UserCommittee.committeeID = Committees.committeeID
					WHERE UserCommittee.userID = " . $userID . " AND UserCommittee.isHead = 1;";
		$result = mysqli_query($connection, $query);
		$text = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Committee Management <span class="caret"></span></a>';
		$text .= '<ul class="dropdown-menu">';
		if (mysqli_query($connection, $query)) {  
			while($row = mysqli_fetch_assoc($result)) {
				$committeeName = $row["committeeName"];
				$committeeLink = str_replace(" ", "-", $row["committeeName"]);
				$text .= '<li><a href="/Committee-Management/' . $committeeLink . '/index.php">' . $committeeName . '</a></li>';
			}
		} 
		if ($committeeName == "") $text .= '<li><a>None Available</a></li>'; // Add text if person isn't head of a committee
		$text  .= '</ul>';
		return $text;
	}

	function navOld() {
		$connection = connect();
		$text = '
		<nav style="margin: 0;" class="navbar navbar-inverse navbar-static-top">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Committee Information <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="/Committee-Information/Investment/index.php">Investment</a></li>
					<li><a href="/Committee-Information/Finance/index.php">Finance</a></li>
					<li><a href="/Committee-Information/Professional-Development/index.php">Professional-Development</a></li>
					<li><a href="/Committee-Information/Fundraising/index.php">Fundraising</a></li>
					<li><a href="/Committee-Information/Master-of-Rituals/index.php">Master of Rituals</a></li>
					<li><a href="/Committee-Information/Philanthropy/index.php">Philanthropy</a></li>
					<li><a href="/Committee-Information/Brotherhood/index.php">Brotherhood</a></li>	
					<li><a href="/Committee-Information/Marketing/index.php">Marketing</a></li>
					<li><a href="/Committee-Information/Member-Education/index.php">Member Education</a></li>	
					<li><a href="/Committee-Information/Alumni-Relations/index.php">Alumni Relations</a></li>
					<li><a href="/Committee-Information/Warden/index.php">Warden</a></li>	
				  </ul>
				</li>';
					$text .= nav_Involvement($connection);
					$text .= nav_Management($connection);
		$text .= '<li><a href="/News.php"> News <span class="sr-only">(current)</span></a></li>
				<li><a href="/Profile.php">Profile</a></li>
				<li><a href="/Messages.php">Messages</a></li>
				</li>
				</ul>
			  
			  <form class="navbar-form navbar-right" role="search">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			  </form>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>';
		echo $text;
	}
}

	
?>