<?php
	class DB {
		private $host;
		private $usr;
		private $pwd;
		private $db;
		private $newDB;
		private $result;

		//costruttore
		public function __construct($host, $usr, $pwd, $db=''){
			$this->host = $host;
			$this->usr = $usr;
			$this->pwd = $pwd;
			$this->db = $db;
			$this->newDB = null;
			$this->result = null;
			$this->start();
		}

		// ritorna la connessione al DB
		public function getconnection(){
			return $this->newDB;
		}

		// funzione per segnalare eventuali errori
		public function error() {
			return "(" . mysqli_errno($this->newDB) . ") " . mysqli_error($this->newDB);
		}

		// funzione per far partire la connessione
		public function start() {
			// se la connessione dovesse essere già stata stabilita allora disconnetti e in seguito rieffettua la connessione
			if($this->newDB != null){
				$this->stop();
			}
			$this->newDB = mysqli_connect($this->host, $this->usr, $this->pwd, $this->db);
			return $this->newDB;
		}

		// funzione per chiudere la connessione
		public function stop(){
			if($this->newDB != null){
				mysqli_close($this->newDB);
				$this->newDB = null;
			}
		}

		// funzione per eseguire le query
		public function query($query){
			$this->res = mysqli_query($this->newDB, $query);
			return $this->res;
		}
	}

	// se la connessione al DB non è stata stabilita allora prova a connetterti
	if($newDB==null){
		$newDB = new DB("mysql.samtinfo.ch", "i13lupand", "lupand1", "samtinfoch17");
	}
?>
