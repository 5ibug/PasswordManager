<?php
require_once 'MysqliDb.php';
require_once 'User.php';
require_once 'log.php';
require_once 'password.php';
date_default_timezone_set('PRC');//时区
define('SECRETKEY', '3163213543213543052abc43edfedac');//登录后的密码加密
define('USER_SALT', 'asd123');//用户密码md5加密
$mysql = new MysqliDb (Array (
    'host' => 'localhost',
    'username' => 'demo_5ibug_net', 
    'password' => 'THkAtwjkrrren5j2',
    'db'=> 'test',
    'port' => 3306,
    //'prefix' => 'my_',
    'charset' => 'utf8'));
?>