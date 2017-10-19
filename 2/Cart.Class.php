<?php 
namespace GeneralBao;


/**
* 
*/
class Cart
{

	
	private $redis;
	
	function __construct()
	{
		$redis = new \Redis() or die('php no redis extension');
		$redis->connect('192.168.28.135') or die('redis server went');
		$redis->auth('123456') or die('password not right');
		$this->redis = $redis;
	}

    

    //添加购物车 
	function add($token,$item,$count)
	{
        
        if ($count <= 0)
        {
        $this->redis->hrem('cart:'.$token,$item);
        }
        else
        {
        	$this->redis->hset('cart:'.$token,$item,$count);
        }


	}

	

    //这个function 可以单独抽出来 以php-cli运行
	function delete($quit=false,$limit=100)
	{
		$redis = $this->redis;
		while(!$quit)
		{
          $size = $redis->zSize('recent:'); //得到当前用户登录数
          if ($size < $limit)
          {
          sleep(1);
          continue;
          }

          $remove_index = min($size-$limit,100); //要删除的token 索引
          $remove_tokens = $redis->zrange('recent:',0,$remove_index-1);
          
          $length = count($remove_tokens);
         
          for ($i=0; $i < $length; $i++) 
          { 
          	// 用户查看了那些产品 购物车了哪些产品 可以做分析 zunion
          	  $redis->delete('viewed:',$remove_tokens[$i]);
          	  $redis->delete('cart:',$remove_tokens[$i]);  //删除购物车

          	 $redis->hdel('login:',$remove_tokens[$i]); //hdel hashName key1 key2
             $redis->zrem('recent:',$remove_tokens[$i]);
          }
          
		}

	}
}


 ?>