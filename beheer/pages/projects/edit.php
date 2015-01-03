<?php

$query= "SELECT * FROM project  WHERE id = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $project=$result->fetch_object();


if(isset($_POST['verzenden'])){
    $targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($project->id . $project->title) . '/';


        $result = $mysqli->query("UPDATE project SET title = '" . $_POST['project_naam'] . "', max = '" . $_POST['project_max_photos'] . "' WHERE id = '" . $project->id . "'");
        $result = $mysqli->query("SELECT * FROM project WHERE id = '" . $project->id . "'");
        if ($result->num_rows > 0) {
            $projects = $result->fetch_object();

            $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($projects->id . $projects->title) . '/';
            rename($targerPath, $newPath);
        }
        if ($result) {
            setMessage("Project succesvol bijgewerkt.");
            redirect('/beheer/projects/');
        } else {
            echo $mysqli->error;
        }

}

?>
<a href="/beheer/projects" class="button">Terug naar overzicht</a>
<h1>Project aanpassen</h1>
<form method="post" action="">
    <label>Project naam:</label>
    <input type="text" name="project_naam" value="<?php echo $project->title; ?>">
    <label>Max foto's</label>
    <input type="number" name="project_max_photos" value="<?php echo $project->max; ?>"><br><br>
    <input type="submit" name="verzenden" value="project aanpassen">
</form>

<?php
}
?>