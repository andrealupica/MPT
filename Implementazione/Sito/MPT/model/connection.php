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

		public function conn(){
			if(!self::$_conn){
					self::$_conn = new mysqli(self::$hostname,self::$usrname,self::$pwd);
				if(self::$_conn->connect_error){
					die('conn failed:' . self::$_conn->connect_error);
				}
				return self::$_conn;
			}
			if($conn==null){
			mysqli_connect($this->host, $this->usr, $this->pwd, $this->db);
			return $this->conn;			
			}

			//return 0;	
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
		public function fetch($q) {
			return mysqli_fetch_assoc($q);
		}
	}

	if(!isset($_SESSION["db"])){
		$newDB = new DB("mysql.samtinfo.ch", "i13lupand", "lupand1", "samtinfoch17");
		$_SESSION["db"] = $newDB;
	}
?>