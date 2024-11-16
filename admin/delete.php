<?php
require_once 'connect.php';
$database->delete([$_GET['id']]);
header('location:list.php');
exit();
?>