<?php
	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$home = "../resources/php/home.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($home);
	include($poster);
	$server = new database();
	$gen = new page();
	$home = new home();
	$poster = new post();
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

<?php $home->generateHomePage($message, $connection, $server, $poster); ?>

<?php $gen->footer(); ?>

</body>
</html>