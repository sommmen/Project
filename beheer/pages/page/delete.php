<?php

$id = get(); //nuja hoe je dan die /page/id pakt
$query = "DELETE FROM pages WHERE id = $id";

if (!$mysqli->query($query)) {
?>
<meta http-equiv="refresh" content="5; url=/page.php" />
<h1>Error, deze pagina bestaat niet of is reeds verwijderd.</h1>
<p> u wordt teruggestuurt. </p>
<?php
} else {
    redirect("page.php");
}

