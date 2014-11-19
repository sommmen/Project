<?php
    minRole(3);
    $id = urlSegment(3);
    
    global $mysqli;
    $name = "";
    $surname = "";
    $address = "";
    $zipcode = "";
    $city = "";
    $telephone = "";
    $result = $mysqli->query('SELECT * FROM user WHERE id = '.$id);
    while($row = $result->fetch_array()){
        $name = $row['name'];
        $surname = $row['surname'];
        $address = $row['address'];
        $zipcode = $row['zipcode'];
        $city = $row['city'];
        $telephone = $row['telephone'];
    }
    
    $value_naam = set_value('name', $name);
    $value_achternaam = set_value('surname', $surname);
    $value_adres = set_value('address', $address);
    $value_postcode = set_value('zipcode', $zipcode);
    $value_woonplaats = set_value('city', $city);
    $value_telnr = set_value('telephone', $telephone);
    
    if(isset($_POST['form_submit'])){
       $result = $mysqli->query('UPDATE user SET (name = "'.post('name').'", surname = "'.post('surname').'", address = "'.post('address').'" 
       , zipcode = "'.post('zipcode').'", city = "'.post('city').'", telephone = "'.post('telephone').'") WHERE id = '.$id);
       if($result->error){ die (404);}
       header('location: index.php');
       exit();
    }
?>


<form method="POST">
    <h1>Wijzigen van <?php echo $name. ' '. $surname;?></h1>
    <label>Naam:</label> <input type="text" name="name" value="<?php echo $value_naam;?>"/><br />
    <label>Achternaam:</label> <input type="text" name="surname" value="<?php echo $value_achternaam;?>"/><br />
    <label>Adres:</label> <input type="text" name="address" value="<?php echo $value_adres;?>"/><br />
    <label>Postcode:</label><input type="text" name="zipcode" value="<?php echo $value_postcode;?>"/><br />
    <label>Woonplaats:</label><input type="text" name="city" value="<?php echo $value_woonplaats;?>"/><br />
    <label>Telefoonnummer:</label><input type="text" name="telephone" value="<?php echo $value_telnr;?>"/><br />
    <input type="submit" name="form_submit" value="Wijzig"/>     
</form>

