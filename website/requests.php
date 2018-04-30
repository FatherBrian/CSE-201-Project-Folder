<?php
	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$requests = "../resources/php/requests.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($requests);
	include($poster);
	$server = new database();
	$gen = new page();
	$requests = new requests();
	$poster = new post();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>

<?php $requests->generateRequests($connection, $server); ?>

<?php $gen->footer(); ?>

</body>
</html>

