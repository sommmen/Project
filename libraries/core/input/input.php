<?php
class input {
	
	function post($variable){
		$variable = strip_tags(mysql_real_escape_string(trim($_POST[$variable])));
		return $variable; 
	}
	
	function get($variable){
		$variable = strip_tags(mysql_real_escape_string(trim($_POST[$variable])));
		return $variable; 
	}
	
}