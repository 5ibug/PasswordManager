<?php
require_once 'MysqliDb.php';
class password{
    var $username;
    public function __construct($username){
        $this->username = $username;
    }

    public function New_Password($mysql,$user,$password,$url,$tags,$key){
        return $mysql->insert('user_password',Array (
            'id' => '',
            'name' => $this->Userentities($this->username),//归属
            'user' => $this->Userentities($user),
            'password' => $this->A_Encrypt($password,$key),
            'url' => $this->Userentities($url),
            'tags' => $this->Userentities($tags),
            'newtime' => time(),
            'revisetime' => time()//创建 修改时间和创建时间相同
        ));
    }
    public function Read_Password($mysql){
        return $mysql->rawQuery('SELECT * from user_password where name = ? ', Array ($this->username));
    }
    public function Userentities($str){
        return htmlentities($str, ENT_QUOTES);
    }
    public function Read_ALL_password($mysql){
        return $mysql->rawQuery('SELECT * from user_password');
    }
    public function Del_A_password($mysql,$id){
        $mysql->where('id', $id);
        return $mysql->delete('user_password');
    }
    public function checkpwd($mysql,$id){
        return $mysql->rawQuery('SELECT * from user_password where id = ? ', Array ($id));
    }

    public function update_password($mysql,$id,$user,$password,$url,$tags,$key){
        $mysql->where('id',$id);
        return $mysql->update ('user_password', Array(
            'name' => $this->Userentities($this->username),//归属
            'user' => $this->Userentities($user),
            'password' => $this->A_Encrypt($password,$key),
            'url' => $this->Userentities($url),
            'tags' => $this->Userentities($tags),
            'revisetime' => time()//创建 修改时间和创建时间相同
        ));
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
}
?>