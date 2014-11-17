<?php
minRole(3);

$id = urlSegment(3);

if(!is_numeric($id)){ ?>
<meta http-equiv="refresh" content="5; url=/beheer/page" />
<h1 style="color: red; font-size: 200%; text-align: center;">Error, er is iets misgegaan.</h1>
<p style="text-align: center;"> u wordt teruggestuurt. </p>
<?php }

$check = $mysqli->query("SELECT * FROM page WHERE id = $id");
$num_rows = $check->num_rows;

if ($num_rows <= 0) { ?>
<meta http-equiv="refresh" content="5; url=/beheer/page" />
<h1 style="color: red; font-size: 200%; text-align: center;">Error, deze pagina bestaat niet of is reeds verwijderd.</h1>
<p style="text-align: center;"> u wordt teruggestuurt. </p>
<?php } else {
    $mysqli->query("DELETE FROM page WHERE id = $id");
    redirect("/beheer/page");
}

