<?php 
//2017年10月19日
/*

发布
 */
require_once('../RedisConf.php');

 
var_dump($redis->publish('chan-1', 'hello, world!')); 
// 向chan-1频道发送消息hello, world! 如果频道不存在返回0 否则返回1


var_dump($redis->pubsub('channels')); //返回所有频道

$redis->pubSub("channels", "*c*"); /* 返回匹配的频道 比如频道名字有c的符合要求 */

$redis->pubSub("numsub", Array("c1", "c2")); /*返回频道的订阅数量*/
$redis->pubSub("numpat"); /* Get the number of pattern subscribers */



?>