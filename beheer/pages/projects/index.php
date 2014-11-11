<table><th>Project Naam</th><th>Klant Naam</th><th>Datum</th><th>Acties</th>
<?php
$query = "SELECT * FROM projects";
$result = $mysqli->query($query);
    while ($page = $result->fetch_object()) {
         print("<tr><td>$page->title</td><td>$page->uid</td><td>$page->created</td><td><a href=\"/beheer/projects/edit/$page->id\">Edit</a>\<a href=\"/beheer/projects/delete/$page->id\">Delete</a></td></tr>");
    }
?>
</table>