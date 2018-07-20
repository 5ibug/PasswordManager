<?php
require_once 'Config.php';
session_start();
$user=new User();
$log=new log();
if (!$user->Auth($mysql)){ //验证否登陆过
    header("Location: login.php");
}else{
    $password=new password($user->username);
}
if($_POST['user_name']==null or $_POST['password']==null){
?>
<script>
alert('请填写必填信息');
window.location.href='add-password.php';
</script>
<?php
exit();
}
$password->New_Password($mysql,$_POST['user_name'],$_POST['password'],$_POST['url'],$_POST['tags'],SECRETKEY);
$log->WriteLog($mysql,$user->username,'new a password');
?>
<script>
alert('添加完成');
window.location.href='read-password.php';
</script>