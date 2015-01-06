<?php
/*
 * Door Kevin Pijning
 */

minRole(3);

if(isset($_POST['submit'])){

    // Reguliere form validatie
    if(empty($_POST['title'])){
        $error = "U dient alle verplichte velden in te vullen.";
    }elseif($_POST['user_id'] == 0){
        /*
         * Als er geen voorgestelde klant wordt gebruikt is het user_id veld leeg, en dus moet alle informatie worden ingevuld.
         */
        if(empty($_POST['name']) ||
            empty($_POST['surname']) ||
            empty($_POST['email']) ||
            empty($_POST['address']) ||
            empty($_POST['zipcode']) ||
            empty($_POST['telephone'])){
            $error = "U dient alle verplichte velden in te vullen.";
        }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error = "U dient een geldig email adres op te geven.";
        }
    }

    if(!isset($error)){
        if($_POST['user_id'] == 0){ //Geen voorgestelde klant geselecteerd
            /*
             * Omdat er geen voorgestelde klant is geselecteerd moet er een nieuwe klant worden aangemaakt in de database,
             * en de inlog gegevens die gegenereerd worden moeten per email verstuurd worden naar de nieuwe klant.
             */
            $username = post('name').'-'.post('surname'); // genereren van gebruikernaam aan de hand van de voor- en achternaam
            $random_password = random_password(); //random wachtwoord genereren
            $password = sha1($random_password);
            $query = "INSERT INTO user (username,
                                        password,
                                        name,
                                        surname,
                                        address,
                                        zipcode,
                                        city,
                                        email,
                                        telephone,
                                        role)
                VALUES ('".$username."',
                        '".$password."',
                        '".post('name')."',
                        '".post('surname')."',
                        '".post('address')."',
                        '".post('zipcode')."',
                        '".post('city')."',
                        '".post('email')."',
                        '".post('telephone')."',
                        '2')";

            if($mysqli->query($query)) {    // Doe poging om de gebruiker toe te voegen.
                $user_id = $mysqli->insert_id;                
            }else{
                $error = 'De gebruiker kan niet worden toegevoegd.';
            }

        } else {
            /*
             * Als er wel een voorgestelde klant is geselecteerd, wordt het post veld user_id ingevuld met het ID van die gekozen gebruiker.
             * Er hoeft hier dus geen nieuwe klant worden aangemaakt.
             */
            $user_id = post('user_id');
        }

        // Project wordt toegevoegd
        $query = "INSERT INTO project (title,
                                       uid,
                                       max)
            VALUES ('".post('title')."',
                    '".$user_id."',
                    '".post('max')."')";

        if(!$mysqli->query($query)){
            echo $mysqli->error;
        }else {
            /*
             * Als het project is toegevoegd, wordt er een mail gestuurd naar de klant.
             * Als het een nieuwe klant is wordt er een mail gestuurd met de inlog gegevens en de plaats waar ingelogd kan worden.
             * Als het een bestaande klant is wordt er alleen een mail gestuurd dat er een project is aangemaakt.
             */
            $project_id = $mysqli->insert_id;
            
            if($_POST['user_id'] == 0){
                // dit gedeelte is voor een nieuwe user
                
                $to=post('email');
                $name = post('name').' '.post('surname');
                // Email naar nieuwe klanten
                $email_content = 'Beste '.$name.',<br>'
                        . '<br>'
                        . 'U bent nieuw toegevoegd aan het klanten systeem van Michael Verbeek.<br/>'
                        . 'U kunt met uw gebruikersnaam en wachtwoord inloggen op de site van Michael Verbeek.<br>'
                        . '<br>'
                        . 'gebruikersnaam: '.$username.'<br>'
                        . 'wachtwoord: '.$random_password.'<br>'
                        . '<br>'
                        . 'U kunt inloggen op de volgende link: <a href="'.getProp('base_url').'/beheer">'.getProp('base_url').'/beheer</a><br>'
                        . '<br>'
                        . 'Met vriendelijke groet,<br>'
                        . '<br>'
                        . 'Michael Verbeek';
                
            }else{
                // dit gedeelte is voor een bestaande user
                
                $query = "SELECT * FROM user WHERE id = '".post('user_id')."'";
                $result = $mysqli->query($query);
                $user = $result->fetch_object();
                
                $to = $user->email;
                $name = $user->name.' '.$user->surname;
                //email naar bestande klant
                $email_content = 'Beste '.$name.',<br>'
                        . '<br>'
                        . 'Michael Verbeek heeft een nieuw project voor U aangemaakt.<br/>'
                        . 'U kunt op de volgende link inloggen om het project te kunnen bekijken: <a href="'.getProp('base_url').'/beheer">'.getProp('base_url').'/beheer</a><br>'
                        . '<br>'
                        . 'Met vrienelijke groet,<br>'
                        . '<br>'
                        . 'Michael Verbeek';
            }
            
            $subject = 'nieuw project aangemaakt';
            $headers =  "From: Michael Verbeek <".getProp('admin_mail').">\r\n".
                        "MIME-Version: 1.0" . "\r\n" .
                        "Content-type: text/html; charset=UTF-8" . "\r\n";

            //Mail wordt verstuurd.
            mail($to, $subject, $email_content, $headers);
            $success = '<section class="success">Uw bericht is verstuurd, er wordt zo spoedig mogelijk contact met u opgenomen.</section>';
            
            //succes bericht wordt aangemaakt en de gebruiker wordt doorgestuurd naar de pagina waar hij fotos kan uploaden.
            setMessage('Het project is succesvol toegevoegd.');
            redirect('/beheer/projects/addPhotos/'.$project_id);
        }


    }

}

