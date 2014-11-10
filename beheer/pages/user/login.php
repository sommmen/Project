<?php

if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $error = 'U dient alle velden in te vullen.';
    }else{

        $sql = "SELECT * FROM user WHERE username = '".post('username')."' AND password = '".sha1(post('password'))."'";
        $result = $mysqli->query($sql);
        if($result->num_rows == 0){
            $error = 'Onjuisje gebruikersnaam of wachtwoord.';
        }else{
            $user = $result->fetch_object();
            $token = sha1($user->id.$user->username.date('U'));

            $mysqli->query("UPDATE user SET token = '".$token."' WHERE username = '".post('username')."' AND password = '".sha1(post('password'))."' ");

            $_SESSION['user'] = array(
                'name'  => $user->username,
                'token' => $token
            );
            setMessage('Welkom '.$user->username);
            redirect('/beheer/');

        }

    }
}

?>

<section class="modal">

    <?php
    if(isset($error)){
        ?>
        <div class="alert-error">
            <?php echo $error;?>
        </div>
    <?php
    }
    ?>

    <header>
        Login
    </header>
    <section class="modal-content">

        <form action="" method="post">

            <label for="username">Gebruikersnaam: <span>*</span></label>
            <input type="text" name="username" id="username"/>

            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="submit" value="Login"/>

        </form>

    </section>

</section>