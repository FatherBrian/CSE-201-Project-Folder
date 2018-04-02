<?php
	session_start();
	$page = "../resources/php/page.php";
	$db = "../resources/php/database.php";
	$login = "../resources/php/login.php";
	include($page);
	include($login);
	include($db);
	$gen = new page();
	$log = new login();
	$server = new database();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->navLogin(); ?>

<div class="container-fluid">
<div class="row">
	<div class="col-xs-6">
		<h1> Create Account </h1>
		<form action="createAccount()" method="post">
			Username: <input id="Download_Code" type="text" name="username" value="">  </br></br>
			Password: <input id="Download_Code" type="password" name="password" value=""> </br></br>
			<input id="account" type="submit" name="submit" value="Login">
		</form>
	</div>
</div>
</div>

<?php 
	function createAccount() {		
		if(isset($_POST['submit'])) {
			$log->createAccount($connection);
		}
	}
?>

<?php $gen->footer(); ?>

</body>
</html>