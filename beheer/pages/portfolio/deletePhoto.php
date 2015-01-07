<?php
minRole(3);

//gemaakt door Dion.

//laad de opgevraagde foto
$query = "SELECT *, ph.id as photo_id FROM photo ph LEFT JOIN portfolio po ON ph.portfolio_album = po.id WHERE ph.id = '".urlSegment(3)."' LIMIT 1";

$result = $mysqli->query($query);
echo $mysqli->error;
if($result->num_rows == 0){ // Als het foto ID niet bestaat, wordt de gebruiker doorgestuurd naar het projecten overzicht.
    redirect('/beheer/portfolio');
}
$photo = $result->fetch_object();
//Verkrijg de plaats waar de foto staat.
$targetImage = dirname(__FILE__).'/../../../../uploads/'.sha1($photo->id.$photo->name).'/'.$photo->file_name;

//Als de foto bestaat, wordt hij verwijderd. Als hij niet bestaat wordt de gebruiker doorgestuurd naar het projecten overzicht.
if(file_exists($targetImage) && is_file($targetImage)){
    if(unlink($targetImage)){
        $mysqli->query("DELETE FROM photo WHERE id = '".$photo->photo_id."'");
        redirect('/beheer/portfolio/view/'.$photo->id);
    }else{
        redirect('/beheer/portfolio');
    }
}else{
     redirect('/beheer/portfolio');
}
