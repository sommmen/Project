<?php

$id = urlSegment(3);
$query = "DELETE FROM pages WHERE id = $id";

if (!$mysqli->query($query)) {
?>
<meta http-equiv="refresh" content="5; url=/beheer/page" />
<h1 style="color: red; font-size: 200%; text-align: center;">Error, deze pagina bestaat niet of is reeds verwijderd.</h1>
<p style="text-align: center;"> u wordt teruggestuurt. </p>
<?php
} else {
    redirect("page.php");
}

