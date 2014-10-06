<?php
require_once('libraries/core/database/databaseMySql.php');
class CmsBase{
	//alles hier in is in de hele CMS te benaderen
	public function getDbo(){
		static $dbobject = null;
		if(null === $dbobject){
			$dbobject = new DatabaseMySql();
		}
		return $dbobject;
	}
}