<?php 
//2017年10月18日

require_once('../RedisConf.php');


$redis->hset('h','key','val');
$redis->hset('h','key2','val2');
$redis->hset('h','key3','val3');

$arr = 
[
  'k1'=>'v1',
  'k2'=>'v2'
];
$redis->hmset('h2',$arr);


echo "<br>"; var_dump($redis->hget('h','key'));
echo "<br>"; var_dump($redis->hmget('h',['key','key3']));


echo "<br>"; var_dump($redis->hgetall('h'));
echo "<br>"; var_dump($redis->hgetall('h2'));
echo "<br>"; var_dump($redis->hkeys('h2'));
echo "<br>"; var_dump($redis->hvals('h2'));

echo "<br>";  echo $redis->hlen('h2'); //2


echo "<br>";  echo $redis->hdel('h2','k1'); // 删除
echo "<br>";  var_dump($redis->hexists('h2','k2')); // 判断是否存在key

$arr2 = 
[
  'k1'=>'22',
  'k2'=>'v2'
];
$redis->hmset('h22',$arr2);

var_dump($redis->hincrby('h22','k1',55)); //77



?>