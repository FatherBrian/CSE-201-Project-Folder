<?php

session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$college = "../resources/php/college.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($college);
	include($poster);
	$server = new database();
	$gen = new page();
	$college = new college();
	$poster = new post();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav($connection, $server); ?>

<?php $poster->checkIfPost($connection, 3) ?>

<?php $college->generateCollegePage($connection, $server, $poster); ?>

<?php $gen->footer(); ?>

</body>
</html>
