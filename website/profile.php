<?php

session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$profile = "../resources/php/profile.php";
	include($db);
	include($page);
	include($profile);
	$server = new database();
	$gen = new page();
	$profile = new profile();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>



<?php $profile->generateProfile($connection); ?>

<?php $gen->footer(); ?>

</body>
</html>

