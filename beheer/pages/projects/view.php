<?php
minRole(3);

$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
//if($result->num_rows == 0){
//    redirect('/beheer/projects');
//}
//$project = $result->fetch_object();
echo urlSegment(3);
?>
<a href="/beheer/projects" class="button">Terug naar overzicht</a>
<a href="/beheer/projects/addPhotos/<?php echo $project->id;?>" class="button blue">Foto's toevoegen</a>