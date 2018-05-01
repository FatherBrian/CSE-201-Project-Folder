<?php
	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$connectionsClass = "../resources/php/connections.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($connectionsClass);
	include($poster);
	$server = new database();
	$gen = new page();
	$connectionsClass = new connections();
	$poster = new post();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav($connection, $server); ?>

<?php $connectionsClass->generateConnections($connection, $server); ?>

<?php $gen->footer(); ?>

</body>
</html>

