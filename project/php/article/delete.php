<?php
	$article_id = end(explode("/", $_SERVER['REQUEST_URI']));
	require_once("../db.php");
	$db = new DB();
	$article = $db->delete_article($article_id);
	http_response_code(200);
?>