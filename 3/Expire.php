<?php 
/*

2017年10月19日
过期时间
 */
require_once('../RedisConf.php');
// $redis->set('x', '42');
// $redis->setTimeout('x', 3);	// x will disappear in 3 seconds. 3秒后会过期
// sleep(5);				// wait 5 seconds
// $redis->get('x'); 		// will return `FALSE`, as 'x' has expired. 过期了


// $redis->set('x', '42');
// $now = time(NULL); // current timestamp
// $redis->expireAt('x', $now + 3);	// x will disappear in 3 seconds. 设置什么时候过期
// sleep(5);				// wait 5 seconds
// $redis->get('x'); 		


$redis->set('haha',100,'val'); //设置 haha的有效期100秒 而且值为val

echo $redis->ttl('haha'); //读取haha的有效期还有多少秒
echo $redis->pttl('haha'); //读取haha的有效期还有多少毫秒

$redis->persist('haha'); //设置haha的有效期为永久 
echo $redis->ttl('haha'); //读取haha的有效期还有多少秒 因为是永久所以是 -1
?>