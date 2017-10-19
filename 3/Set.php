<?php 
//2017年10月19日

require_once('../RedisConf.php');

$redis->sAdd('key1' , 'member1'); 
/* 1, 'key1' => {'member1'} */
$redis->sAdd('key1' , 'member2', 'member3'); 
/* 2, 'key1' => {'member1', 'member2', 'member3'}*/
$redis->sAdd('key1' , 'member2'); 
/* 0, 'key1' => {'member1', 'member2', 'member3'} 因为member2 已经存在了*/ 

$redis->sAdd('key1' ,'111','2222');

echo $redis->sCard('key1'); /* 3  返回set的元素个数*/
echo $redis->sSize('keyX'); /* 0 */


var_dump($redis->srem('key1','member2','member3')); //返回2 移除的元素个数

var_dump($redis->smembers('key1')); //查看集合所有元素 array(1) { [0]=> string(7) "member1" }

var_dump($redis->sismember('key1','xxxx'));//false 判断xxxx是否是key1中的元素

//var_dump($redis->spop('key1')); //随机从集合删除一个元素


echo "<br/>";
var_dump($redis->srandmember('key1',3)); //随机从集合取出3个元素

echo "<br/>";
var_dump($redis->smove('key1','key2','111')); //吧key1中的元素111 移动到key2



$redis->sAdd('s0', '1');
$redis->sAdd('s0', '2');
$redis->sAdd('s0', '3');
$redis->sAdd('s0', '4');

$redis->sAdd('s1', '1');
$redis->sAdd('s2', '3');

var_dump($redis->sDiff('s0', 's1', 's2'));
/*
   返回所有s0有的 但是 s1而且s2没有的 就是集合的差集
 array(2) {
  [0]=>
  string(1) "4"
  [1]=>
  string(1) "2"
}

*/

var_dump($redis->sDiffStore('dst', 's0', 's1', 's2'));
var_dump($redis->sMembers('dst')); //这个只是把上面的结果存储在dst集合


$redis->sAdd('key1', 'val1');
$redis->sAdd('key1', 'val2');
$redis->sAdd('key1', 'val3');
$redis->sAdd('key1', 'val4');

$redis->sAdd('key2', 'val3');
$redis->sAdd('key2', 'val4');

$redis->sAdd('key3', 'val3');
$redis->sAdd('key3', 'val4');

var_dump($redis->sInter('key1', 'key2', 'key3'));

/*
array(2) {
  [0]=>
  string(4) "val4"
  [1]=>
  string(4) "val3"
}
返回的是几个集合的并集
 */



$redis->sAdd('s0', '1');
$redis->sAdd('s0', '2');
$redis->sAdd('s1', '3');
$redis->sAdd('s1', '1');
$redis->sAdd('s2', '3');
$redis->sAdd('s2', '4');

var_dump($redis->sUnion('s0', 's1', 's2'));

/*
返回的是集合中的合集 不过元素不会重复
array(4) {
  [0]=>
  string(1) "3"
  [1]=>
  string(1) "4"
  [2]=>
  string(1) "1"
  [3]=>
  string(1) "2"
}
 */
?>