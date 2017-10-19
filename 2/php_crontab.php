<?php 
/*

php 定时任务 删除多余的用户登录的cookie
当然也可以用 crontab
2017年10月16日10:26:40
 */

		$redis = new \Redis() or die('php no redis extension');
		$redis->connect('192.168.28.135') or die('redis server went');
		$redis->auth('123456') or die('password not right');
	
        $quit = false;
        $limit = 2;

	
		while(!$quit)
		{
          $size = $redis->zSize('recent:'); //得到当前用户登录数
          if ($size <= $limit)
          {
          sleep(1);
          continue;
          }

          $remove_index = min($size-$limit,100); //要删除的token 索引
          $remove_tokens = $redis->zrange('recent:',0,$remove_index-1);


            //最后形势是 xxx,xxx,xxx
         $length = count($remove_tokens);
         
          for ($i=0; $i < $length; $i++) 
          { 
          	
          	 $redis->hdel('login:',$remove_tokens[$i]); //hdel hashName key1 key2
             $redis->zrem('recent:',$remove_tokens[$i]);
          }




		}

	


 ?>