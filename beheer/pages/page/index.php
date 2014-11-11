

<table>
    <tr>
        <th>Titel</th>
        <th>link</th>
        <th>Laatst bewerkt</th>
        <th>zichtbaar</th>
        <th>Acties</th>
    </tr>
<?php
$query = "SELECT * FROM page";
$result = $mysqli->query($query);
    while ($page = $result->fetch_object()) {
        if($page->published == 1){
            $published = "ja";
        } else {
            $published = "nee";
        }
        //TODO als er geen pagina's zijn, dan moet er een melding worden gegeven dat er geen pagina's zijn.
        ?>
    <tr>
        <td><?php echo $page->title;?></td>
        <td><?php echo $page->slug;?></td>
        <td><?php echo $page->last_modified;?></td>
        <td><?php echo $published;?></td>
        <td>
            <a href="/beheer/page/edit/<?php echo $page->id;?>"><img src="/beheer/res/img/pencil90.png" alt="edit"/></a> |
            <a href="/beheer/page/delete/<?php echo $page->id;?>" onClick="return confirm('Weet je zeker dat je deze pagina wilt verwijderen?')"><img src="/beheer/res/img/black393.png" alt="edit"/></a>
        </td>
    </tr>
    <?php
    // dit is kut, en voor de rest moeilijk te begrijpen.
    //print("<tr><td>$page->title</td><td>$page->slug</td><td>$page->created</td><td>$page->last_modified</td><td>$published</td><td><a href=\"/beheer/page/edit/$page->id\">Edit</a>\<a href=\"/beheer/page/delete/$page->id\" onClick = \"return confirm('weet je het zeker? verwijderen is definitief')\">Delete</a></td></tr>");
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
//TODO als je nu F5 drukt nadat je een pagina hebt toegevoegd, voegt hij de zelfde pagina weer toe.
//TODO checken of de page slug al bestaat of niet.
//TODO liefst gwn een normale pagina toevoegen pagina, zodat je alles in 1 keer kan invullen. HEURISTIEKEN VAN NIELSONNAZI?

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
