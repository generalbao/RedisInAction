<?php 
//2017年10月18日

require_once('../RedisConf.php');

		echo $redis->set('key','value'); //1 说明操作成功
		echo $redis->get('key');   // value
		echo $redis->incr('key2');  // 1 如果key不存在就是0


		$redis->set('key3','88');
		echo $redis->incr('key3'); //89
		echo $redis->get('key3');
		echo $redis->decr('key3',9); //80

        echo $redis->append('newKey','php7'); //newKey后面追加php7 返回的是newKey的长度
        echo $redis->append('newKey','is powerful');
        echo $redis->get('newKey');

        echo $redis->substr('newKey',0,6); // 字符串截取 返回的是phpis
        echo "<br>";
        echo $redis->getrange('newKey',0,6); //the same use as the above

        echo "<br>";
        $redis->set('newKey22','a');  //a的二进制为 01100001
        echo $redis->setbit('newKey22',6,1); // 把第七位设置为 1 所以newKey22 01100011
        echo $redis->setbit('newKey22',7,0); // 把第八位设置为 0 所以newKey22 01100010
        echo $redis->get('newKey22'); //b的二进制为 01100010

          echo "<br>";
          $redis->set('test','ttttttt');
          echo $redis->setrange('test',3,'new'); //从第四位开始插入new 返回总长度 7
          echo $redis->get('test');


 ?>