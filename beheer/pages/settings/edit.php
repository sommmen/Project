<?php
$query= "SELECT * FROM setting WHERE `key` = '".urlSegment(3)."'";
$result=$mysqli->query($query);
//dit haalt de instelling op die de admin wil veranderen
if($result->num_rows==1){
    $setting=$result->fetch_object();
    //dit kijkt of er 1 item wordt opgehaald zodat er niet onnodige/verkeerde instellingen worden opgehaald
    if(isset($_POST['submit'])) {
        //dit kijkt of de instellingen moeten worden verandert
        $value= post('value');
        $result = $mysqli->query("UPDATE setting SET value = '".$value."' WHERE `key` = '".$setting->key."'");
        //dit verandert de instelling in de database
        if(!$result){
            echo $mysqli->error;
        }else{
            setMessage("Instelling succesvol bijgewerkt.");
            redirect('/beheer/settings');
        }
        //dit kijkt of de verandering is gelukt
    }
?>
<a href="/beheer/settings" class="button">Terug naar overzicht</a>
<h1>Instellingen bewerken</h1>
<form method="post" action="">
    <label>sleutel</label>
    <input type="text" name="key" value="<?php echo $setting->key;?>" disabled="disabled">
    <label>waarde</label>
    <input type="text" name="value" value="<?php echo set_value("value", $setting->value);?>"><br>
    <br/>
    <input type="submit" name="submit" value="instellingen bewerken">
</form>

<?php
//dit laat de instelling zien met de huidige waarde en laat de admin de instelling veranderen
}else{
    echo "Deze instelling bestaat niet";
    // dit is te zien als de instelling niet bestaat
}
?>