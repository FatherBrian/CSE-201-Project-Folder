<?php

session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$group = "../resources/php/group.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($group);
	include($poster);
	$server = new database();
	$gen = new page();
	$group = new group();
	$poster = new post();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->processAction($connection, "group"); ?>

<?php $gen->title(); ?>

<?php $gen->nav($connection, $server); ?>

<?php $poster->checkIfPost($connection, 2) ?>

<?php $group->generateGroupPage($connection, $server, $poster, $gen); ?>

<?php $gen->footer(); ?>

</body>
</html>
