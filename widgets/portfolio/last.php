<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function portfolio_last(){
    
    
    
    global $mysqli;
    
    $result = $mysqli->query("SELECT * FROM photo WHERE portfolio_album IS NOT NULL ORDER BY id DESC LIMIT 3");
    
    if($result && $result->num_rows > 0){
        while($item = $result->fetch_object()){
            $portfolio .= '
            <figure>    
                <a href="/portfolio-fotos/'.$item->portfolio_album.'"><img src="/thumb.php?photo='.$item->id.'&type=portfolio" alt="'.$item->name.'"/></a>
            </figure>
            ';
        }
    }else{
        $portfolio = 'Er zitten geen foto\'s in deze portfolio.';
    }
    return $portfolio;
}