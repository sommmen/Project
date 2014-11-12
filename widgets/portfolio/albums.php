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

    $portfolio = '<ul>';


    $portfolio .= '
    <li>
        <figure>
            <img src="#" alt="name"/>
            <figcaption>Album naam</figcaption>
        </figure>
    </li>
    ';

    $portfolio .= '</ul>';

    return $portfolio;

}



