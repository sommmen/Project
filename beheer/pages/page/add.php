<?php
minRole(3);
?>
<script type="text/javascript" src="javascript/slug.js"></script>

<a href="/beheer/page" class="button">Terug naar overzicht</a>
<h1>Nieuwe pagina</h1>
<form action="" method="post">
    <label>Titel</label>
    <input type="text" name="titel" onkeyup="updateValue()" id="title">
    <label>Onderschrift</label>
    <input type="text" name="description">
    <label>Doelmap</label>
    <input type="text" name="slug" value="" id="slug">
    <label>Tekst</label>
    <textarea rows="4" cols="50" name="body"></textarea>

    <input type="submit" name="submit" value="versturen">
</form>

<?php
//TODO als je nu F5 drukt nadat je een pagina hebt toegevoegd, voegt hij de zelfde pagina weer toe.
//TODO checken of de page slug al bestaat of niet. moet met ajax???
//TODO liefst gwn een normale pagina toevoegen pagina, zodat je alles in 1 keer kan invullen. HEURISTIEKEN VAN NIELSONNAZI?

if (isset($_POST["submit"])) {
    if (!empty($_POST["titel"])) {
        $titel = post('titel');
        $description = post('description');
        $body = post('body');
        $slug = urlencode(strtolower(post('slug')));

        $query = "SELECT * FROM page WHERE slug = \"$slug\"";
        $result = $mysqli->query($query);
        if ($mysqli->query($query)->num_rows == 0) {
            if($mysqli->query("SELECT COUNT(*) FROM page WHERE title = '$titel' AND description = '$description' AND body = '$body' AND slug = '$slug' ") > 0){
                redirect('/beheer/page');
            }
            $query = "INSERT INTO page (title, slug, published, in_nav, description, body) VALUES (\"$titel\",\"$slug\", 0, 0, \"$description\", \"$body\")";
            if (!$mysqli->query($query)) {
                echo $mysqli->error;
            }else{
                redirect('/beheer/page');
            }
        } else {
            echo "vul een titel in.";
        }
    }
}
