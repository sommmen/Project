<?php

function portfolio_items(){
    
    return urlSegment(2);
    
    global $mysqli;

    $result = $mysqli->query("SELECT * FROM photo WHERE pid = '".$id."'");
    
    if($result){
        while($item = $result->fetch_object()){
            $portfolio .= '
            <figure>
                <img src="/thumb.php?photo='.$item->id.'&type=portfolio" alt="'.$item->name.'"/>
            </figure>
            ';
        }
    }else{
        $portfolio = 'Er zitten geen foto\'s in deze portfolio.';
    }
    
    return $portfolio;
    
}