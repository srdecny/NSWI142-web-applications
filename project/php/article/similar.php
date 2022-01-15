
<?php
	$params = explode("/", $_SERVER['REQUEST_URI']);
	$article_id = $params[count($params) - 2];
	require_once("../db.php");
	$db = new DB();
	$article = $db->get_article($article_id);
    $article_list = $db->get_article_list($article_id);
    if (!$article) {
        http_response_code(404);
        die();
    }
    $distances = array_map(function ($other) use ($article) {
        if ($other["id"] == $article["id"]) {
            return PHP_INT_MAX;
        }
        return array($other["id"], $other["name"], levenshtein($article["name"], $other["name"]));
    }, $article_list);

    usort($distances, function ($a, $b) {
        return $a[2] - $b[2];
    });
    $top_3 = array_slice($distances, 1, 3);

    echo json_encode($top_3);

?>