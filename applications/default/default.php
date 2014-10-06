<?php
require_once('includes/cmsApplication.php');

class DefaultApplication extends CmsApplication{
	function addContent(){
		echo 'Content toevoegen.';
	}
	
	function display(){
		echo 'Content weergeven.';
	}
	
	function ietsAnders(){
		echo 'Doe iets anders.';
	}
}