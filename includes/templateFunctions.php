<?php 
require_once('cmsBase.php');

class TemplateFunctions extends CmsBase{
    //Alle cms management gerelateerde functies komen hier in.
    var $templateName='default';
    var $widgetPositions=array();
    
    function show(){
        require_once($this->getCurrentTemplatePath().'index.php');
    }
    
    function getCurrentTemplatePath(){
        return 'templates/'.$this->templateName.'/';
    }
    function appOutput(){
    	$appname=(isset($_REQUEST['app']))?$_REQUEST['app']:'default'; 
        require_once('applications/'.$appname.'/'.$appname.'.php');
        $application = ucfirst($appname).'Application';
        $app=new $application();
        $app->run();
    }
    
    function setTemplate($templateName){
        $this->templateName=$templateName;
    }
    
    function widgetOutput($position='default'){
    
        if(!empty($this->widgetPositions[$position]))
        {
            $widgets=$this->widgetPositions[$position];//haalt alle widgets + positie op
            foreach($widgets as $widgetObject)//Geeft elke widget weer
            {
                $widgetName=$widgetObject->name;
                $widgetParameters=$widgetObject->parameters;
                require_once('widgets/'.$widgetName.'/'.$widgetName.'.php');
                $widgetclass=ucfirst($widgetName).'Widget';
                $widget=new $widgetclass();
                $widget->run($widgetName,$widgetParameters);
            }
        }
    }
    
    function setWidget($position,$widgetName,$params=array()){
        $widget=new StdClass;
        $widget->name=$widgetName;
        $widget->parameters=$params;
        //if there is no widget in position then create a new array
        if(empty($this->widgetPositions[$position]))
        {
            $this->widgetPositions[$position]=array($widget);
        }
        //if there is already a widget present in that position then just push new widget in array
        else
        {
            array_push($this->widgetPositions[$position],$widget);
        }        
    }
}
