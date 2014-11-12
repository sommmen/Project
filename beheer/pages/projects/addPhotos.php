<?php
minRole(3);
/*
$ds          = DIRECTORY_SEPARATOR;  //1

$storeFolder = '../../../uploads';   //2

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];          //3

    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4

    $targetFile =  $targetPath. $_FILES['file']['name'];  //5

    move_uploaded_file($tempFile,$targetFile); //6
}*/

$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/projects');
}
$project = $result->fetch_object();

?>
<h1>Foto's toevoegen aan project: <?php echo $project->title;?></h1>
<form action="/beheer/projects/addPhotos/<?php echo urlSegment(3);?>" class="dropzone">
</form>

<a href="/beheer/projects/view/<?php echo $project->id;?>" class="button">Terug</a>

