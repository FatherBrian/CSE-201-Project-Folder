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
		$message = "<h1>Account was registered successfully!</h1>";
	} else { $message = ''; }
	$home->generateHomePage($message);
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>

<?php $home->makeHomePage($message, $connection); ?>

<?php $gen->footer(); ?>

</body>
</html>