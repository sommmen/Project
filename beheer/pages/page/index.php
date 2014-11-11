<?php

$query = "SELECT * FROM page";
$result = $mysqli->query($query);

print('<table><th>Titel</th><th>link</th><th>aangemaakt</th><th>laatst bewerkt</th><th>zichtbaar</th>');
while ($page = $result->fetch_object()) {
    print("<tr><td>$page->title</td><td>$page->slug</td><td>$page->created</td><td>$page->last_modified</td><td>$page->published</td></tr>");
}
print('</table>');