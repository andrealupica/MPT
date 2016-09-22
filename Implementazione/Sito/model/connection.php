<?php
	class DB {
		private $host;
		private $user;
		private $pass;
		private $db;
		private $connetion;
		private $result;
		
		public function __construct($host, $user, $pass, $db=''){
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->db = $db;
			$this->connection = null;
			$this->result = null;
		}

		public function connection(){
			if(!self::$_connection){
					self::$_connection = new mysqli(self::$hostname,self::$username,self::$pass);
				if(self::$_connection->connect_error){
					die('connection failed:' . self::$_connection->connect_error);
				}
				return self::$_connection;
			}
			if($connection==null){
			mysqli_connect($this->host, $this->user, $this->pass, $this->db);
			return $this->conn;			
			}

			//return 0;	
		}
	}
	if(!isset($_SESSION["db"])){
		$newDB = new DB("localhost", "root", "", "mpt");
		$_SESSION["db"] = $newDB;
	}
?>