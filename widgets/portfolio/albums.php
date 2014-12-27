<?php

/*
een widget moet altijd een functie bevatten die net zo heet als de Widget tag
bijv. tag: {{ portfolio_albums }}, functie naam: portfolio_albums.

je mag NOOIT echo/print gebruiken in een functie.
Als je dit wel doet, dan wordt de text die je wilt latenzien boven de pagina getoond, en dat willen we niet.
dus gewoon return.

Je kan hele html strings returne, dus dat is geen probleem.

Als je iets met mysql wilt doen in een widget, moet je altijd "global $mysqli;" gebruiken, anders zal het niet werken.

*/

function portfolio_albums(){
    global $mysqli;
    $X = urlSegment(3) * 10;
    $Y = $X + 10;
    
    $result = $mysqli->query("SELECT * FROM portfolio ORDER BY id DESC LIMIT ".$X.", ".$Y);
    
    while($item = $result->fetch_object()){
        $portfolio .= '
        <figure>
            <a href="/portfolio-fotos/'.$item->id.'">
                <img id="thumb" src="/thumb.php?photo='.$item->prev_photo.'&type=portfolio" alt="'.$item->name.'"/>
                <figcaption>'.$item->name.'</figcaption>
            </a>
        </figure>
        ';
    }
    $portfolio .= '<a href="/portfolioItem/1/'.urlSegment(3)+1 .'">Next</a>';
    //* hi *//
    return $portfolio;

}



