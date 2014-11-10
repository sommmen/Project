<?php
require_once('config.php');

    $mysqli = new Mysqli($config['host'], $config['username'], $config['password'], $config['database']);
    if(mysqli_connect_errno()){
        trigger_error($mysqli->error);
    }

    function post($input=''){
        $input = htmlspecialchars($_POST[$input]);
        $input = addslashes($input);
        return $input;
    }

    function get($input=''){
        $input = htmlspecialchars($_GET[$input]);
        $input = addslashes($input);
        return $input;
    }

    function urlSegment($int){
        $input = get('url');
        $input = explode('/', $input);
        $int--;
        return $input[$int];
    }

    function getProp($key){
        global $mysqli;
        $sql = "SELECT * FROM setting WHERE `key` = '".$key."'";
        if($result = $mysqli->query($sql)){
            return $result->fetch_object()->value;
        }else{
            return false;
        }
    }
    
    function includeTags($string) {

        preg_match('~\{\{(.*?)\}\}~', $string, $matches);

        if($matches){
            $match =  $matches[1];
            $match = explode('_', $match);

            $widget_folder = trim($match[0]);
            $widget_file = trim($match[1]);

            $file = 'widgets/'.$widget_folder.'/'.$widget_file.'.php';
            $method = $widget_folder.'_'.$widget_file;

            if(file_exists($file) && is_file($file)){
                include_once($file);
                if(function_exists($method)) {
                    return preg_replace('~\{\{(.*?)\}\}~', $method(), $string);
                } else {
                    return $string;
                }
            } else {
                return $string;
            }

        }else{
            return $string;
        }
        //echo $string;
}
