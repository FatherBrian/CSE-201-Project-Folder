<?php
/**
 * Created by PhpStorm.
 * User: brianfotheringham
 * Date: 4/15/18
 * Time: 12:02 PM
 */

	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$home = "../resources/php/home.php";
	$other = "../resources/php/otherProfile.php";
	include($db);
	include($page);
	include($home);
	include($other);
	$server = new database();
	$gen = new page();
	$home = new home();
	$other = new otherProfile();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>

<?php $other->generateProfile($connection); ?>

<?php
if(isset($POST['friendButton'])){
    $other->addFriend($connection);
}
?>

<?php $gen->footer(); ?>
</body>
</html>

