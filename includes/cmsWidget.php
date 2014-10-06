<?php
require_once('cmsBase.php');
class CmsWidget extends CmsBase{
	//alles hier in zal te benaderen zijn in de widget functionaliteit van de CMS
	var $widgetPath = '';
	var $widgetName = '';
	
	function setWidgetPath($widgetName){
		//hier wordt de path van de widget ge-set.
		$this->widgetPath = 'widgets/'.$widgetName.'/';
		$this->widgetName = $widgetName;
	}
	
	function getWidgetPath(){
		return $this->widtgetPath;
	}
	
	function display(){
		echo 'dit wordt de default output.';
	}
	
	function run($widgetName, $params){
		$this->parameters = $params;
		$this->setWidgetPath($widgetName);
		$this->display();
	}
}