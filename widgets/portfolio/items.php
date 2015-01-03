<?php

function portfolio_items(){
    
    $id = urlSegment(2);
    
    global $mysqli;

    $result = $mysqli->query("SELECT * FROM photo WHERE portfolio_album = '".$id."' ORDER BY id DESC");

    if($result && $result->num_rows > 0){
        while($item = $result->fetch_object()){

            $portfolio .= '
            <figure>
                <a href="/thumb.php?photo='.$item->id.'&type=portfolio" data-lightbox="image-1"><img src="/thumb.php?photo='.$item->id.'&type=portfolio" alt="'.$item->name.'"/></a>
            </figure>
            ';
        }
    }else{
        $portfolio = 'Er zitten geen foto\'s in deze portfolio.';
    }
    
    return $portfolio;
    
}