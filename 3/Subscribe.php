<?php 
//2017年10月19日
/*

订阅

以php-cli模式运行

 */
require_once('../RedisConf.php');

 
function f($redis, $chan, $msg) {
	switch($chan) {
		case 'chan-1':
			echo '1111---'.$msg;
			break;

		case 'chan-2':
			echo '2222---'.$msg;
			break;

		case 'chan-2':
			echo '3333---'.$msg;
			break;
	}
}

// $redis->subscribe(订阅频道的数组, 回调函数);
$redis->subscribe(array('chan-1', 'chan-2', 'chan-3'), 'f'); // subscribe to 3 chans


?>