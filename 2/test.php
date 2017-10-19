<?php 
namespace GeneralBao;
use GeneralBao\Cookie;	
require_once('Cookie.Class.php');	
ini_set('default_socket_timeout', -1);
$Cookie = new Cookie();
$user = 'user'.time();
$token= 'token'.time();



$res = $Cookie->add_token($token,$user);
echo '添加成功否:';
var_dump($res);

echo "<br/>";

$res = $Cookie->check_token($token);
echo '检查token是否存在:';
var_dump($res);

echo "<br/>";


$item = '收藏'.time();
$res = $Cookie->update_token($token,$user.'new',$item);
echo '修改token,而且添加收藏:';
var_dump($res);

echo "<br/>";


// $res = $Cookie->delete_token(false,2);
// echo '删除多余的token:';
// var_dump($res);

echo "<br/>";





 ?>