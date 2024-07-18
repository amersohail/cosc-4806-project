<?php 
ob_start();
require_once 'app/init.php';
$app = new App;
ob_end_flush();
?>