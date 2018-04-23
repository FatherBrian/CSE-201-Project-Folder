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

<?php
	if (isset($_GET['action'])) { $action = $_GET['action']; } 
	else { $action = "none"; }

	if($action=='addFriend') { $profile->acceptFriend($connection, $_GET['id']); } 
	elseif($action=='deleteFriend') { $profile->deleteFriend($connection); }
	elseif($action=='removeFriendRequest') { $profile->removeRequestFriend($connection); }
	elseif($action=='sendFriendRequest') { $profile->sendRequestFriend($connection); }
	
	if(isset($_GET['login'])=='fail') { $loginHeader = "Login unsuccessful, please try again."; } 
	else { $loginHeader = "Login"; }

	if(isset($_GET['create'])=='fail') { $createHeader = "Account already exists"; } 
	else { $createHeader = "Create Account"; }	
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>

<?php $profile->getFriends($connection); ?>

<!--- <?php $profile->getFriendRequests($connection); ?> --->

<?php $profile->generateProfile($connection); ?>

<?php $profile->getPostSystem(); ?>

<?php 
	if(isset($_POST['submit'])) {
		$entry = $_POST['posts'];
		$id = $_GET["id"];
		$postId = $_SESSION["userID"];
		$profile->addPost($connection, $entry, $id, $postId);
	}
?>

<?php
    if(isset($_POST['addFriend'])) {
        $profile->requestFriend($connection);
    }
?>

<?php $profile->generatePreviousPosts($connection); ?>

<?php $gen->footer(); ?>

</body>
</html>

