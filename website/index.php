<?php
	session_start();
//	$server = $_SERVER["DOCUMENT_ROOT"] . "/resources/php/Main.php"
	$server = "../resources/php/page.php";
	$login = "../resources/php/login.php";
	include($server);
	include($login);
//	$message = login_start(); // Gets login procedure, and also returns value that comes out of login function
//	start("Login", "none", 0);
	$gen = new page();
	$log = new login();
	$gen->head();
	$connection = $log->connect();
?>

<?php $gen->title(); ?>

<?php $gen->navLogin(); ?>

<div class="container-fluid">
<div class="row">
	<div class="col-xs-3">
		<h1> Login </h1>
		<form id="Download1" action="<?php $log->grab($connection) ?>" method="post">
			Username: <input id="Download_Code" type="text" name="username" value="">  </br></br>
			Password: <input id="Download_Code" type="password" name="password" value=""> </br></br>
			<input id="Download_File" type="submit" name="submit" value="Login">
		</form>
	</div>
</div>
</div>

<?php $gen->footer(); ?>

</body>
</html>