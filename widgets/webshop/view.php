<?php

function webshop_view(){
    $oypo=  '<iframe 
        src="http://www.oypo.nl/pixxer/api/templates/0801.asp?id=C66C105534D76A47&wl=michaelverbeek"
        name="pixxerframe" id="pixxerframe" 
        width="100%" height="400" 
        marginwidth="0" marginheight="0" 
        frameborder="0" 
        scrolling="auto">
        </iframe>
        <script src="http://www.oypo.nl/pixxer/api/iframeheight.js" type="text/javascript" language="javascript"></script>';

    return $oypo;
    
}
