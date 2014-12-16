<?php
$query= "SELECT * FROM portfolio WHERE id = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $portfolio=$result->fetch_object();
    if(isset($_POST['submit'])) {
        
        $targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/';
        $name= post('naam');
        $result = $mysqli->query("UPDATE portfolio SET name = '".$name."' WHERE id = '".$portfolio->id."'");
        
        $result = $mysqli->query("SELECT * FROM portfolio WHERE id = '" . $portfolio->id . "'");
            if ($result->num_rows > 0) {
                $portfolio = $result->fetch_object();

                $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/';
                rename($targerPath, $newPath);
            }
        if($result){
            setMessage("Album succesvol bijgewerkt.");
            redirect('/beheer/projects');   
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
