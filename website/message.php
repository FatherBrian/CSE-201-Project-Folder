<?php
	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$message = "../resources/php/message.php";
	$poster = "../resources/php/post.php";
	include($db);
	include($page);
	include($message);
	include($poster);
	$server = new database();
	$gen = new page();
	$message = new message();
	$poster = new post();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav($connection, $server); ?>

<?php $message->generateMessages($connection, $server); ?>

<?php $gen->footer(); ?>

</body>
</html>