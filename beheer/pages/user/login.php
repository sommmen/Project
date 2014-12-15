<?php
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = 'U dient alle velden in te vullen.';
    } else {

        $sql = "SELECT * FROM user WHERE username = '" . post('username') . "' AND password = '" . sha1(post('password')) . "'";
        $result = $mysqli->query($sql);
        if ($result->num_rows == 0) {
            $error = 'Onjuiste gebruikersnaam of wachtwoord.';
        } else {
            $user = $result->fetch_object();
            $token = sha1($user->id . $user->username . date('U'));

            $mysqli->query("UPDATE user SET token = '" . $token . "' WHERE username = '" . post('username') . "' AND password = '" . sha1(post('password')) . "' ");

            $_SESSION['user'] = array(
                'name' => $user->username,
                'token' => $token
            );
            setMessage('Welkom ' . $user->username);
            redirect('/beheer/');
        }
    }
}

function toLetters($input) { //verplaatsen naar core?
    $letters = ["nul", "één", "twee", "drie", "vier", "vijf", "zes", "zeven", "acht", "negen", "tien"];
    foreach ($letters as $key => $value) {
        if ($key === $input) {
            return $value;
        }
    }
}

if(!isset($_SESSION['gbnaam']) && isset($_SESSION['wwoord'])){
    $_SESSION['gbnaam'] = random_password().rand(1,10);
    $_SESSION['wwoord'] = random_password().rand(1,10);
}

//$_SESSION['gbnaam'] ?: $_SESSION['gbnaam'] = random_password().rand(1,10); //hmm... zou dit werken?
//$_SESSION['wwoord'] ?: $_SESSION['wwoord'] = random_password().rand(1,10);


$num1 = substr($_SESSION['gbnaam'], 8);
$num2 = substr($_SESSION['wwoord'], 8);

$som = toLetters($num1) . " plus " . toLetters($num2) . " is: ";

if (isset($_POST['send'])) {
    if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)) {
//        echo "$num1 | $num2 | ".$_POST['captcha']."<br>";
        if (($num1 + $num2) === $_POST['captcha']) {
            unset($_SESSION['gbnaam']);
            unset($_SESSION['wwoord']);
            $result = $result->mysqli->query("SELECT * FROM user WHERE email = '".post("email")."'");
            if($result->fetch_object()->num_rows != false){
                $newpass = random_password();
                $mysqli->query("UPDATE user SET password = '$newpass' WHERE email = '".sha1(post('email')."'"));
                mail(post("email"), "Nieuw wachtwoord", "hoi pipeloi,\n\n u hebt een nieuw wachtwoord!\n ze is:$newpass \n doei! \n micheal verbeek.");
            } else {
                $error = ("Dit email is bij ons niet bekend, kijk of u uw email correct ingevuld hebt. mocht u dit bericht nog een keer zien neem dan contact op met <a href='contact'>Micheal verbeek</a>"); //contact form linken!
            }
        } else {
            $error = ("Gelieve de captcha correct in te vullen.");
        }
    } else {
        $error = ("Gelieve een email in te voeren.");
    }
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
            <label for="captcha"><?php echo $som; ?></label>
            <input type="number" name="captcha" id="captcha">
            <input type="submit" name="send" value="versturen">
        </form>
    </section>

</section>