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

	function get_article_list() {
		return $this->query('SELECT id, name FROM articles');
	}

	function get_article($article_id) {
		$this->validate_number($article_id);
		$stmt = $this->conn->prepare('SELECT id, name, content FROM articles WHERE id = ?');
		$stmt->bind_param("i", $article_id);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	function update_article($article_id, $name, $content) {
		$this->validate_number($article_id);
		if (!isset($name) || !isset($content)) {
			throw new Exception("Invalid article data!");
		}

		if (strlen($name) > 32 || strlen($content) > 1024) {
			throw new Exception("Too long article data!");
		}

		$stmt = $this->conn->prepare('UPDATE articles SET name = (?), content = (?) WHERE id = (?)');
		$stmt->bind_param("ssi", $name, $content, $article_id);
		$stmt->execute();
		return $stmt->get_result();
	}
}

?>