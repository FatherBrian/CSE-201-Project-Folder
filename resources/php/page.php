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
				<h1> CollegeBook </h1>
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
		$text = '<nav style="margin: 0;" class="navbar navbar-inverse navbar-static-top">
		  <div class="container-fluid">

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="navbar-header" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="dropdown">
				<li><a href="/AKPsi-Attendance/Login.php">Login</a></li>
				</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>';
		echo $text;
	}

	//General Input Fucntions
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

	function nav() {
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