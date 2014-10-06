<?php
require_once('includes/cmsWidget.php');
class HelloWidget extends CmsWidget{
	
	function display(){
		$world = 'World';
		if(count($this->parameters!=0)){
			$world = $this->parameters['hello_to'];
		}
		echo "Hello ".$world;
	}
	
}