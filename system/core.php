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