<?php
/** Gemaakt door Eelco Eikelboom */

/** Stop mensen die geen permissie hebben */
    minRole(3);
    $id = urlSegment(3);

/** Aanmaken 'fields' (lang leve java) */
    $name = "";
    $surname = "";
    $address = "";
    $email = "";
    $zipcode = "";
    $city = "";
    $telephone = "";
    $result = $mysqli->query('SELECT * FROM user WHERE id = '.$id);

/** Terug sturen wanneer er de user niet gevonden kan worden */
    if($result->num_rows == 0)
        redirect('/beheer/customers');

/** Geef elk 'field' zijn waarde. */
    while($row = $result->fetch_array()){
        $name = $row['name'];
        $surname = $row['surname'];
        $address = $row['address'];
        $zipcode = $row['zipcode'];
        $city = $row['city'];
        $email = $row['email'];
        $telephone = $row['telephone'];
    }
/** Variable van placeholders. Als de 'POST' een error geeft, dan pakt ie de default values hierboven.*/
    $value_email = set_value('email', $email);
    $value_naam = set_value('name', $name);
    $value_achternaam = set_value('surname', $surname);
    $value_adres = set_value('address', $address);
    $value_postcode = set_value('zipcode', $zipcode);
    $value_woonplaats = set_value('city', $city);
    $value_telnr = set_value('telephone', $telephone);

/** Super vette foreach :D loopt door POST array heen, aangezien ik de name hetzelfde heb
 * gemaakt als de namen in de database kan ik efficient de database updaten.
 * Als de waarde leeg is, dan pakt ie de default weer.
 */
    if(isset($_POST['form_submit'])){
        foreach($_POST as $arrayName => $value){
            if($arrayName == "form_submit") continue;
            if(empty($value)){
                $value = set_value($arrayName, $name);
            }else{
                $mysqli->query('UPDATE user SET '.$arrayName.' = "'.$value.'" WHERE id = '.$id);
                if($arrayName == "email" && $email != $value){
                    newEmail($id, $value, $name.' '.$surname);
                }
                if($mysqli->error) die ($mysqli->error);
            }
        }
        setMessage('U heeft de gegevens met succes geweizigd!');
        redirect('/beheer/customers');
    }
    /**
     * Stuur email adress naar betreffende klant waarvan het email adres is geweizigd (mits een email adres is geweizigd.
     * Reden voor dat is omdat de hash van het wachtwoord van de klant is gekoppeld aan het email adres. En anders klopt de hele
     * logica daarvan niet meer. Dus vandaar dat de klant een nieuwe wachtwoord toegemaild krijgt wat ie weer kan veranderen.
     * Natuurlijk een random wachtwoord!
     */
    function newEmail($id, $to, $naam){
        global $mysqli;
        $password = random_password();
        $subject = 'Michael Verbeek - Wijziging Email';
        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $header .= 'From: Michael Verbeek <'.getProp('admin_mail').'>';
        mail($to, $subject,
            'Geachte Heer/Mevrouw '.$naam.' ,<br>
            Het ziet er naar uit dat uw email adres is veranderd via de website.<br>
            Vanwege veiligheidsmaatregelen hebben wij een nieuw wachtwoord voor u klaargezet.<br><br>
            <strong>Nieuw wachtwoord: </strong>'.$password.'<br>
            Mocht u nog enige vragen hebben, dan horen wij het graag. Excuses voor het ongemak!<br><br>
            Mvg,<br>
            Michael Verbeek - Fotografie/Geluidstechniek<br><br>
            <i>Is deze mail niet voor u bedoelt? Gelieve ons te contacteren op <a href="'.getProp('base_url').'">onze website</a>, excuses.</i>'
            , $header);
        $mysqli->query('UPDATE user SET password = "'.sha1($password).'" WHERE id = '.$id); /** Update in database! */
        if($mysqli->error) return 404;

    }
?>
<a href="/beheer/customers" class="button">Terug naar overzicht</a>
<h1>Wijzigen van <?php echo $name. ' '. $surname;?></h1>

<form method="POST">
    <label>Naam:</label> <input type="text" name="name" value="<?php echo $value_naam;?>"/><br />
    <label>Achternaam:</label> <input type="text" name="surname" value="<?php echo $value_achternaam;?>"/><br />
    <label>Adres:</label> <input type="text" name="address" value="<?php echo $value_adres;?>"/><br />
    <label>Postcode:</label><input type="text" name="zipcode" value="<?php echo $value_postcode;?>"/><br />
    <label>Woonplaats:</label><input type="text" name="city" value="<?php echo $value_woonplaats;?>"/><br />
    <label>Telefoonnummer:</label><input type="text" name="telephone" value="<?php echo $value_telnr;?>"/><br />
    <label>Email:</label><input type="text" name="email" value="<?php echo $value_email;?>"/> <br /><br/>
    <input type="submit" name="form_submit" value="Wijzig"/>     
</form>

