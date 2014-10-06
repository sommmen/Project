<?php
class DatabaseMysql {
	var $dbname = 'mycmsdb';
	var $dbuser = 'root';
	var $dbpass = 'root';
	var $dbserver = 'localhost';
	var $con; //Deze var bewaart de connectie.
	
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
		$res = mysqli_query($this->con, $sql);
		$this->disconnect();
		return $res;
	}
	
	function loadResult($sql){
		$this->connect();
		$sth = mysqli_query($this->con, $sql);
		$rows = array();
		while($r = mysqli_fetch_object($sth)){
			$rows[] = $r;
		}
		$this->disconnect();
		return $rows;
	}
	
	function loadSingleResult($sql){
		$this->connect();
		$sth = mysqli_query($this->con, $sql);
		$row = mysqli_fetch_objcect($sth);
		$this->disconnect();
		return $row;
	}
	
}