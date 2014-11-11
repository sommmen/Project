<table><th>Project Naam</th><th>Klant Naam</th><th>Datum</th><th>Acties</th>
<?php
$query = "SELECT * FROM projects";
$result = $mysqli->query($query);
    while ($page = $result->fetch_object()) {
         print("<tr><td>$page->project_name</td><td>$page->user_name</td><td>$page->date_created</td><td>$page->actions</td><td><a href=\"/beheer/page/edit/$page->id\">Edit</a>\<a href=\"/beheer/page/delete/$page->id\">Delete</a></td></tr>");
    }
?>
</table>