<?php
require_once 'Config.php';
session_start();
$user = new User();
if (!$user->Auth($mysql)){ //验证否登陆过
    header("Location: login.php");
}
$password = new password($user->username);
//New_Password($mysql,$user,$password,$url,$tags,$newtime,$key)
echo $password->New_Password($mysql,'taaa1','passwa1rd1234','','',SECRETKEY);

//echo $password->A_decrypt('SyqSQ0DK/raBeoXPbuwg3TV6VlKiAEq+ZLEMS2ATXR4=', SECRETKEY)."<br>";
?>