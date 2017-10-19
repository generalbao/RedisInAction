<?php 
//2017年10月19日

require_once('../RedisConf.php');
$redis->zAdd('key', 1, 'val1');
$redis->zAdd('key', 0, 'val0');
$redis->zAdd('key', 5, 'val5');  
// 向名称为key的zset中添加元素val5，5是score(分数)score用于排序
$redis->zRange('key', 0, -1); // array(val0, val1, val5) 返回的是key有序集合中的所有元素

echo $redis->zcard('key');
echo $redis->zsize('key');//返回名称为key的zset的所有元素的个数


$redis->zDelete('key', 'val0');
//删除名称为key的zset中的元素val0 zrem同理
//
var_dump($redis->zCount('key', 1, 4)); //1
//返回名称为key的zset中score >= star且score <= end的所有元素的个数
//

echo $redis->zRank('key', 'val5');//1
echo $redis->zRevRank('key', 'val5'); //0第一位
//zRank返回名称为key的zset（元素已按score从小到大排序）中val5元素的rank（即index，从0开始），若没有val元素，返回“null”。zRevRank 是从大到小排序
//
//
echo $redis->zScore('key', 'val5');
//返回名称为key的zset中元素val5的score 5
//
//

/*
下面的是返回名称为key的zset中score >= star且score <= end的所有元素 
最后一个参数可空或者数组
withscores => TRUE, 
limit => array($offset, $count) 和数据库中的limit参数一样

 */ 
$redis->zAdd('key', 0, 'val0');
$redis->zAdd('key', 2, 'val2');
$redis->zAdd('key', 10, 'val10');
$redis->zRangeByScore('key', 0, 3); /* array('val0', 'val2') */
$redis->zRangeByScore('key', 0, 3, array('withscores' => TRUE)); 
	/* array('val0' => 0, 'val2' => 2) */
$redis->zRangeByScore('key', 0, 3, array('limit' => array(1, 1))); /* array('val2') */
$redis->zRangeByScore('key', 0, 3, array('withscores' => TRUE, 'limit' => array(1, 1))); /* array('val2' => 2) */


$redis->zRemRangeByScore('key', 0, 3);
// 删除名称为key的zset中score >= 0且score <= 3的所有元素，返回删除个数
// 
// 
// 
$redis->zAdd('k1', 0, 'val0');
$redis->zAdd('k1', 1, 'val1');
$redis->zAdd('k1', 1, 'val2');

$redis->zAdd('k2', 2, 'val2');
$redis->zAdd('k2', 3, 'val3');

var_dump($redis->zUnion('ko1', array('k1', 'k2'))); 
/* 4, 
'ko1' => array('val0', 'val1', 'val2', 'val3') 
ko1是k1 k2的并集
*/
var_dump($redis->zInter('ko1', array('k1', 'k2'))); //1交集个数只有一个
?>