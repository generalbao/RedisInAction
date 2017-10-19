<?php 
namespace GeneralBao;


/**
* 
*/
class Article
{

	private $articleVotedTime = 7 * 24 * 60 * 60; //文章投票有效时间
	private $voteScore = 100; //文章初始化分数
	private $redis;
	
	function __construct()
	{
		$redis = new \Redis() or die('php no redis extension');
		$redis->connect('192.168.28.135') or die('redis server went');
		$redis->auth('123456') or die('password not right');
		$this->redis = $redis;
	}

	function add($user,$articleTitle,$articleContent)
	{
        
        
         $redis = $this->redis;
         $articleID = $redis->incr('article:') or die('xxx');
         $voted = 'voted:'.$articleID;
         //可以查看文章有哪些人点赞

         $redis->sadd($voted,$user);
         $redis->expire($voted,$this->articleVotedTime);


         $now = time();
         $article = 'article:'.$articleID;
         $articleData = 
         [
             'title'=>$articleTitle,
             'content'=>$articleContent,
             'poster'=>$user,
             'time'=>$now,
             'votes'=>0
         ];
         $redis->hmset($article,$articleData);


         $redis->zadd('score:',$now+$this->voteScore,$article);
         //这样如果用户就可以通过分数排序文章 比如知乎的安装点赞数排行
         $redis->zadd('time:',$now,$article);  
         //这样如果用户就可以通过时间排序文章 


         return $articleID;



	}



	function vote($user,$articleID)
	{
		$redis = $this->redis;
		
		$canVotedTime = time()- $this->articleVotedTime;
		if ($redis->zscore('time:','article:'.$articleID) < $canVotedTime) 
		{
			return '不能再投票了';      //说明文章已经不能再投票了
		}
       
        //如果返回的是true 说明用户还没有对该文章投票过
		if($redis->sAdd('voted:'.$articleID,$user))
		{
			$redis->zincrby('score:',$articleID,$this->voteScore);
			//文章分数加
			$redis->hincrby('article:'.$articleID,'votes',1); 
			 //文章票数加一
			return 'VOTE SUCCESS';    
			
		}
		return 'VOTED!';


	}
}


 ?>