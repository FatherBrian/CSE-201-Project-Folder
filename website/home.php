<?php
	session_start();
	$server = "../resources/php/page.php";
	$login = "../resources/php/home.php";
	include($server);
	include($login);
	$gen = new page();
	$home = new home();
	$gen->head();
	$connection = $gen->connect();
?>

<?php $gen->title(); ?>

<?php $gen->navLogin(); ?>

<?php $gen->footer(); ?>

</body>
</html>