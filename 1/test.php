<?php 
namespace GeneralBao;
use GeneralBao\Article;	
require_once('Article.Class.php');	
ini_set('default_socket_timeout', -1);
$article = new Article();
$user = 'user'.time();
$articleTitle = 'title'.time();
$articleContent =  'content'.time();
// $res = $article->add($user,$articleTitle,$articleContent);


$res = $article->vote('user888','1');
var_dump($res);


 ?>