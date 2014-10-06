<?php
require_once('cmsBase.php');
class CmsApplication extends CmsBase{
	//alles hier in zal te benaderen zijn in de hoofd functionaliteiten van de CMS
	
	function run(){
		//Hier in komt de hele logica van de cms
		//Dit wordt aangeroepen vanuit de template class
		$method=(isset($_REQUEST['task'])) ? $_REQUEST['task'] : 'display';
		$this->$method();
	}
	
	function display(){
		echo 'dit is de base display.';
	}
	
}