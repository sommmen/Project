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


$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/projects');
}

$project = $result->fetch_object();

$targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($project->id . $project->title) . '/';

if(isset($_POST['submit'])) {
    if (!isset($_POST['option'])) {
        echo '<div class="alert-error">U dient een optie te selecteren.</div>';
    } elseif ($_POST['option'] == 1) {
            removeDirectory($targerPath);

            if (!$mysqli->query("DELETE FROM photo WHERE pid = '" . $project->id . "'")) {
                echo $mysqli->error;
            }
            if (!$mysqli->query("DELETE FROM project WHERE id = '" . $project->id . "'")) {
                echo $mysqli->error;
            }
            setMessage('Project + foto\'s succesvol verwijderd.');
            redirect('/beheer/projects');
        } elseif ($_POST['option'] == 2) {
            $result = $mysqli->query("SELECT * FROM portfolio WHERE id = '" . post('portfolio') . "'");
            if ($result->num_rows > 0) {
                $portfolio = $result->fetch_object();

                $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($portfolio->id . $portfolio->name) . '/';

                if (rename($targerPath, $newPath)) {
                    $mysqli->query("UPDATE photo SET portfolio_album = '" . $portfolio->id . "', pid = '0' WHERE pid = '" . $project->id . "'");
                    $mysqli->query("DELETE FROM project WHERE id = '" . $project->id . "'");
                    setMessage('Het project is verwijderd en de foto\'s zijn verplaats naar portfolio album:' . $portfolio->name);
                    redirect('/beheer/projects');

                } else {
                    echo '<div class="alert-error">De map naam kan niet gewijzigd worden.</div>';
                }
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