if(isset($error)) {
    echo '<div class="alert-error">' . @$error . '</div>';
}

?>
    <a href="/beheer/projects" class="button red">Terug naar overzicht</a>
    <h1>Project toevoegen</h1>
    <form action="" method="post">

        <input type="hidden" name="user_id" id="user_id" value="<?php echo set_value('user_id', '0');?>">

        <label for="title">Project naam:<span>*</span></label>
        <input type="text" name="title" id="title" value="<?php echo set_value('title');?>">

        <section class="customerData">
            <section class="half form" style="<?php if($_POST['user_id'] != 0){ echo 'display: none;'; } ?>">

                <label for="name">Klant voornaam:<span>*</span></label>
                <input type="text" name="name" id="name" value="<?php echo set_value('name');?>">

                <label for="surname">Klant achternaam:<span>*</span></label>
                <input type="text" name="surname" id="surname" value="<?php echo set_value('surname');?>">

                <label for="email">Klant email:<span>*</span></label>
                <input type="text" name="email" id="email" value="<?php echo set_value('email');?>">

                <label for="address">Klant adres:<span>*</span></label>
                <input type="text" name="address" id="address" value="<?php echo set_value('address');?>">

                <label for="zipcode">Klant postcode:<span>*</span></label>
                <input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode');?>">

                <label for="city">Klant woonplaats:<span>*</span></label>
                <input type="text" name="city" id="city" value="<?php echo set_value('city');?>">

                <label for="telephone">Klant telefoon:<span>*</span></label>
                <input type="text" name="telephone" id="telephone" value="<?php echo set_value('telephone');?>">

            </section>

            <section class="half results">

                <?php
                if(isset($_POST['user_id']) && $_POST['user_id'] != 0) {

                    $result = $mysqli->query("SELECT * FROM user WHERE id = '".post('user_id')."'");
                    if($result->num_rows == 0){
                        unset($_POST);
                        redirect('/beheer/projects/add');
                    }else{
                        $user = $result->fetch_object();
                    }

                    ?>
                    <ul id="user-1" class="user" style="display: block;">
                        <li>
                            <?php echo $user->name." ".$user->surname;?>
                            <ul style="display: block;">
                                <li><?php echo $user->email;?></li>
                                <li><?php echo $user->address;?></li>
                                <li><?php echo $user->zipcode;?></li>
                                <li><?php echo $user->city;?></li>
                                <li><?php echo $user->telephone;?></li>
                            </ul>
                        </li>
                    </ul>
                <?php
                }
                ?>

            </section>

        </section>

        <label for="max">Maximaal te selecteren foto's:</label>
        <input type="number" name="max" id="max" min="0" value="<?php echo set_value('max',0);?>">

        <br/><br/>
        <div class="dropzone-previews"></div>
        <br/><br/>
        <input type="submit" name="submit" value="Aanmaken"/>
    </form>

