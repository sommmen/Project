<?php
/*
 * Door Kevin Pijning
*/
require_once('config.php');


    /*
     * MySQLi class wordt geinitialisseerd
     */
    $mysqli = new Mysqli($config['host'], $config['username'], $config['password'], $config['database']);
    if(mysqli_connect_errno()){
        trigger_error($mysqli->error);
    }

    /*
     * SQL - injectie filter
     */
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
    /*
     * Einde filters
     */

    /*
     * Geeft de waarde van het opgevraagde url segment.
     * bijv. url: site.nl/portfolio/album/2
     * segment 1 = portfolio
     * segment 2 = album
     * segment 3 = 2
     */
    function urlSegment($int=''){
        $input = get('url');
        $input = explode('/', $input);
        $int--;
        return $input[$int];
    }

    /*
     * Geeft de waardes uit de instellingen tabel uit de database.
     */
    function getProp($key){
        global $mysqli;
        $sql = "SELECT * FROM setting WHERE `key` = '".$key."'";
        if($result = $mysqli->query($sql)){
            return $result->fetch_object()->value;
        }else{
            return false;
        }
    }

    /*
     * Filtert de html body uit de database op tags voor widgets
     */
    function includeTags($string) {

        preg_match('~\{\{(.*?)\}\}~', $string, $matches); // zoekt naar: {{ tag_name }}
        /*
         * Een widget tag bestaat uit twee delen, namelijk de map en de naam van het bestand.
         * bv. {{ portfolio_album }}
         * de widget staat in /widgets/portfolio/album.php
         * in dat bestand staat een functie met de volledige tag naam.
         * bv. function portfolio_album()
         * Deze funtie geeft de html uit de widget terug.
         */
        if($matches){
            $match =  $matches[1];
            $match = explode('_', $match); //tag naam wordt gesplitst

            $widget_folder = trim($match[0]); //map naam
            $widget_file = trim($match[1]); //bestand naam

            $file = 'widgets/'.$widget_folder.'/'.$widget_file.'.php'; // locatie naar widget bestand
            $method = $widget_folder.'_'.$widget_file; // naam van de functie in het widget bestand

            /*
             * Als deze widget bestaat, en het een geldig bestand is, dan wordt hij toegevoegd dmv. include_once.
             */
            if(file_exists($file) && is_file($file)){
                include_once($file);
                /*
                 * Check of de widget functie in het bestand staat.
                 */
                if(function_exists($method)) {
                    // vervangt de tag met de nieuwe html.
                    return preg_replace('~\{\{(.*?)\}\}~', $method(), $string);
                } else {
                    return $string; //widget functie bestaat niet, dus geeft hij de originele waarde terug
                }
            } else {
                return $string; //widget bestand bestaat niet, dus geeft hij de originele waarde terug
            }

        }else{
            return $string; //Geen tags gevonden, dus geeft hij de originele waarde terug
        }
}

    /*
     * Doorschakelen naar een pagina.
     */
    function redirect($to, $base=true){
        if($base==true){
            $to = getProp('base_url').$to;
        }
        header('location: '.$to);
    }

    /*
     * Checkt of de gebruiker is ingelogd aan de hand van de username en de token in de sessie.
     * Deze username en token worden vergeleken met de database, en als er geen match is, dan is de gebruiker niet ingelogd.
     */
    function logged_on(){
        global $mysqli;
        if(isset($_SESSION['user'])) {
            $token = addslashes($_SESSION['user']['token']);
            $username = addslashes($_SESSION['user']['name']);

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

    /*
     * Geeft de waarde van de opgevraagde collom terug van de ingelogde gebruiker.
     */
    function user_data($key){
        global $mysqli;
        @$token = addslashes($_SESSION['user']['token']);
        @$username = addslashes($_SESSION['user']['name']);

        if(!isset($token) && !isset($username)){
            return false;
        } else {

            $sql = "SELECT * FROM user WHERE username = '" . $username . "' AND token = '" . $token . "'";
            $result = $mysqli->query($sql);

            $result = $result->fetch_object();
            return @$result->$key;
        }
    }

    /*
     * Creer een bericht in een sessie.
     * bv. Als een gebruiker iets heeft aangepast, wordt hij direct doorgestuurd naar de overzicht pagina, en op die overzicht pagina
     * wordt dan het opgegeven bericht weergegeven.
     */
    function setMessage($message=''){
        $_SESSION['message'] = $message;
    }

    /*
     * Hier wordt het opgegeven bericht weergegeven, en daarna wordt de sessie leeg gemaakt zodat het bericht maar 1 keer wordt getoornd.
     */
    function getMessage(){
        if(isset($_SESSION['message'])){
            $message = htmlspecialchars($_SESSION['message']);
            unset($_SESSION['message']);
            return '<div class="alert-message">'.$message.'</div>';
        }
    }

    /*
     * Hier wordt gecontrolleerd of de ingelogde gebruiker minimaal de benodigde rang heetf om de betreffende pagina te bezoeken.
     */
    function minRole($int=null){
        if(user_data('role') < $int)
            redirect('/beheer/');
    }

    /*
     * Met deze functie kan je makkelijk ingevulde waardes in een POST veld terughalen.
     * bv. als er iets fout is gegaan, is he formulier niet weer helemaal leeg.
     * Er is ook een mogelijkheid om een default op te geven, dit kan gebruikt worden bij het bewerken van iets.
     * De default waarde is dan hetgene wat in de database staat.
     */
    function set_value($post, $default=''){
        return @$_POST[$post] ? post($post) : $default;
    }

    /*
     * Hier wordt een random wachtwoord gegenereerd.
     */
    function random_password() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }