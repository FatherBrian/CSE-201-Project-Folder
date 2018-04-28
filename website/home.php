<?php
	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$home = "../resources/php/home.php";
	include($db);
	include($page);
	include($home);
	$server = new database();
	$gen = new page();
	$home = new home();
	$gen->head();
	$connection = $server->connect();
?>

<?php
	if(isset($_GET['register'])=='success') {
		$message = '<div class="container-fluid"><div class="row"><div class="col-xs-12"><h1>Account was registered successfully!</h1></div></div></div>';
	} else { $message = NULL; }
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>

<?php $home->generateHomePage($message, $connection, $server); ?>

<?php $gen->footer(); ?>

</body>
</html>