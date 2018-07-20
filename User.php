<?php
require_once 'MysqliDb.php';
class User
{//用户表//id,user(唯一),password
 //日志表//id(日志id),user(用户名,主键),message(操作消息,如login等),ip(操作ip),time(操作时间)
 //密码表//id,,name(归属人),user,password,url,tags,newtime(创建时间),revisetime(修改时间)
    var $user_id;
    var $username;
    var $password;
    var $domain;
    public function __construct(){
        $this->domain = $_SERVER['HTTP_HOST'];  
    }
    //登录
    public function UserLogin($mysql,$user,$password,$salt){
        $users = $mysql->rawQuery('SELECT * from admin_user where user = ? AND password = ?', Array ($user,$this->User_Encrypt($password,$salt)));
        $this->user_id = count($users)?$users[0]['id']:'0';
        $this->username = count($users)?$users[0]['user']:'Guest';
        $this->password = count($users)?$users[0]['password']:'';
        $_SESSION['auth_username'] = count($users)?$users[0]['user']:'';
        $_SESSION['auth_password'] = count($users)?$users[0]['password']:'';
        setcookie("auth_username", count($users)?$users[0]['user']:'', time()+60*60*24*30, "/", $this->domain);
        setcookie("auth_password", count($users)?$users[0]['password']:'', time()+60*60*24*30, "/", $this->domain);
        return count($users)? true : false;
    }
    //退出
    public function UserLogout(){
        $this->user_id = 0;
        $this->username = "Guest";
        $_SESSION['auth_username'] = "";
        $_SESSION['auth_password'] = "";
        setcookie("auth_username", "", time() - 3600, "/", $this->domain);
        setcookie("auth_password", "", time() - 3600, "/", $this->domain);
    }
    public function ALL_User($mysql){
        return $mysql->rawQuery('SELECT * from admin_user');
    }
    //查询 用户名重复
    private function repeat($mysql,$user){
        $users = $mysql->rawQuery('SELECT * from admin_user where user = ? ', Array ($user));
        return count($users)? true : false;
    }
    //注册
    public function UserRegister($mysql,$user,$password,$salt){
        return $this->repeat($mysql,$user)?'-1':$mysql->insert('admin_user',Array (
            'id' => '',
            'user' => $this->Userentities($user),
            'password' => $this->User_Encrypt($password,$salt)
        ));
    }
    //过滤特殊符号
    public function Userentities($str){
        return htmlentities($str, ENT_QUOTES);
    }
    //用户登录密码加密
    public function User_Encrypt($password,$salt){
        return md5(md5(md5($password).md5($salt)).$salt);
    }
    //保存密码加密
    public function A_Encrypt($input, $key){
        return $this->Temp_Encrypt($input, $this->User_Encrypt($key,$this->Temp_Encrypt($key,md5($this->username))));
    }
    private function Temp_Encrypt($input, $key){
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->hextobin($key), $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    //保存密码解密
    public function A_decrypt($sStr, $sKey){
        return $this->Temp_decrypt($sStr, $this->User_Encrypt($sKey,$this->Temp_Encrypt($sKey,md5($this->username))));
    }
    private function Temp_decrypt($sStr, $sKey){
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->hextobin($sKey), base64_decode($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
    private function hextobin($hexstr) {
        $n = strlen($hexstr);
        $sbin = "";
        $i = 0;
        while ($i < $n) {
            $a = substr($hexstr, $i, 2);
            $c = pack("H*", $a);
            if ($i == 0) {
                $sbin = $c;
            } else {
                $sbin.=$c;
            }
            $i+=2;
        }
        return $sbin;
    }
    //验证cookie
    private function check_cookie($mysql){
        if(!empty($_COOKIE['auth_username']) && !empty($_COOKIE['auth_password']))
            return $this->checklogin($mysql,$_COOKIE['auth_username'], $_COOKIE['auth_password']);
        else
            return false;
    }
    //验证登录账号密码
    private function checklogin($mysql,$username, $password){
        $users = $mysql->rawQuery('SELECT * from admin_user where user = ? AND password = ?', Array ($username,$password));
        $this->user_id = $users[0]['id'];
        $this->username = $users[0]['user'];
        $this->password = $users[0]['password'];
        return count($users)? true : false;
    }
    //验证 自动登录以及登录状态验证
    public function Auth($mysql){
        $this->user_id = 0;
        $this->username = "Guest";
        return ($this->check_session($mysql) && $this->check_cookie($mysql))?true:false;
    }
    //验证session
    private function check_session($mysql){
        if(!empty($_SESSION['auth_username']) && !empty($_SESSION['auth_password']))
            return $this->checklogin($mysql,$_SESSION['auth_username'], $_SESSION['auth_password']);
        else
            return false;
    }
    public function Read_ALL_User($mysql,$user){
        return $mysql->rawQuery('SELECT * from admin_user');
    }
}

?>