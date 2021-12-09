<?php
	$params = explode("/", $_SERVER['REQUEST_URI']);
	$article_id = end($params);
	require_once("../db.php");
	$db = new DB();
	$article = $db->delete_article($article_id);
	http_response_code(200);
?>