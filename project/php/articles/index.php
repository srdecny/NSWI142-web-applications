<?php 
	require_once '../db.php';
	$db = new DB();
	$rows = $db->get_article_list();
	$articles = array();
	while ($row = $rows->fetch_assoc()) {
		$row['safe'] = htmlspecialchars($row['name']);
		array_push($articles, $row);
	}

?>
<html>
<head>
	<title>Article list</title>
	<link rel="stylesheet" href="/style/style.css" type="text/css">
</head>
<body>
	<div id="articleContainer">
		<div id="articleTitle">Article list</div>
		<hr>
		<div id="articleList">
			<?php
				foreach ($articles as $article) {
					$line = <<<EOD
						<div class="articleLine">
							<div class="articleTitle">{$article['safe']}</div>
							<div class="articleControls">
								<a class="showLink" href="/cms/article/{$article['id']}">Show</a>
								<a class="editLink" href="/cms/article-edit/{$article['id']}">Edit</a>
								<a class="deleteLink" href="/cms/articles/{$article['id']}">Delete</a>
							</div>
						</div>
					EOD;
					echo $line;
				}
			?>
		</div>
		<hr>
		<div id="controls">
			<button class="button" onClick="previous()" id="previousButton">Previous</button>
			<button class="button" onClick="next()" id="nextButton">Next</button>
			<span id="pages"></span>
			<button class="button" id="createButton">Create Article</button>
		</div>
	</div>
</body>

<script>
	const articleList = document.getElementById('articleList');
	const previousButton = document.getElementById('previousButton');
	const nextButton = document.getElementById('nextButton');
	const pagesSpan = document.getElementById('pages');

	const ARTICLES_PER_PAGE = 10;
	const articleCount = articleList.children.length;
	let maxIndex = Math.ceil(articleCount / ARTICLES_PER_PAGE) - 1;
	let index = 0;

	const update = (newIndex) => {
		if (newIndex < 0  || newIndex > maxIndex) return;
		[...articleList.children].forEach(child => child.style.display = 'none');
		for (let i = 0; i < ARTICLES_PER_PAGE; i++) {
			const article = articleList.children[newIndex * ARTICLES_PER_PAGE + i];
			if (article) {
				article.style.display = 'flex';
			}
		};

		pages.innerHTML = `Page ${newIndex + 1 } of ${maxIndex + 1}`;
		previousButton.style.display = newIndex === 0 ? 'hidden' : 'visible';
		nextButton.style.display = newIndex === maxIndex ? 'hidden' : 'visible';
	}

	const previous = () => update(--index);
	const next = () => update(++index);

	update(0)

</script>