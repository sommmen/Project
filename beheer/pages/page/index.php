

<table><th>Titel</th><th>link</th><th>aangemaakt</th><th>laatst bewerkt</th><th>zichtbaar</th><th></th>
<?php
$query = "SELECT * FROM page";
$result = $mysqli->query($query);
    while ($page = $result->fetch_object()) {
        if($page->published == 1){
            $published = "ja";
        } else {
            $published = "nee";
        }
    print("<tr><td>$page->title</td><td>$page->slug</td><td>$page->created</td><td>$page->last_modified</td><td>$published</td><td><a href=\"/beheer/page/edit/$page->id\">Edit</a>\<a href=\"/beheer/page/delete/$page->id\" onClick = \"return confirm('weet je het zeker? verwijderen is definitief')\">Delete</a></td></tr>");
}
?>
</table>
<br>
<h1>Nieuwe pagina</h1>
<form action="" method="post">
    <label>Titel</label>
    <input type="text" name="titel">
    <input type="submit" name="submit" value="versturen">
</form>

<?php
    if(isset($_POST["submit"])){
        if(!empty($_POST["titel"])){
        $titel = post(titel);
        $slug = urlencode(strtolower($titel));
        $query = "INSERT INTO page (title, slug, published, in_nav) VALUES (\"$titel\",\"$slug\", 0, 0)";
        if (!$mysqli->query($query)){
             echo $mysqli->error;
        }
        } else {
            echo "vul een titel in.";
        }
    }
