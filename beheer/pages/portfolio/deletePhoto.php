<?php
minRole(3);

//$query = "SELECT *, ph.id as photo_id FROM photo ph JOIN portfolio pr ON ph.pid = pr.id WHERE ph.id = '".urlSegment(3)."' LIMIT 1";

$query = "SELECT *, ph.id as photo_id FROM photo ph JOIN portfolio po ON ph.portfolio_album = po.id WHERE ph.id = '".urlSegment(3)."' LIMIT1";

$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/projects');
}
$photo = $result->fetch_object();

$targetImage = dirname(__FILE__).'/../../../../uploads/'.sha1($photo->id.$photo->title).'/'.$photo->file_name;

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
