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
    if(isset($_POST['submitEntry'])){
        $formData = $_POST['searchEntry'];
    }

?>
<?php $searchResults->generateResults($connection,$formData); ?>

<?php $gen->footer(); ?>
</body>
</html>
