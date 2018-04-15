<?php
/**
 * Created by PhpStorm.
 * User: brianfotheringham
 * Date: 4/15/18
 * Time: 12:03 PM
 */

	session_start();
	$db = "../resources/php/database.php";
	$page = "../resources/php/page.php";
	$searchResults = "../resources/php/searchResults.php";
	include($db);
	include($page);
	include($home);
	include($searchResults);
	$server = new database();
	$gen = new page();
	$searchResults = new searchResults();
	$gen->head();
	$connection = $server->connect();
?>

<?php $gen->title(); ?>

<?php $gen->nav(); ?>

<?php
    if(isset($_GET['submit'])=='fail') { $loginHeader = "No Search Results."; }
	else { $loginHeader = "Results"; }
?>

<?php $searchResults->generateResults($connection); ?>

<?php $gen->footer(); ?>
</body>
</html>
