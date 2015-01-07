<?php
/*
 *              in al haar professionaliteit gemaakt door:
 *              Kevin Pijning met een vleugje Dion Leurink
 */

//dit block zorgt voor het inloggen.
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = 'U dient alle velden in te vullen.';
    } else {

        $sql = "SELECT * FROM user WHERE username = '" . post('username') . "' AND password = '" . sha1(post('password')) . "'";
        $result = $mysqli->query($sql);
        
        //staat de gebruikersnaam & wachtwoord in de database?
        if ($result->num_rows == 0) {
            $error = 'Onjuiste gebruikersnaam of wachtwoord.';
            
        } else {
            
            //maak een token aan op basis van de gebruiker en een timestamp
            $user = $result->fetch_object();
            $token = sha1($user->id . $user->username . date('U'));
            
            //upload deze naar de database
            $mysqli->query("UPDATE user SET token = '" . $token . "' WHERE username = '" . post('username') . "' AND password = '" . sha1(post('password')) . "' ");
            
            //en stop deze vervolgens in de sessie
            $_SESSION['user'] = array(
                'name' => $user->username,
                'token' => $token
            );
            
            //redirect de gebruiker  naar de klantenpagina met een welkomstbericht
            setMessage('Welkom ' . $user->username);
            redirect('/beheer/');
        }
    }
}

//kleine functie die nummers omvormt naar letters (dat maakt het hackers net even een tikkeltje moeilijker)
function toLetters($input) {
    $letters = ["nul", "één", "twee", "drie", "vier", "vijf", "zes", "zeven", "acht", "negen", "tien"];
    foreach ($letters as $key => $value) {
        if ($key === $input) {
            return $value;
        }
    }
}

//als de captcha nog niet verzonden is als de gebruiker de pagina laad, maak dan in een sessie 2 nieuwe getallen voor de captcha.
if(!isset($_POST['send'])) {
    $_SESSION['num1'] = rand(0, 10);
    $_SESSION['num2'] = rand(0, 10);
}

//dit codeblok verwerkt het 'vergeten van wachtwoord' gedeelte op de pagina.
if(isset($_POST['send'])){
    if(empty($_POST['email']) || empty($_POST['captcha'])){
        $error = 'U dient alle velden in te vullen.';
    } elseif($_POST['captcha'] != ($_SESSION['num1'] + $_SESSION['num2'])) {
        $error = 'U dient een goede captcha code in te vullen.';
        //als alles correct is ingevuld dan:
    } else {
        
        $query = $mysqli->query("SELECT * FROM user WHERE email = '".post('email')."'");
        
        if($query->num_rows == 1){
            //genereert een random wachtwoord
            $newPassword = random_password();
            
            //upload deze naar de database
            $mysqli->query("UPDATE user SET password = '".sha1($newPassword)."' WHERE email = '".post('email')."'");
           
            //opmaak voor de mail
            $to=post("email");
            $subject = "Nieuw wachtwoord aangevraagd";
            $headers =  "From: Michael Verbeek <".getProp('admin_mail').">\r\n".
                "MIME-Version: 1.0" . "\r\n" .
                "Content-type: text/html; charset=UTF-8" . "\r\n";

            $message = 'Beste klant, <br/> Er is onlangs een nieuw wachtwoord aangevraagd via de website van Michael Verbeek.<br/><br/>
                        Het nieuwe wachtwoord is:<br/>
                        '.$newPassword.'<br/>
                        <br/>
                        Met vriendelijke groet,<br/>
                        Michael Verbeek<br/>';

            //verstuur de mail met het nieuwe wachtwoord
            mail($to, $subject, $message, $headers);
        }
        
        //fake succes dat er een email is verzonden als het ingevoerde email adres verkeerd is zodat crackers niet achter de emails in onze database kunnen komen d.m.v. bruteforce.
        $error = 'Er is een email verzonden naar het ingevoerde email adres.';

    }
    
    //vernieuw de captcha getallen (bij een error zou de '!isset(...' niet resetten, en door dit stukje code wel!)
    $_SESSION['num1'] = rand(0, 10);
    $_SESSION['num2'] = rand(0, 10);
}
?>

<section class="modal">

<?php
if (isset($error)) {
    ?>
        <div class="alert-error">
        <?php echo $error; ?>
        </div>
            <?php
        }
        ?>

    <header>
        Login
    </header>
<?php getMessage(); ?>
    <section class="modal-content">

        <form action="" method="post" id="loginform">

            <label for="username">Gebruikersnaam: <span>*</span></label>
            <input type="text" name="username" id="username"/>

            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="submit" value="Login"/>
        </form>
        <a href="#" id="toggleDropDown">Wachtwoord vergeten</a>

        <form id="dropdown" action="" method="POST" style="display: none;">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php set_value("email"); ?>">
            <label for="captcha"><?php echo toLetters(@$_SESSION['num1'])." plus ".toLetters(@$_SESSION['num2'])." is:";?></label>
            <input type="number" name="captcha" id="captcha">
            <input type="submit" name="send" value="versturen">
        </form>
    </section>

</section>