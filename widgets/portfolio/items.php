<?php
function portfolio_items(){
    $id = urlSegment(2);

    $page = urlSegment(3);
    $itemsOnPage = 9;

    $max = $page * $itemsOnPage;

    global $mysqli;

    $result = $mysqli->query("SELECT * FROM photo WHERE portfolio_album = '".$id."' ORDER BY id DESC LIMIT $itemsOnPage OFFSET $max");
    if($result->num_rows <= $itemsOnPage){

    }


    $portfolio .= '<section style="width: 100%; min-height: 10px; overflow: hidden;">';
    if($result && $result->num_rows > 0){
        while($item = $result->fetch_object()){

            $portfolio .= '
            <figure>
                <a href="/thumb.php?photo='.$item->id.'&type=portfolio" data-lightbox="image-1"><img src="/thumb.php?photo='.$item->id.'&type=portfolio" alt="'.$item->name.'"/></a>
            </figure>
            ';
        }
    }else{
        $portfolio = 'Dit album bevat geen foto\'s';
    }
    $portfolio .= '</section>';

    $portfolio .= '<section style="width: 100%; text-align: center; margin-top: 40px;">';

    if($page != 0 && $result->num_rows != 0)
        $portfolio .= '<a href="/'.urlSegment(1).'/'.urlSegment(2).'/'.($page - 1).'" class="pagination">Vorige</a>';

    if($result->num_rows <= $itemsOnPage)
        $portfolio .= '<a href="/'.urlSegment(1).'/'.urlSegment(2).'/'.($page + 1).'" class="pagination">Volgende</a>';

    $portfolio .= '</section>';

    return $portfolio;
    
}