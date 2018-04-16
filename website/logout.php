<?php
/**
 * Created by PhpStorm.
 * User: brianfotheringham
 * Date: 4/16/18
 * Time: 12:50 AM
 */
session_start();
session_destroy();
header('Location: index.php');
exit;