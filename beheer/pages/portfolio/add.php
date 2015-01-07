<?php
//gemaakt door Willem.
if(isset($_POST['submit'])) {
    if (empty($_POST["naam"])) {
        $error = "Vul een naam in";     //als er geen naam ingevuld is wordt er een error getoond op net scherm.
    } else {
        $naam = post('naam');
        $query = "SELECT * FROM portfolio WHERE name='" . $naam . "'";
        $result = $mysqli->query($query);
        if ($result->num_rows == 0) {
            $query = "INSERT INTO portfolio (name) VALUES ('" . $naam . "')";   //de nieuwe naam wordt toegevoegd in de database en het portfolio is dan toegevoegd
            if (!$mysqli->query($query)) {
                echo $mysqli->error;
            } else {
                redirect('/beheer/portfolio/addPhoto/'.$mysqli->insert_id); //je wordt doorgestuurd naar addPhoto.php zodat je foto's kunt uploaden
            }
        }else{
            $error= "Deze naam bestaat al"; //als je een portfolio al een bestaande naam geeft wordt er op het scherm een error getoond.
            
        }
    }
}
?>
<a href="/beheer/portfolio" class="button">Terug naar overzicht</a>
<h1>Nieuwe album</h1>

<?php
if(isset($error)) {
    echo '<div class="alert-error">' . @$error . '</div>';
}
?>

<form method="post" action="">
    <label>Naam</label>
    <input type="text" name="naam" id="naam">
    <input type="submit" name="submit" value="album aanmaken">
</form>

<?php
//if (isset($_POST["submit"])){

    //}
?>