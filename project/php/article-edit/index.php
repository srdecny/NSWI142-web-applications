<?php
	$params = explode("/", $_SERVER['REQUEST_URI']);
	$article_id = end($params);
	if ($article_id !== "new") {
		require_once("../db.php");
		$db = new DB();
		$article = $db->get_article($article_id);
		if (!$article) {
			http_response_code(404);
			die();
		}
	} else {
		$article = array(
			"name" => "",
			"content" => "",
		);
	}
	$submit_label = $article_id == "new" ? "Create" : "Save";
?>
<html>
<head>
	<title>Article list</title>
	<link rel="stylesheet" href="../../style/style.css" type="text/css">
</head>
<body>
	<div id="articleContainer">
		<form id="editForm" method="POST">
			<label for="name" >Name</label>
			<input type="text" required name="name" maxlength="32" value="<?php echo $article['name']; ?>">
			<label for="content">Content</label>
			<textarea name="content" rows="20" maxlength="1024"><?php echo $article['content']; ?></textarea>
			<div id="controls">
				<input type="submit" value="<?php echo $submit_label ?>">
				<button onclick="window.location.href='../articles'">Back to articles</button>
			</div>
		</form>
	</div>

</body>