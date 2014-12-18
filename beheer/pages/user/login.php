<?php
//var_dump($_SESSION);

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
//        var_dump($_POST);
        if (isset($_POST['captcha'])) {
            $result = $mysqli->query("SELECT * FROM user WHERE email = '" . post("email") . "'");
            if ($result->num_rows != false) {
                echo $newpass = random_password();
                $query = "UPDATE user SET password = '" . sha1($newpass) . "' WHERE email = '" . post('email') . "'";
                if ($mysqli->query($query)) {
                    mail(post("email"), "Nieuw wachtwoord", "hoi pipeloi,\n\n u hebt een nieuw wachtwoord!\n\n ze is: $newpass\n\n doei! \n\n\n micheal verbeek.");
                    $error = "er is een nieuw wachtwoord naar deze gebruiker verstuurd.";
                } else {
                    $error = "een interne fout, probeer het opnieuw en blijft deze error neem dan contact op met de admin.";
                }
            } else {
                $error = ("Dit email is bij ons niet bekend, kijk of u uw email correct ingevuld hebt. mocht u dit bericht nog een keer zien neem dan contact op met <a href='/contact'>Micheal verbeek</a>"); //contact form linken!
            }
        } else {
            $error = "robots zijn verboden!";
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
            <label for="captcha">ik ben geen robot</label>
            <input type="checkbox" name="captcha" id="captcha" value="nee">
            <input type="submit" name="send" value="versturen">
        </form>
    </section>

</section>