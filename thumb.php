<?php
session_start();
ob_start();
require_once('system/core.php');

if(isset($_GET['photo']) && isset($_GET['type'])){
    $photo_id = get('photo');

    $query = "SELECT * FROM photo WHERE id = '".$photo_id."'";
    $result = $mysqli->query($query);
    if($result->num_rows > 0){
        $photo = $result->fetch_object();

        if(get('type') == 'project') {
            minRole(2);

            $query = "SELECT * FROM project p WHERE id = '" . $photo->pid . "'";
            if (!$result = $mysqli->query($query)) {
                echo $mysqli->error;
            }
            $project = $result->fetch_object();

            if($project->uid == user_data('id') || user_data('role') == 3){
                $folderName = sha1($project->id . $project->title);
            }


        }elseif(get('type') == 'portfolio'){
            $query = "SELECT * FROM portfolio WHERE id = '" . $photo->portfolio_album . "'";
            if (!$result = $mysqli->query($query)) {
                echo $mysqli->error;
            }
            if($result->num_rows > 0){
            $portfolio = $result->fetch_object();

            $folderName = sha1($portfolio->id . $portfolio->name);
            } else {
                echo "Afbeelding kan niet geladen worden.";
                return false;
            }
        }
        $imagePath = '../uploads/'.$folderName.'/'.$photo->file_name;
        $fileExtention = strtolower(end(explode('.', $photo->file_name)));

        if(file_exists($imagePath) && is_file($imagePath)) {

            switch ($fileExtention) {
                case "jpg";
                case "jpeg";
                    header('Content-Type: image/jpeg');
                    $im = imagecreatefromjpeg($imagePath);
                    imagejpeg($im);
                    break;
                case 'png':
                    header('Content-Type: image/png');
                    $im = imagecreatefrompng($imagePath);
                    imagepng($im);
                    break;
                case 'gif';
                    header('Content-Type: image/gif');
                    $im = imagecreatefromgif($imagePath);
                    imagegif($im);
                    break;
                default:
                    echo "niks";
                    break;
            }

            imagedestroy($im);
        } else {
            redirect('/');
        }
    }else{
        redirect('/');
    }

}
