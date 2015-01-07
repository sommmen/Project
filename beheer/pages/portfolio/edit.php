<?php
//gemaakt door Willem.
$query= "SELECT * FROM portfolio WHERE id = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $portfolio=$result->fetch_object();
    if(isset($_POST['submit'])) {
        
        $targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/'; //kijkt welke foto's in het album zit.
        $name= post('naam');
        $result = $mysqli->query("UPDATE portfolio SET name = '".$name."' WHERE id = '".$portfolio->id."'"); //de naam van het album wordt geupdate
        
        $result = $mysqli->query("SELECT * FROM portfolio WHERE id = '" . $portfolio->id . "'");
            if ($result->num_rows > 0) {
                $portfolio = $result->fetch_object();

                $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/'; //kijkt wat de directory van het portfolio is.
                rename($targerPath, $newPath); //de targerPath wordt newPath zodat alle foto's naar de nieuwe map gestuurd worden.
            }
        if($result){
            setMessage("Album succesvol bijgewerkt."); //als het succesvol geupdate is wordt dit bericht op de pagina getoon en wordt je teruggestuurd naar de index file van portfolio.
            redirect('/beheer/portfolio');   
        }else{
            echo $mysqli->error;
        }
    }
?>
<a href="/beheer/portfolio" class="button">Terug naar overzicht</a>
<h1>Album naam aanpassen</h1>
<form method="post" action="">
    <label>naam</label>
    <input type="text" name="naam" id="naam" value="<?php echo $portfolio->name;?>">
    <input type="submit" value="Bijwerken" name="submit">
</form>
<?php

}
?>
