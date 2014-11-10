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
    preg_match('{{ [a-z]* }}', $string, $matches); //stopts alle matches in $matches
    unset($matches[0]); //verwijderd $matches[0] want die bevat alle matches en die zijn niet nodig.
    if (preg_match('{{ [a-z]* }}', $string) > 0) { //als er matches zijn dan:
        for ($index = 0; $index < count($matches); $index++) { //kijkt of de huidige match in dit 'lijstje' voorkomt (sql?) zo ja, vervangt hij de $string.
            switch ($matches[$index]) {
                case "{{ footer }}":
                    preg_replace($matches[$index], "require_once('system/footer.php');", $string);
                    break;
                case "{{ content }}":
                    preg_replace($matches[$index], "require_once('system/content.php');", $string);
                    break;
                default:
                    preg_replace($matches[$index], '<b style="color: red">Error, '.$matches[$index]." bestaat niet!", $string); //als er matches zijn die niet herkend worden, geef deze error weer.
                    break;
            }
        }
    }
    return $string;
}
