<?php
require_once 'MysqliDb.php';
class log{
    var $ip;
    var $time;
    public function __construct(){
        $this->ip = $this->get_ip();  
        $this->time = time(); 
        //print_r($this);
    }
     //日志表//id(日志id),user(用户名,主键),message(操作消息,如login等),ip(操作ip),time(操作时间)
    public function WriteLog($mysql,$user,$message){
        return $mysql->insert('user_log',Array (
            'id' => '',
            'user' => $user,
            'message' => $message,
            'ip' => $this->ip,
            'time' => $this->time,
        ));
    }
    public function Read_A_User($mysql,$user){
        return $mysql->rawQuery('SELECT * from user_log where user = ? ', Array ($user));
    }
    public function Read_A_User_Login($mysql,$user){
        return $mysql->rawQuery('SELECT * from user_log where user = ? and message = ? ', Array ($user,"user login"));
    }
    public function Read_ALL_User($mysql,$user){
        return $mysql->rawQuery('SELECT * from user_log');
    }
    private function get_ip(){
        //判断服务器是否允许$_SERVER
        if(isset($_SERVER)){    
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        }else{
            //不允许就使用getenv获取  
            if(getenv("HTTP_X_FORWARDED_FOR")){
                  $realip = getenv( "HTTP_X_FORWARDED_FOR");
            }elseif(getenv("HTTP_CLIENT_IP")) {
                  $realip = getenv("HTTP_CLIENT_IP");
            }else{
                  $realip = getenv("REMOTE_ADDR");
            }
        }
    
        return $realip;
    }      
}
?>