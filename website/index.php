<?php
	session_start();
	$server = "../resources/php/page.php";
	$login = "../resources/php/login.php";
	include($server);
	include($login);
	$gen = new page();
	$log = new login();
	$gen->head();
	$connection = $gen->connect();
?>

<?php $gen->title(); ?>

<?php $gen->navLogin(); ?>

<div class="container-fluid">
<div class="row">
	<div class="col-xs-6">
		<h1> Login </h1>
		<form id="Download1" action="<?php $log->login($connection, $_POST["username"], $_POST["password"])) ?>" method="post">
			Username: <input id="Download_Code" type="text" name="username" value="">  </br></br>
			Password: <input id="Download_Code" type="password" name="password" value=""> </br></br>
			<input id="Download_File" type="submit" name="submit" value="Login">
		</form>
	</div>
	<div class="col-xs-6">
		<form action="<?php $log->createAccount($connection, $_POST["username"], $_POST["password"])) ?>" method="post">
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