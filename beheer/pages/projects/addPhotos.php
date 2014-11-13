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

    $fileExtention = strtolower(end(explode('.', $_FILES['file']['name'])));

    $stamp = imagecreatefrompng(dirname(__FILE__) . $ds . '../../res/img/mark3.png');

    switch ($fileExtention) {
        case "jpg";
        case "jpeg";
            $im = imagecreatefromjpeg($targetFile);
            break;
        case 'png':
            $im = imagecreatefrompng($targetFile);
            break;
        case 'gif';
            $im = imagecreatefromgif($targetFile);
            break;
        default:
            echo "niks";
            break;
    }




    // Set the margins for the stamp and get the height/width of the stamp image
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    //$ix = imagesx($im);
    $ix = imagesx($im);
    $iy = imagesy($im);

    if($ix > 720) {
        $newWidth = 720;
        $newHeight = (720 / $ix) * $iy;
    }else{
        $newWidth = $ix;
        $newHeight = $iy;
    }

    $thumb = imagecreatetruecolor($newWidth, $newHeight);

    imagecopyresized($thumb, $im, 0, 0, 0, 0, $newWidth, $newHeight, $ix, $iy);

    imagecopy($thumb, $stamp, $newWidth - $sx - $marge_right, $newHeight - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));



    // Output and free memory
    switch ($fileExtention) {
        case "jpg";
        case "jpeg";
            imagejpeg($thumb, $targetFile);
            break;
        case 'png':
            imagepng($thumb, $targetFile);
            break;
        case 'gif';
            imagegif($thumb, $targetFile);
            break;
        default:
            echo "niks";
            break;
    }


    imagedestroy($im);

    $mysqli->query("INSERT INTO photo (name, file_name, pid)
                        VALUES ('".$_FILES['file']['name']."', '".$_FILES['file']['name']."', '".$project->id."')");


}


?>
<a href="/beheer/projects/view/<?php echo $project->id;?>" class="button green">Naar project &raquo;</a>


<h1>Foto's toevoegen aan project: <?php echo $project->title;?></h1>

<form action="/beheer/projects/addPhotos/<?php echo urlSegment(3);?>" class="dropzone" id="my-awesome-dropzone">

</form>

