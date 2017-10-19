<?php 
/*

2017年10月19日
排序
 */
require_once('../RedisConf.php');

     $redis->lpush('mylist2',11);
     $redis->lpush('mylist2',2);
     $redis->lpush('mylist2',33);
     $redis->lpush('mylist2',4);
     $redis->lpush('mylist2',55);

var_dump($redis->lrange('mylist2',0,-1));
/*
array(5) { [0]=> string(2) "55" [1]=> string(1) "4" [2]=> string(2) "33" [3]=> string(1) "2" [4]=> string(2) "11" } 

 */
echo "<Br/>";
var_dump($redis->sort('mylist2')); 
/*
返回排序后的数据 默认按数字大小排序
array(5) { [0]=> string(1) "2" [1]=> string(1) "4" [2]=> string(2) "11" [3]=> string(2) "33" [4]=> string(2) "55" }
 */

echo "<Br/>";
var_dump($redis->sort('mylist2', array('sort' => 'desc'))); // 倒叙排序

var_dump($redis->sort('mylist2', array('alpha' => TRUE))); // 字母排序

echo "<Br/>";
var_dump($redis->sort('mylist2', array('sort' => 'desc', 'store' => 'out'))); // (int)5
 ?>