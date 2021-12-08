<?php
	$name = $_POST['name'];
	$content = $_POST['content'];
	$article_id = end(explode("/", $_SERVER['REQUEST_URI']));
	require_once("../db.php");

	$db = new DB();
	if ($article_id == "new") {
		$new_id = $db->create_article($name, $content);
		header("Location: /cms/article/{$new_id}", true, 302);
	} else {
		$db->update_article($article_id, $name, $content);
		header("Location: /cms/articles", true, 302);
	}



?>