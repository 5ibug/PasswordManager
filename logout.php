<?php
require_once 'Config.php';
session_start();
$user=new User();

$user->UserLogout();
header("Location: login.php");

?>