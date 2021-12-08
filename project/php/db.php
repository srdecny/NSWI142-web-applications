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

	function get_article_list() {
		return $this->query('SELECT id, name FROM articles');
	}
}

?>