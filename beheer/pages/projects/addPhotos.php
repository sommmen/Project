<?php
minRole(3);
/*

}*/

$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/projects');
}
$project = $result->fetch_object();

$ds          = DIRECTORY_SEPARATOR;  //1

$storeFolder = '../../../../uploads';   //2

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];
    $folderName = sha1($project->id.$project->title); //Maak een unieke folder aan voor een project.
    $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds . $folderName . $ds;
    if(!file_exists($targetPath)) {
        mkdir($targetPath);
    }
    $targetFile = $targetPath . $_FILES['file']['name'];
    move_uploaded_file($tempFile, $targetFile);

    $imagePath = $targetPath . $targetFile;
    //$image = imagecreatefrompng($imagePath);
    //$watermark = imagecreatefromjpg('../../res/img/michaelverbeek-watermark.jpg');

    $stamp = imagecreatefrompng(dirname(__FILE__) . $ds . '../../res/img/mark3.png');
    $im = imagecreatefrompng($targetFile);

    // Set the margins for the stamp and get the height/width of the stamp image
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // Copy the stamp image onto our photo using the margin offsets and the photo
    // width to calculate positioning of the stamp.

    imagealphablending($stamp, false);
    imagesavealpha($stamp, true);
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

    // Output and free memory

    imagepng($im, $targetFile);
    imagedestroy($im);


}


?>
<a href="/beheer/projects/view/<?php echo $project->id;?>" class="button">Terug naar project</a>


<h1>Foto's toevoegen aan project: <?php echo $project->title;?></h1>

<form action="/beheer/projects/addPhotos/<?php echo urlSegment(3);?>" class="dropzone">
</form>

