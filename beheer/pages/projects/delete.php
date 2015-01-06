<?php
/*
 * Door Kevin Pijning
 */
minRole(3);

/*
 * Deze functie zorgt er voor dat alle bestanden uit de map worden verwijderd, en daarna wordt de map verwijderd.
 * dit omdat het niet mogeijk is om een map te verwijderen als er nog bestanden in staan.
 */
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

//Laad het opgegeven project
$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){ // als het project niet bestaat, wordt de gebruiker doorgestuurd naar het project overzicht.
    redirect('/beheer/projects');
}

$project = $result->fetch_object();

//Verkrijg de map van het project.
$targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($project->id . $project->title) . '/';

if(isset($_POST['submit'])) {
    if (!isset($_POST['option'])) {
        echo '<div class="alert-error">U dient een optie te selecteren.</div>';
    } elseif ($_POST['option'] == 1) {
            /*
             * Optie 1 = project en foto's verwijderen.
             */

            removeDirectory($targerPath); // Verwijder bestanden + map

            //Verwijder foto's en project uit de database.
            if (!$mysqli->query("DELETE FROM photo WHERE pid = '" . $project->id . "'")) {
                echo $mysqli->error;
            }
            if (!$mysqli->query("DELETE FROM project WHERE id = '" . $project->id . "'")) {
                echo $mysqli->error;
            }
            //Maak succes bericht en stuur de gebruiker door naar het projecten overzicht.
            setMessage('Project + foto\'s succesvol verwijderd.');
            redirect('/beheer/projects');

        } elseif ($_POST['option'] == 2) {
            /*
             * Optie 2 = Verwijder project maar verplaats de foto's naar een portfolio album.
             */
            $result = $mysqli->query("SELECT * FROM portfolio WHERE id = '" . post('portfolio') . "'");
            if ($result->num_rows > 0) {
                $portfolio = $result->fetch_object();

                //Verkrijg de map naam van het gekoze portfolio album
                $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/';

                $query = $mysqli->query("SELECT * FROM photo WHERE pid = '".$project->id."'");

                //Foto's worden verplaats naar de map van het gekozen portfolio, en de database wordt bijgewerkt.
                while($photo = $query->fetch_object()){
                    if(rename($targerPath.$photo->file_name, $newPath.$photo->file_name)){
                        $mysqli->query("UPDATE photo SET portfolio_album = '" . $portfolio->id . "', pid = null WHERE pid = '" . $project->id . "'");
                        $mysqli->query("DELETE FROM project WHERE id = '" . $project->id . "'");
                        setMessage('Het project is verwijderd en de foto\'s zijn verplaats naar portfolio album:' . $portfolio->name);
                        redirect('/beheer/projects');
                    }else{
                        $error =' dikke error :S';
                    }
                }
                removeDirectory($targerPath); //de oude project map wordt verwijderd.

            } else {
                echo '<div class="alert-error">Het opgegeven portfolio album bestaat niet.</div>';
            }
        }
    }


?>
<a href="/beheer/projects" class="button red">Terug naar projecten</a>
<h1><?php echo 'Verwijder '.$project->title;?></h1>
<p>Wilt u het project + alle foto's verwijderen?</p>

<form action="" method="post">
    <input type="radio" name="option" value="1"/>  Verwijder project + foto's <br/><br/>
    <input type="radio" name="option" value="2"/>  Verwijder project, verplaats foto's naar portfolio album:

    <select name="portfolio">
        <?php
        $result = $mysqli->query("SELECT * FROM portfolio");
        while($album=$result->fetch_object()) {
            echo '<option value="'.$album->id.'">'.$album->name.'</option>';
        }
        ?>
    </select>
    <br/>
    <br/>
    <input type="submit" name="submit" value="Verwijderen"/>

</form>
