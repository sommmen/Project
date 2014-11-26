<?php
minRole(3);

$query = "SELECT *, ph.portfolio_album as photo_portfolio_album FROM photo ph JOIN portfolio pr ON ph.portfolio_album = pr.portfolio_album WHERE ph.portfolio_album = '".urlSegment(3)."' LIMIT 1";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/portfolio');
}
$photo = $result->fetch_object();

$targetImage = dirname(__FILE__).'/../../../../uploads/'.sha1($photo->portfolio_album.$photo->name).'/'.$photo->file_name;

if(file_exists($targetImage) && is_file($targetImage)){
    if(unlink($targetImage)){
        $mysqli->query("DELETE FROM photo WHERE portfolio_album = '".$photo->photo_portfolio_album."'");
        redirect('/beheer/portfolio/view/'.$photo->portfolio_album);
    }else{
        redirect('/beheer/portfolio');
    }
}else{
     redirect('/beheer/portfolio');
}
