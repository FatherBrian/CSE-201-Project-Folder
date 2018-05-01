<?php

session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$profile = "../resources/php/profile.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($profile);
	include($poster);
	$server = new database();
	$gen = new page();
	$profile = new profile();
	$poster = new post();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->processAction($connection, "profile"); ?>

<?php $gen->title(); ?>

<?php $gen->nav($connection, $server); ?>

<?php $poster->checkIfPost($connection, 1) ?>

<?php $profile->generateProfilePage($connection, $server, $poster, $gen); ?>

<?php $gen->footer(); ?>

</body>
</html>

