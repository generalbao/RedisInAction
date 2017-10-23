<?php 
/*

2017年10月23日
redis 事物
 */
require_once('../RedisConf.php');


// var_dump($_POST);
$userid = $_POST['userid'];
$itemName = $_POST['itemName'];
$itemid = $_POST['itemid'];
$price = $_POST['price'];

//用户包裹

$redis->sadd('inventory:'.$userid,$itemName);

// 把包裹放在市场上销售
list_item($redis,$itemid,$userid,$price);


// purchase_item($redis,1,$itemid,2,$price); 不用传入价格 可以通过itemid读取价格
purchase_item($redis,1,$itemid,2);  //有人购买包裹
//放在市场售卖  事务操作 添加在市场 和移除包裹 是原子性
function list_item($redis,$itemid,$sellerid,$price)
{
    $inventory = 'inventory:'.$sellerid;
    $item = $itemid.'.'.$sellerid;

    $end = time() + 5;
    $pipe = $redis->pipeline();

    //为什么要重复呢 因为如果用户包裹修改了 可以在十秒内再次重复操作
    while (time() < $end) 
    {
    	try 
    	{
    		$pipe->watch($inventory);
    		if (! $pipe->sismember($inventory,$itemid)) 
    		{
    			$pipe->unwatch();
    			return false;
    		}

    		$pipe->multi();
    		$pipe->zadd('markert:',$price,$item);
    		$pipe->srem($inventory,$itemid);
    		$pipe->exec();
    		return true;
    		
    	} catch (Exception $e) 
    	{
    		return false;
    	}
    }
}



function purchase_item($redis,$buyerid,$itemid,$sellerid)
{
	$buyer = 'user:'.$buyerid;
	$seller = 'user:'.$sellerid;
	$item = $itemid.'.'.$sellerid;
	$inventory = 'inventory:'.$buyerid;
	$end = time() + 10;
	$pipe = $redis->pipeline();
	while (time() < $end)
	{
		try
		{
			$pipe->watch('markert:',$buyer);
			$price = $pipe->zscore('markert:',$item); //商品的价钱
                   // var_dump($price);
                   			//用户的余额
			$funds = ($pipe->hget($buyerid,'funds'));

			if ( $price > $funds) 
			{
				$pipe->unwatch();
				echo 'money not enough';
				return false;
			}
            
            //最重要的事物
			$pipe->multi();
			$pipe->hincrby($seller,'funds',$price); //买卖双方金钱变化
			$pipe->hincrby($buyer,'funds',-$price);
			$pipe->sadd($inventory,$itemid);  //购买者包裹增加了item
			$pipe->srem('markert:',$item);   //市场减少该item
			$pipe->exec();
			// echo 'xxx';
			return true;
			
		} catch (Exception $e) 
		{
			return false;
			
		}
	}

}


?>