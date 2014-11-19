<?php
$query= "SELECT * FROM setting WHERE `key` = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $setting=$result->fetch_object();
    if(isset($_POST['submit'])) {
        
        $value= post('value');
        $result = $mysqli->query("UPDATE setting SET value = '".$value."' WHERE `key` = '".$setting->key."'");
        if(!$result){
            echo $mysqli->error;
        }else{
            setMessage("Instelling succesvol bijgewerkt.");
            redirect('/beheer/settings');
        }
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
}else{
    echo "Deze instelling bestaat niet";
}
?>