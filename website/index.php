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
	if (isset($_SESSION['userID'])) { header("location: home.php"); }
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

<?php $log->makeLoginPage($createHeader, $loginHeader, $connection); ?>

<?php $gen->footer(); ?>

</body>
</html>