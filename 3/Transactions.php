<?php 
/*

2017年10月19日
排序
 */
require_once('../RedisConf.php');

/*

监测一个key的值是否被其它的程序更改。如果这个key在watch 和 exec （方法）间被修改，这个 MULTI/EXEC 事务的执行将失败（return false）
unwatch  取消被这个程序监测的所有key

multi 执行一系列命令 有原子性保证
pipeline 没有原子性保证
 */
$redis->watch('x');
$res = $redis->multi()
    ->set('key1', 'val1')
    ->get('key1')
    ->set('key2', 'val2')
    ->get('key2')
    ->exec();
var_dump($res); 
/*
array(4) { [0]=> bool(true) [1]=> string(4) "val1" [2]=> bool(true) [3]=> string(4) "val2" }

 */
if (!$res)
{
	$redis->unwatch('x');
}

?>