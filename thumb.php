<?php
session_start();
ob_start();
/*
 * Door Kevin Pijning
 */

require_once('system/core.php');

/*
 * Dit script laad de foto's, omdat de foto's zelf niet van buitenaf beschikbaar zijn.
 */
if(isset($_GET['photo']) && isset($_GET['type'])){
    $photo_id = get('photo');

    $query = "SELECT * FROM photo WHERE id = '".$photo_id."'";
    $result = $mysqli->query($query);
    if($result->num_rows > 0){
        $photo = $result->fetch_object();

        if(get('type') == 'project') {
            /*
             * Als de gebruiker niet is ingelogd dan kunnen project foto's niet weergegeven worden.
             */
            minRole(2);


            $query = "SELECT * FROM project p WHERE id = '" . $photo->pid . "'";
            if (!$result = $mysqli->query($query)) {
                echo $mysqli->error;
            }
            $project = $result->fetch_object();

            //Als de foto niet van iemand is, kan de foto ook niet worden weergegeven. ten zij de foto benaderd wordt vanaf een admin account.
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

        //Laad de plaats naar de foto
        $imagePath = '../uploads/'.$folderName.'/'.$photo->file_name;
        $fileExtention = strtolower(end(explode('.', $photo->file_name)));

        /*
         * Als de foto bestaat dan wordt de extentie gecontrolleerd om zo een image object aan te maken met de juiste extentie.
         * Hier worden ook de foto's uiteindelijk weergegeven
        */
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
            //Geheugen opschonen
            imagedestroy($im);
        } else {
            redirect('/');
        }
    }else{
        redirect('/');
    }
    //Als er iets niet in orde is, dan wordt de gebruiker automatisch doorgestuurd naar de homepage van de website.

}
