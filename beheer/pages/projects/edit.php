<?php

$query= "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $project=$result->fetch_object();


if(isset($_POST['submit'])){
    $targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($project->id . $project->title) . '/';
    $result=$mysqli->query("UPDATE project SET title = '".$_POST['project_naam']."', uid = '".$_POST['project_klant']."', max = '".$_POST['project_max_photos']."' WHERE id = '".$project->id."'");
    
    $result = $mysqli->query("SELECT * FROM project WHERE id = '" . $project->id . "'");
            if ($result->num_rows > 0) {
                $projects = $result->fetch_object();

                $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($projects->id . $projects->title) . '/';
                rename($targerPath, $newPath);
            }
        if($result){
            setMessage("Project succesvol bijgewerkt.");
            redirect('/beheer/project');   
        }else{
            echo $mysqli->error;
        }
    
}

?>
<a href="/beheer/project" class="button">Terug naar overzicht</a>
<h1>Project aanpassen</h1>
<form method="post" action="">
    <label>Project naam:</label>
    <input type="text" name="project_naam" value="<?php $project->title; ?>">
    <label>Aangewezen klant:</label>
    <input type="text" name="project_klant" value="<?php $project->uid ?>">
    <label>Max foto's</label>
    <input type="text" name="project_max_photos" value="<?php $project->max ?>">
    <input type="submit" name="verzenden" value="project aanpassen">
</form>

<?php
}
?>