<?php
require_once('includes/cmsApplication.php');
class TodolistApplication extends CmsApplication {
	function addtodotask(){
		echo 'add todo';
	}
	
	function viewtodolist(){
		echo 'view todo';
	}
	
	function displayDashboard(){
		?>
          <div>
            <h3>Todolist Application Dashboard</h3>
             <a href="#">Add Todo Task</a>
            <br/>
            <a href="#">View Todo List</a>
          </div>
    <?php
	}
	
	function display(){
		$sql='INSERT into table_name VALUE(1,valb,valc)';
 
		$db=$this->getDbo();
		if($db->query($sql)){
			echo'goe';
		}else{
			echo 'kut';
		}
		$this->displayDashboard();
	}
}