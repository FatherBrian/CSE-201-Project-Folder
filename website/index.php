<?php
	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$login = "../resources/php/login.php";
	include($db);
	include($page);
	include($login);
	$server = new database();
	$gen = new page();
	$log = new login();
	$gen->head();
	$connection = $server->connect();
?>

<?php
	if (isset($_GET['action'])) { $action = $_GET['action']; } 
	else { $action = "none"; }

	if($action=='submitLogin') { $log->userLogin($connection); } 
	elseif($action=='submitAccount') { $log->createAccount($connection); }
	
	if(isset($_GET['login'])=='fail') { $loginHeader = "Login unsuccessful, please try again."; } 
	else { $loginHeader = "Login"; }

	if(isset($_GET['create'])=='fail') { $createHeader = "Account already exists"; } 
	else { $createHeader = "Create Account"; }	
?>

<?php $gen->title(); ?>

<?php $gen->navLogin(); ?>

<div class="container-fluid">
<div class="row">
	<div class="col-xs-6">
		<h1> <?php echo $loginHeader ?> </h1>
		<form id="Download1" action="?action=submitLogin" method="post">
			Email: <input id="Download_Code" type="text" name="email" value="">  </br></br>
			Password: <input id="Download_Code" type="password" name="password" value=""> </br></br>
			<input id="login" type="submit" name="submit" value="submit">
		</form>
	</div>
	<div class="col-xs-6">
		<h1> <?php echo $createHeader ?> </h1>
		<form id="Download1" action="?action=submitAccount" method="post">
			Username: <input id="Download_Code" type="text" name="username" value="">  </br></br>
			Password: <input id="Download_Code" type="password" name="password" value=""> </br></br>
			Email: <input id="Download_Code" type="text" name="email" value=""> </br></br>
			<input id="login" type="submit" name="submit" value="submit">
		</form>
	</div>
</div>
</div>

<?php $gen->footer(); ?>

</body>
</html>