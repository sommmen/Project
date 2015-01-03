<?php
function contact_form(){

    if(isset($_POST["submit"])){

        if(empty($_POST["name"]) ||
            empty($_POST["email"]) ||
            empty($_POST["subject"]) ||
            empty($_POST["msg"])){
            $error = 'U dient alle verplichte velden in te vullen.';
        }else{

            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6Lcaef8SAAAAADAAqMpi80fkt6OuC7ztobovresJ&response='.post('g-recaptcha-response').'&remoteip='.$_SERVER['REMOTE_ADDR']);
            $response = json_decode($response);

            if($response->{'success'} != 'true'){
                $error = 'Robot controle mislukt.';
            } else {

                $to = getProp('admin_mail');
                $subject = post('subject');
                $headers = "From: " . post('name') . " <" . post('email') . ">\r\n" .
                    "MIME-Version: 1.0" . "\r\n" .
                    "Content-type: text/html; charset=UTF-8" . "\r\n";
                $message = '
            <p>
            er is een mail gestuurd via de website.
            </p>
            <p>
            <table border="1">
            <tr>
                <td>Naam:</td><td>' . post('name') . '</td>
            </tr>
            <tr>
                <td>E-mail:</td><td>' . post('email') . '</td>
            </tr>
            <tr>
                <td>Telefoon:</td><td>' . post('tel') . '</td>
            </tr>
            <tr>
                <td>Adres:</td><td>' . post('address') . '</td>
            </tr>
            <tr>
                <td>Woonplaats:</td><td>' . post('woonplaats') . '</td>
            </tr>
            <tr>
                <td>Postcode:</td><td>' . post('postcode') . '</td>
            </tr>
            </table>
            </p>
            <p>
            ' . post('msg') . '
            </p>

            IP: ' . $_SERVER['REMOTE_ADDR'] . '

            ';

                mail($to, $subject, $message, $headers);
                $success = '<section class="success">Uw bericht is verstuurd, er wordt zo spoedig mogelijk contact met u opgenomen.</section>';

            }
        }

        $error = '<section class="error">'.$error.'</section>';

    }
    if(!$success) {
        $form = $error.'
    <form action="" method="post">
        <label for="name">Naam: <span>*</span></label>
        <input type="text" name="name" id="name" value="' . set_value('name') . '"/>

        <label for="email">E-mail: <span>*</span></label>
        <input type="text" name="email" id="email" value="' . set_value('email') . '"/>

        <label for="tel">Telefoon: </label>
        <input type="text" name="tel" id="tel" value="' . set_value('tel') . '"/>

        <label for="address">Adres: </label>
        <input type="text" name="address" id="address" value="' . set_value('address') . '"/>

        <label for="woonplaats">Woonplaats: </label>
        <input type="text" name="woonplaats" id="woonplaats" value="' . set_value('woonplaats') . '"/>

        <label for="postcode">Postcode: </label>
        <input type="text" name="postcode" id="postcode" value="' . set_value('postcode') . '"/>

        <label for="subject">Onderwerp: <span>*</span></label>
        <input type="text" name="subject" id="subject" value="' . set_value('subject') . '"/>

        <label for="msg">Bericht: <span>*</span></label>
        <textarea name="msg" id="msg">' . set_value('msg') . '</textarea>
        <br><br/>
        <div class="g-recaptcha" data-sitekey="6Lcaef8SAAAAAHl9G5Zm4w8A7nvUKJa-z6lv10VC"></div>
        <br/>
        <br>
        <input type="submit" name="submit" value="verzenden"/>
    </form>
    ';
    }else{
        $form = $success;
        unset($_POST);
    }
    return $form;
}
