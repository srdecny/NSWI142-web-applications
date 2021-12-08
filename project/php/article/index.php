<?php
	$article_id = end(explode("/", $_SERVER['REQUEST_URI']));
	require_once("../db.php");
	$db = new DB();
	$article = $db->get_article($article_id);
	if (!$article) {
		http_response_code(404);
		die();
	}
?>
<html>
<head>
	<title>Article list</title>
	<link rel="stylesheet" href="/style/style.css" type="text/css">
</head>
<body>
	<div id="articleContainer">
		<div id="articleContent">
			<div id="articleTitle"><?php echo $article["name"]; ?></div>
			<div id="articleContent"><?php echo $article["content"]; ?></div>
		</div>
		<hr>
		<div id="controls">
			<button id="editButton" onclick="location.href='/cms/article-edit/<?php echo $article_id; ?>'">Edit</button>
			<button id="homeButton" onclick="location.href='/cms/articles'">Back to articles</button>
		</div>
	</div>

</body>