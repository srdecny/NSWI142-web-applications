<?php
	$name = $_POST['name'];
	$content = $_POST['content'];
	$article_id = end(explode("/", $_SERVER['REQUEST_URI']));

	require_once("../db.php");
	$db = new DB();
	$db->update_article($article_id, $name, $content);

	header("Location: /cms/articles", true, 302);
	exit();

?>