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

    function urlSegment($int=''){
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
}


    function redirect($to){
        header('location: '.$to);
    }

    function logged_on(){
        global $mysqli;
        if(isset($_SESSION['user'])) {
            $token = $_SESSION['user']['token'];
            $username = $_SESSION['user']['name'];

            $sql = "SELECT * FROM user WHERE username = '" . $username . "' AND token = '" . $token . "'";
            $result = $mysqli->query($sql);
            if ($result->num_rows != 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    function user_data($key){
        global $mysqli;
        $token = $_SESSION['user']['token'];
        $username = $_SESSION['user']['name'];

        $sql = "SELECT * FROM user WHERE username = '" . $username . "' AND token = '" . $token . "'";
        $result = $mysqli->query($sql);

        return $result->fetch_object()->$key;
    }

function setMessage($message=''){
    $_SESSION['message'] = $message;
}

function getMessage(){
    if(isset($_SESSION['message'])){
        $message = htmlspecialchars($_SESSION['message']);
        unset($_SESSION['message']);
        return '<div class="alert-message">'.$message.'</div>';
    }
}