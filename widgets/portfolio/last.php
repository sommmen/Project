<?php
// Daan Stout
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function portfolio_last(){
    
    
    
    global $mysqli;
    
    $result = $mysqli->query("SELECT * FROM photo WHERE portfolio_album IS NOT NULL ORDER BY id DESC LIMIT 3");
    // dit haalt de 3 nieuwste foto's op die in een portfolio staan
    if($result && $result->num_rows > 0){
        $portfolio .= '<section class="last-row">';
        while($item = $result->fetch_object()){
            $portfolio .= '
            <figure>    
                <a href="/portfolio-fotos/'.$item->portfolio_album.'"><img src="/thumb.php?photo='.$item->id.'&type=portfolio" alt="'.$item->name.'"/></a>
            </figure>
            ';
        }
        $portfolio .= '</section>';
    }else{
        $portfolio = 'Er zitten geen foto\'s in deze portfolio.';
    }
    //dit laat de 3 foto's zien op de pagina
    return $portfolio;
}