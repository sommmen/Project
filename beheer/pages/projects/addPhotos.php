<?php
/*
 * Door Kevin Pijning
 */
minRole(3);

$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/projects');
}
$project = $result->fetch_object();

$ds          = DIRECTORY_SEPARATOR;  //1

$storeFolder = '../../../../uploads';   //2

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];    // Bestand naam van de geuploade foto
    $folderName = sha1($project->id.$project->title); //Maak een unieke folder aan voor een project aan de hand van het project id en de project naam
    $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds . $folderName . $ds; // Plaats waar de foto naartoe moet.
    if(!file_exists($targetPath)) { // Als deze plek niet bestaat, dan wordt er een map aangemaakt.
        mkdir($targetPath);
    }

    $targetFile = $targetPath . $_FILES['file']['name']; // plaats van de foto
    move_uploaded_file($tempFile, $targetFile); // Verplaats foto van tijdelijke map naar vaste map

    /*
     * In het volgende deel wordt de foto verkleind en er wordt een watermerk toegevoegd.
     */
    $imagePath = $targetPath . $targetFile;

    $fileExtention = strtolower(end(explode('.', $_FILES['file']['name'])));

    $stamp = imagecreatefrompng(dirname(__FILE__) . $ds . '../../res/img/mark3.png'); // plaats naar het watermerk plaatje

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
    // de margins voor het watermerk en krijg de hoogte en de breedte van het watermerk plaatje
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // krijg de hoogte en breedte van de foto zelf.
    $ix = imagesx($im);
    $iy = imagesy($im);

    /*
     * Als de foto breder is dan 720 px, wordt hij verkleind en geschaald.
     */
    if($ix > 720) {
        $newWidth = 720;
        $newHeight = (720 / $ix) * $iy;
    }else{
        $newWidth = $ix;
        $newHeight = $iy;
    }

    $thumb = imagecreatetruecolor($newWidth, $newHeight);

    //Verklein de foto
    imagecopyresized($thumb, $im, 0, 0, 0, 0, $newWidth, $newHeight, $ix, $iy);

    //Voeg watermerk toe
    imagecopy($thumb, $stamp, $newWidth - $sx - $marge_right, $newHeight - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

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

    //geheugen legen
    imagedestroy($im);

    //Foto wordt toegevoegd aan de database.
    $mysqli->query("INSERT INTO photo (name, file_name, pid)
                        VALUES ('".$_FILES['file']['name']."', '".$_FILES['file']['name']."', '".$project->id."')");


}


?>
<a href="/beheer/projects/view/<?php echo $project->id;?>" class="button green">Naar project &raquo;</a>


<h1>Foto's toevoegen aan project: <?php echo $project->title;?></h1>

<form action="/beheer/projects/addPhotos/<?php echo urlSegment(3);?>" class="dropzone" id="my-awesome-dropzone">

</form>

