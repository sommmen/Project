<?php
require_once('libraries/core/database/databaseMySql.php');
require_once('libraries/core/input/input.php');

class CmsBase{
	//alles hier in is in de hele CMS te benaderen
	
	var $db;
	
	function __construct(){
		$this->db = $this->getDbo();
		$this->input = $this->getInput();
	}
	
	public function getInput(){
		static $getInput = null;
		if(null === $getInput){
			$getInput = new Input();
		}
		return $getInput;
	}
	
	public function getDbo(){
		static $dbobject = null;
		if(null === $dbobject){
			$dbobject = new DatabaseMySql();
		}
		return $dbobject;
	}
}