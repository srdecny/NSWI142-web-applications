<?php

class Db {
	protected $conn;
	public function __construct() {
		include 'db_config.php';
		$this->conn = new mysqli($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);
		if ($this->conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
	}

	protected function query($query) {
		$result = $this->conn->query($query);
		if (!$result) {
			die('Invalid query: ' . $this->conn->error);
		}
		return $result;
	}

	protected function validate_number($str) {
		if (!preg_match('/^\d+$/', $str)) {
			throw new Exception("Invalid article id!");
		}
	}

	protected function validate_strings($name, $content) {
		if (!isset($name) || !isset($content)) {
			throw new Exception("Invalid article data!");
		}

		if (strlen($name) > 32 || strlen($content) > 1024) {
			throw new Exception("Too long article data!");
		}

	}

	protected function sanitize_results($result, $fields) {
		$rows = array();
		while ($row = $result->fetch_assoc()) {
			foreach($fields as $field) {
				$row[$field] = htmlspecialchars($row[$field]);
			}
			array_push($rows, $row);
		}
		return $rows;
	}

	function get_article_list() {
		$res = $this->query('SELECT id, name FROM articles');
		return $this->sanitize_results($res, array('name'));

	}

	function get_article($article_id) {
		$this->validate_number($article_id);
		$stmt = $this->conn->prepare('SELECT id, name, content FROM articles WHERE id = ?');
		$stmt->bind_param("i", $article_id);
		$stmt->execute();
		return $this->sanitize_results($stmt->get_result(), array('name', 'content'))[0];
	}

	function update_article($article_id, $name, $content) {
		$this->validate_number($article_id);
		$this->validate_strings($name, $content);
		$stmt = $this->conn->prepare('UPDATE articles SET name = (?), content = (?) WHERE id = (?)');
		$stmt->bind_param("ssi", $name, $content, $article_id);
		$stmt->execute();
	}

	function create_article($name, $content) {
		$this->validate_strings($name, $content);
		$stmt = $this->conn->prepare('INSERT INTO articles (name, content) VALUES (?, ?)');
		$stmt->bind_param("ss", $name, $content);
		$stmt->execute();
		// THIS IS NOT GUARANTEED TO BE CORRECT! (but it's ok for our purposes)
		return $this->query("select LAST_INSERT_ID()")->fetch_assoc()['LAST_INSERT_ID()'];
	}

	function delete_article($article_id) {
		$this->validate_number($article_id);
		$stmt = $this->conn->prepare('DELETE FROM articles WHERE id = ?');
		$stmt->bind_param("i", $article_id);
		$stmt->execute();
	}
}

?>