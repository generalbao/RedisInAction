<?php 
//2017年10月18日

require_once('../RedisConf.php');

		echo $redis->lpush('mylist','left'); //返回的是list里面有多少个元素
     echo "<br>"; 
    echo $redis->rpush('mylist','right');

    echo "<br>"; 
    var_dump($redis->lrange('mylist',0,-1)); //返回所有list元素

    echo "<br>"; 
    var_dump($redis->lpop('mylist')); //从左边弹出(删除)一个元素
    // var_dump($redis->lpop('mylist'));


   

    echo "<br>"; 
    var_dump($redis->lrange('mylist',0,-1)); //返回所有list元素

     $redis->lpush('mylist2','1');
     $redis->lpush('mylist2','2');
     $redis->lpush('mylist2','3');
     $redis->lpush('mylist2','4');
     $redis->lpush('mylist2','5');
     var_dump($redis->ltrim('mylist2',2,-1)); // 把 mylist2中的第一个第二个元素去除了
     echo "<br>";
     var_dump($redis->lrange('mylist2',0,-1));

      echo "<br>";     
     var_dump($redis->blpop('mylist2','11',5)); 
     // 从mylist2的左边弹出一个元素(如果有该元素) 如果没有该元素就阻塞五秒,等待元素进list,五秒内没有就放弃 同理 brpop
     //array(2) { [0]=> string(7) "mylist2" [1]=> string(1) "3" }
     //
     //
      echo "<br>";     
     var_dump($redis->rpoplpush('mylist','mylist2')); 
     // 从mylist的右边弹出一个元素到 mylist2的左边 brpoplpush同理

 ?>