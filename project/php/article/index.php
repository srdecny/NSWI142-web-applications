<?php
	$params = explode("/", $_SERVER['REQUEST_URI']);
	$article_id = end($params);
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
	<link rel="stylesheet" href="../../style/style.css" type="text/css">
</head>
<body>
	<div id="articleContainer">
		<div id="articleContent">
			<div id="articleTitle"><?php echo $article["name"]; ?></div>
			<div id="similarList"></div>
			<div id="articleContent"><?php echo $article["content"]; ?></div>
		</div>
		<hr>
		<div id="controls">
			<button id="editButton" onclick="location.href='../article-edit/<?php echo $article_id; ?>'">Edit</button>
			<button id="homeButton" onclick="location.href='../articles'">Back to articles</button>
		</div>
	</div>
	<script>
		const similar = fetch("../article/<?php echo $article_id; ?>/similar")
			.then(r => r.json())
			.then(json => {
				const similarList = document.getElementById("similarList");
				json.forEach(article => {
					const li = document.createElement("li");
					li.innerHTML = `<a href="../article/${article[0]}">${article[1]}</a>`;
					similarList.appendChild(li);
				});
			});
	</script>
</body>