<?php
minRole(3);

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
}


$query = "SELECT * FROM portfolio WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/portfolio');
}
$portfolio = $result->fetch_object();
$targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/';

removeDirectory($targerPath);
            
            
             if ($mysqli->query("DELETE FROM portfolio WHERE id = '" . $portfolio->id . "'")) {
                setMessage('Portfolio + foto\'s succesvol verwijderd.');
                redirect('/beheer/portfolio');
                
            }else{
                echo $mysqli->error;
            }
            if ($mysqli->query("DELETE FROM photo WHERE portfolio_album = '" . $portfolio->id . "'")) {
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
?>