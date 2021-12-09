<?php 
	require_once '../db.php';
	$db = new DB();
	$articles = $db->get_article_list();

?>
<html>
<head>
	<title>Article list</title>
	<link rel="stylesheet" href="../style/style.css" type="text/css">
</head>
<body>
	<div id="articleContainer">
		<div id="articleTitle">Article list</div>
		<hr>
		<div id="articleList">
			<?php
				foreach ($articles as $article) {
					$line = <<<EOD
						<div class="articleLine" id="line{$article['id']}">
							<div class="articleTitle">{$article['name']}</div>
							<div class="articleControls">
								<a class="showLink" href="./article/{$article['id']}">Show</a>
								<a class="editLink" href="./article-edit/{$article['id']}">Edit</a>
								<a class="deleteLink" href="#" onclick="deleteArticle({$article['id']})">Delete</a>
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
			<button class="button" onClick="showDialog()" id="createButton">Create Article</button>
		</div>
	</div>
	<dialog id="newArticleDialog">
		<iframe id="iframe" onload="iframeHandler(this.contentWindow.location.href)" src="./article-edit/new"></iframe>
	</dialog>
</body>

<script>
	const articleList = document.getElementById('articleList');
	const previousButton = document.getElementById('previousButton');
	const nextButton = document.getElementById('nextButton');
	const pagesSpan = document.getElementById('pages');

	const ARTICLES_PER_PAGE = 10;
	let index = 0;

	const update = (newIndex) => {
		const articleCount = articleList.children.length;
		let maxIndex = Math.ceil(articleCount / ARTICLES_PER_PAGE) - 1;

		if (newIndex < 0  || newIndex > maxIndex) return;
		[...articleList.children].forEach(child => child.style.display = 'none');
		for (let i = 0; i < ARTICLES_PER_PAGE; i++) {
			const article = articleList.children[newIndex * ARTICLES_PER_PAGE + i];
			if (article) {
				article.style.display = 'flex';
			}
		};

		pages.innerHTML = `Page ${newIndex + 1 } of ${maxIndex + 1}`;
		previousButton.style.display = newIndex === 0 ? 'none' : 'inline-block';
		nextButton.style.display = newIndex === maxIndex ? 'none' : 'inline-block';
	}
	update(0)

	const previous = () => update(--index);
	const next = () => update(++index);
	const showDialog = () => {
		const dialog = document.getElementById('newArticleDialog');
		dialog.showModal();
	}

	const iframeHandler = (url) => {
		if (url.includes('/article-edit/new')) {
			return
		} else if (url.includes('/article/')) {
			window.location.href = url;
		} else {
			const dialog = document.getElementById('newArticleDialog');
			dialog.close();
			document.getElementById('iframe').src = './article-edit/new';
		}
	}

	const deleteArticle = async (id) => {
		document.getElementById(`line${id}`).remove();
		await fetch(`./article/${id}`, {
			method: 'DELETE'
		})
		if ([...articleList.children].filter(e => e.style.display != 'none').length === 0) {
			index > 0 ? previous() : next()
		}
	}



</script>