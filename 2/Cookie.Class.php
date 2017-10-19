<?php 
namespace GeneralBao;


/**
* 
*/
class Cookie
{

	
	private $redis;
	
	function __construct()
	{
		$redis = new \Redis() or die('php no redis extension');
		$redis->connect('192.168.28.135') or die('redis server went');
		$redis->auth('123456') or die('password not right');
		$this->redis = $redis;
	}

    //查询用户是否登录 如果登录了 查找对应的用户
	function check_token($token)
	{
         return $this->redis->hget('login:',$token);
	}

    //用户登录了 需要用一个散列存储 token和用户之间的映射关系
	function add_token($token,$user)
	{
        
         $redis = $this->redis;
        
         $res = $redis->hset('login:',$token,$user);

         return $res;

	}

	function update_token($token,$user,$item = null)
	{
		$redis = $this->redis;
		$time = time();
		$redis->hset('login:',$token,$user);
		$redis->zadd('recent:',$time,$token);
		//记录token最后更新时间 zadd key score value !!!

		//如果用户添加了收藏
		if ($item) 
		{
			$redis->zadd('viewed:'.$token,$time,$item);
			$redis->zremrangebyrank('viewed:'.$token,0,-26); 
			return true;
			//最多添加25个收藏 移除其他多余的
		}

		return false;
       
	}

     //这个function 可以单独抽出来 以php-cli运行
	function delete_token($quit=false,$limit=100)
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
          	 $redis->delete('viewed:',$remove_tokens[$i]);
          	 $redis->hdel('login:',$remove_tokens[$i]); //hdel hashName key1 key2
             $redis->zrem('recent:',$remove_tokens[$i]);
          }
          
		}

	}
}


 ?>