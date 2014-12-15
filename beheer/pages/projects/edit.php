<?php

$query= "SELECT * FROM project WHERE uid = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $project=$result->fetc_object;


if(isset($_POST['submit'])){
    $targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($project->uid . $project->name) . '/';
    $result=$mysqli->query("UPDATE project SET title = '".$_POST['project_naam']."', uid = '".$_POST['project_klant']."', max = '".$_POST['project_max_photos']."' WHERE uid = '".$_POST['project_klant']."'");
    
    
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