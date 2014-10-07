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
    	
    	$this->db->from('page');
    	$this->db->where('ceo_friendly', $_GET['app']);
    	$query = $this->db->get();
    	
		
		if($this->db->num_rows() > 0){
			$row = $this->db->row($query);
			return $row->content;
			
		} else {
			$applicationFile = 'applications/'.$appname.'/'.$appname.'.php';
			if(file_exists($applicationFile)){
		        require_once($applicationFile);
		        $application = ucfirst($appname).'Application';
		        $app=new $application();
				$app->run();
	        } else {
		        $row = $this->db->singleResult("SELECT * FROM page WHERE ceo_friendly = '404'");
				return $row->content;
	        }
	    }
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
