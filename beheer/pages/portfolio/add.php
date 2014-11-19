<?php
if(isset($_POST['submit'])) {
    if (empty($_POST["naam"])) {
        $error = "vul een naam in";
    } else {
        $naam = post('naam');
        $query = "SELECT * FROM portfolio WHERE name='" . $naam . "'";
        $result = $mysqli->query($query);
        if ($result->num_rows == 0) {
            $query = "INSERT INTO portfolio (name) VALUES ('" . $naam . "')";
            if (!$mysqli->query($query)) {
                echo $mysqli->error;
            } else {
                redirect('/beheer/portfolio/addPhoto/'.$mysqli->insert_id);
            }
        }else{
            $error= "deze naam bestaat al";
            
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
if (isset($_POST["submit"])){

    }
?>