<html>
<head>
	<title>Article list</title>
	<link rel="stylesheet" href="/style/main.css" type="text/css">
	<link rel="stylesheet" href="/style/list.css" type="text/css">
</head>
<body>
	<div id="articleContainer">
		<div id="articleTitle">Article list</div>
		<hr>
		<div id="articleList">
			<?php 
				require_once '../db.php';
				$db = new DB();
				$articles = $db->get_article_list();
				foreach ($articles as $article) {
					printf('<div class="article" id="article_%s">%s</div>', $article['id'], $article['name']);
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
				article.style.display = 'block';
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