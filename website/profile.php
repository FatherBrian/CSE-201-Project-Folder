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

<?php $profile->getFriends($connection); ?>

<?php $profile->getFriendRequests($connection); ?>

<?php $profile->generateProfile($connection); ?>

<?php $profile->getPostSystem(); ?>

<<<<<<< HEAD
<?php 
	if(isset($_POST['submit'])) {
		$entry = $_POST['posts'];
		$id = $_GET["id"];
		$profile->addPost($connection, $entry, $id);
	}
=======
<?php if(isset($_POST['submit'])) {
    $entry = $_POST['posts'];
    $profile->addPost($connection, $entry);
      } ?>

<?php
    if(isset($_POST['addFriend'])) {
        $profile->requestFriend($connection);
    }
>>>>>>> ad0afff0dd74171ac26357681479b28c9f0b14fe
?>

<?php $profile->generatePreviousPosts($connection); ?>

<?php $gen->footer(); ?>

</body>
</html>

