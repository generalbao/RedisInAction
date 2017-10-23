# RedisInAction
aaaaa
 redis存储 主要有rdb aof(aof重写)

bbbbb 主从redis

ccccc
$redis->multi();  //原子性操作 事物
.....
$redis->exec();  //
            $pipe->multi();
			$pipe->hincrby($seller,'funds',$price); //买卖双方金钱变化
			$pipe->hincrby($buyer,'funds',-$price);
			$pipe->sadd($inventory,$itemid);  //购买者包裹增加了item
			$pipe->srem('markert:',$item);   //市场减少该item
			$pipe->exec();

dddd
$pipe = $redis->pipeline(); 
//redis管道提升效率 因为是一序列操作减少了客户端和服务器之间通信 
$pipe->set('name','bb')->set('xx','xxx);

案例
1用户添加包裹
2移除用户包裹 进入市场销售
3购买包裹