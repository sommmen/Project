

<table><th>Titel</th><th>link</th><th>aangemaakt</th><th>laatst bewerkt</th><th>zichtbaar</th>
<?php
$query = "SELECT * FROM page";
$result = $mysqli->query($query);
    while ($page = $result->fetch_object()) {
        if($page->published == 1){
            $published = "ja";
        } else {
            $published = "nee";
        }
    print("<tr><td>$page->title</td><td>$page->slug</td><td>$page->created</td><td>$page->last_modified</td><td>$published</td></tr>");
}
?>
</table>
<select name="carlist" form="form">
<?php
    while ($page = $result->fetch_object()) {
        print("<option value=\"$page->title\">$page->title</option>");
    }
?>
</select>
<form action="/page.php" method="post" id="form">
    <input type="submit" name="submit">
</form>
