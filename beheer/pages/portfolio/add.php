<?php
if(empty($_POST["naam"])){
        $naam=post('naam');
        $error="vul een naam in";
        
}
echo @$error;

?>

<h1>Nieuwe album</h1>
<form method="post" action="">
    <label>Naam</label>
    <input type="text" name="naam" id="naam">
    <input type="submit" name="aanmaken" value="album aanmaken">
</form>

<?php
if (isset($_POST["submit"])){
        $query= "SELECT * FROM portfolio WHERE naam= \"$naam\"";
        $result = $mysqli->query($query);
        if($mysqli->query($query)->num_rows == 0) {
           $query= "INSERT INTO portfolio (naam) VALUES($naam)";
           if (!$mysqli->query($query)) {
                echo $mysqli->error;
            }else{
                redirect('/beheer/portfolio');
            }
        }
    }
?>