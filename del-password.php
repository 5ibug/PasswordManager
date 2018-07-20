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
if($_GET['id']==null){
?>
<script>
alert('未找到id');
window.location.href='add-password.php';
</script>
<?php
exit();
}

//$password->New_Password($mysql,$_POST['user_name'],$_POST['password'],$_POST['url'],$_POST['tags'],SECRETKEY);
if($password->checkpwd($mysql,$_GET['id'])[0]['name'] == $user->username){
    if($password->Del_A_password($mysql,$_GET['id'])){
        $log->WriteLog($mysql,$user->username,'del a password');
    }
?>
<script>
alert('删除完成');
window.location.href='read-password.php';
</script>
<?php
}else{
    ?>
    <script>
    alert('删除失败,该数据所属权不是您.');
    window.location.href='read-password.php';
    </script>
    <?php
}