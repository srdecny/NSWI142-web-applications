<?php
	$name = $_POST['name'];
	$content = $_POST['content'];
	$params = explode("/", $_SERVER['REQUEST_URI']);
	$article_id = end($params);
	require_once("../db.php");

	$db = new DB();
	if ($article_id == "new") {
		$new_id = $db->create_article($name, $content);
		header("Location: ../article/{$new_id}", true, 302);
	} else {
		$db->update_article($article_id, $name, $content);
		header("Location: ../articles", true, 302);
	}



?>