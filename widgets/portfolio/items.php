<?php
function portfolio_items(){
    $id = urlSegment(2);
    // dit zorgt ervoor dat de site weet welke portfolio hij de foto's uit moet halen
    $page = urlSegment(3);
    $itemsOnPage = getProp('Items_on_page');
    $itemsfetched = $itemsOnPage + 1;
    // dit kijkt op welke pagina je staat en hoeveel foto's erop moeten komen
    $max = $page * $itemsOnPage;

    global $mysqli;

    $result = $mysqli->query("SELECT * FROM photo WHERE portfolio_album = '".$id."' ORDER BY id DESC LIMIT $itemsfetched OFFSET $max");
    if($result->num_rows <= $itemsOnPage){

    }
    //dit haalt alle foto's op uit de database die op de pagina moeten worden laten zien

    $portfolio .= '<section style="width: 100%; min-height: 10px; overflow: hidden;">';
    if($result && $result->num_rows > 0){
        $i = 0;
        while($item = $result->fetch_object()){
            $i++;
            if($i <= $itemsOnPage){
                $portfolio .= '
            <figure>
                <a href="/thumb.php?photo='.$item->id.'&type=portfolio" data-lightbox="image-1"><img src="/thumb.php?photo='.$item->id.'&type=portfolio" alt="'.$item->name.'"/></a>
            </figure>
            ';
            }
        }
    }else{
        $portfolio = 'Dit album bevat geen foto\'s';
    }
    // dit laat de foto's zien als ze er zijn of geeft een bericht als er geen foto's zijn
    $portfolio .= '</section>';

    $portfolio .= '<section style="width: 100%; text-align: center; margin-top: 40px;">';

    if($page != 0 && $result->num_rows != 0)
        $portfolio .= '<a href="/'.urlSegment(1).'/'.urlSegment(2).'/'.($page - 1).'" class="pagination">Vorige</a>';
    // dit is de vorige knop
    if($result->num_rows > $itemsOnPage)
        $portfolio .= '<a href="/'.urlSegment(1).'/'.urlSegment(2).'/'.($page + 1).'" class="pagination">Volgende</a>';
    // dit is de volgende knop
    $portfolio .= '</section>';

    return $portfolio;
    
}