<?php
class DatabaseMysql {
	var $dbname = 'mycmsdb';
	var $dbuser = 'root';
	var $dbpass = 'root';
	var $dbserver = 'localhost';
	var $con; //Deze var bewaart de connectie.
	
	var $query;
	var $select = "*";
	var $table;
	var $result;
	var $from;
	var $where;
	var $limit;
	
	function set_config($server, $db, $user, $pass){
		$this->dbserver = $server;
		$this->dbname	= $db;
		$this->dbuser	= $user;
		$this->dbpass	= $pass;
	}
	
	private function connect(){
		$this->con = mysqli_connect($this->dbserver, $this->dbuser, $this->dbpass, $this->dbname, 3306);
		if(!$this->con){
			die('Could not connect: '.mysqli_connect_error());
		}
	}
	
	private function disconnect(){
		mysqli_close($this->con);
	}
	
	function query($sql){
		$this->connect();
		$this->result = mysqli_query($this->con, $sql);
		$this->disconnect();
		return $this->result;
	}
	
	function select($rows="*"){
		$this->select = $rows;
	}
	
	function from($table){
		$this->table = $table;
	}
	
	function where($key, $val){
		$key = trim($key);
		if(!is_array($key)){
			if(empty($this->where)){
				$exp = explode(" ", $key);
				if(count($exp) > 1){
					$this->where = "WHERE ".$exp[0]." ".$exp[1]." '".$val."'";
				} else {
				$this->where = "WHERE ".$key." = '".$val."'";
				}
			} else {
				
			}
		}
	}
	
	function get($table='', $limit1='', $limit2=''){
	
		if(!empty($limit1)){
			$this->limit = "LIMIT ".$limit1;
			if(!empty($limit2)){
				$this->limit .= ", ".$limit2;
			}
		}
		
		if(!empty($table))
			$this->table = $table;
			//echo "SELECT ".$this->select." FROM ".$this->table." ".$this->where." ".$this->limit;
		return $this->result = $this->query("SELECT ".$this->select." FROM ".$this->table." ".$this->where." ".$this->limit);
		

	}
	
	function num_rows($query=''){
		if(empty($query)){
			$query = $this->result;
		}
		return mysqli_num_rows($query);
	}
	
	function result($sql=''){
		if(empty($sql))
			$this->result = $sql;
			
		$this->connect();
		$sth = $this->result;
		$rows = array();
		while($r = mysqli_fetch_object($sth)){
			$rows[] = $r;
		}
		$this->disconnect();
		return $rows;
	}
	
	function row($sql=''){
		if(empty($sql))
			$this->result = $sql;
			
		$this->connect();
		$sth = $this->result;
		$row = mysqli_fetch_object($sth);
		$this->disconnect();
		return $row;
	}
	
}