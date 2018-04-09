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

<<<<<<< HEAD
<?php $gen->title(); ?>

<?php $gen->nav(); ?>
=======
$userid = $_REQUEST(‘userid’);

$get = mysql_query(“SELECT * FROM userid WHERE userid = ‘$userid’”);
$get2 = mysql_fetch_assoc($get);
$username = $get2 (‘username’)
>>>>>>> d0cd055f78ba8df3cac58c3534ced8b9322bd764



<<<<<<< HEAD
<?php $profile->generateProfile($connection); ?>
=======
ID: <b><?php echo $userID; ?></b> 
User Name: <b><?php echo $username; ?></b> 
Password: <b><?php echo $password; ?></b> 
E-mail: <b><?php echo $email; ?></b> 
>>>>>>> d0cd055f78ba8df3cac58c3534ced8b9322bd764

<?php $gen->footer(); ?>

</body>
</html>
?>
