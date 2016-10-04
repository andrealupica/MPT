<?php
	class DB {
		private $host;
		private $usr;
		private $pwd;
		private $db;
		private $conn;
		private $result;

		public function __construct($host, $usr, $pwd, $db=''){
			$this->host = $host;
			$this->usr = $usr;
			$this->pwd = $pwd;
			$this->db = $db;
			$this->conn = null;
			$this->result = null;
			$this->start();
		}

		public function getConnection(){
			return $this->conn;
		}
		public function error() {
			return "(" . mysqli_errno($this->conn) . ") " . mysqli_error($this->conn);
		}
		public function start() {
			if($this->conn != null){
				$this->stop();
			}
			$this->conn = mysqli_connect($this->host, $this->usr, $this->pwd, $this->db);
			return $this->conn;
		}
		public function stop(){
			if($this->conn != null){
				mysqli_close($this->conn);
				$this->conn = null;
			}
		}
		public function query($query){
			$this->res = mysqli_query($this->conn, $query);
			return $this->res;
		}

	}
	$newDB;
	if($newDB==null){
		$newDB = new DB("mysql.samtinfo.ch", "i13lupand", "lupand1", "samtinfoch17");
	}
?>
