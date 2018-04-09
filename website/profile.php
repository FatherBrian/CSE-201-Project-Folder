<?php>

function connect() {
		$dbhost = "";
		$dbuser = "root";
		$dbpass = "";
		$dbname = "collegebook";
		$connection = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);
		// Testing connection success/failure
		if(mysql_connect_errno()) {
			die("Database connection failed: " . mysql_connect_error() . " (" . mysql_connect_errno() . ")"); 
		}
		return $connection;
	}

	function close($connection) {
		mysql_close($connection);
	}

mysql_select_db(“user”)

$userid = $_REQUEST(‘user ID’);

$get = mysql_query(“SELECT * FROM userid WHERE userid = ‘$user ID’”);
$get2 = mysql_fetch_assoc($get);
$username = $get2 (‘user Name’)

?>

<html>
	<head>
		<title> Profile Page:</title>
	</head>
<center>
<body>
<br/>
<br/>
<br/>
<br/>

ID: <b><?php echo $userID; ?></b> 
User Name: <b><?php echo $username; ?></b> 
Password: <b><?php echo $Password; ?></b> 
E-mail: <b><?php echo $e-mail; ?></b> 


</body>
</center>
</html>