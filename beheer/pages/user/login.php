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

if (isset($_POST['send'])) {
    if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)) {
        if (($num1 + $num2) == $_POST['captcha']) {
            if($mysqli->query("SELECT * FROM user WHERE email = '".post("email")."'")->fetch_object()->num_rows != false){
                $newpass = random_password();
                $mysqli->query("UPDATE user SET password = '$newpass' WHERE email = '".post('email')."'");
                mail(post("email"), "Nieuw wachtwoord", "hoi pipeloi,\n\n u hebt een nieuw wachtwoord!\n ze is:$newpass \n doei! \n micheal verbeek.");
            } else {
                setMessage("Dit email is bij ons niet bekend, kijk of u uw email correct ingevuld hebt. mocht u dit bericht nog een keer zien neem dan contact op met <a href='contact'>Micheal verbeek</a>"); //contact form linken!
            }
        } else {
            setMessage("Gelieve de captcha correct in te vullen.");
        }
    } else {
        setMessage("Gelieve een email in te voeren.");
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

$num1 = rand(1, 10);
$num2 = rand(1, 10);

$som = toLetters($num1) . " + " . toLetters($num2) . " = ";
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

        <form action="" method="post">

            <label for="username">Gebruikersnaam: <span>*</span></label>
            <input type="text" name="username" id="username"/>

            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="submit" value="Login"/>
        </form>
        <a href="#">Wachtwoord vergeten</a>

        <form id="dropdown" action="" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php set_value("email"); ?>">
            <label for="captcha"><?php echo $som; ?></label>
            <input type="number" name="captcha" id="captcha" value="<?php set_value("captcha"); ?>">
            <input type="submit" name="send" value="versturen">
        </form>
    </section>

</section>