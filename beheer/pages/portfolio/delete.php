<?php
//gemaakt door Willem.
minRole(3); //je moet admin zijn om dit te mogen zien.

function removeDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
    //zorgt ervoor dat alle bestanden uit de map verwijderd worden en dat daarna de map zelf verwijderd wordt.
}


$query = "SELECT * FROM portfolio WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/portfolio');
}
$portfolio = $result->fetch_object();
$targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/'; //kijkt welke foto's in het album zit.

removeDirectory($targerPath); //de foto's worden verwijderd uit de foto's. Dus zowel het album en de foto's worden verwijderd.
            
            
             if ($mysqli->query("DELETE FROM portfolio WHERE id = '" . $portfolio->id . "'")) { //het album wordt verwijderd uit de database en dus ook van de website.
                setMessage('Portfolio + foto\'s succesvol verwijderd.');
                redirect('/beheer/portfolio');
                
            }else{
                echo $mysqli->error;
            }
            if ($mysqli->query("DELETE FROM photo WHERE portfolio_album = '" . $portfolio->id . "'")) { //de foto's worden uit de database verwijderd.
                setMessage('Portfolio + foto\'s succesvol verwijderd.');
                redirect('/beheer/portfolio');
            }else{
                echo $mysqli->error;
            }
             
            
if (!$mysqli->query($query)) {
?>
<meta http-equiv="refresh" content="5; url=/beheer/portfolio" />
<h1 style="color: red; font-size: 200%; text-align: center;"> Er is iets misgegaan.</h1>
<p style="text-align: center;"> U wordt teruggestuurd. </p>
<?php
} else {
    redirect("/beheer/portfolio/");
}
//dit wordt getoond als er iets misgegaan is met het verwijderen of al is verwijderd.
?>