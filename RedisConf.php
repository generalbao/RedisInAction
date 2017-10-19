<?php
$redis = new \Redis() or die('php no redis extension');
		$redis->connect('192.168.28.135') or die('redis server went');
		$redis->auth('123456') or die('password not right');
?>