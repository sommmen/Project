<?php

minRole(3);
?>
<script type="text/javascript" src="javascript/slug.js"></script>
<script type="text/javascript">
    function showIn_nav() {
        if (document.getElementById('in_nav-checkbox').checked === true) {
            document.getElementById('in_nav-number').style.display = "initial";
            document.getElemntById('in_nav-text').innerHTML = "navigatievolgorde";
        } else {
            document.getElemntById('in_nav-text').innerHTML = "in navigatie?";
            document.getElementById('in_nav-number').style.display = "none";
            document.getElementById('in_nav-number').value = "0";
        }
    }
</script>

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
    <label>publiceren</label>
    <input type="checkbox" name="publish" value="1">
    <label id="in_nav-text">in navigatie?</label>
    <input id="in_nav-checkbox" type="checkbox" name="in_nav-checkbox" value="0" onchange="showIn_nav()">
    <input id="in_nav-number" type="number" name="in_nav-number" value="0" style="display: none;">
    <br>
    <input type="submit" name="submit" value="versturen">
</form>

<?php
if (isset($_POST["submit"])) {
    if (!empty($_POST["titel"])) {
        if (!empty($_POST["body"])) {
            if (!(empty($_POST['slug']) || $mysqli->query("SELECT * FROM page WHERE slug = '$slug'")->num_rows > 0)) {
                $titel = post('titel');
                $description = post('description');
                $body = post('body');
                $slug = urlencode(strtolower(post('slug')));
                if (post('publish') == 1) {
                    $published = 1;
                } else {
                    $published = 0;
                }
                if (post('in_nav-checkbox') == 1) {
                    $in_nav = post('in_nav-number');
                } else {
                    $in_nav = 0;
                }

                $query = "SELECT * FROM page WHERE slug = \"$slug\"";
                $result = $mysqli->query($query);
                if ($mysqli->query($query)->num_rows == 0) {
                    if ($mysqli->query("SELECT COUNT(*) FROM page WHERE title = '$titel' AND description = '$description' AND body = '$body' AND slug = '$slug' ") > 0) {
                        redirect('/beheer/page');
                    }
                    $query = "INSERT INTO page (title, slug, published, in_nav, description, body) VALUES (\"$titel\",\"$slug\", \"$published\", \"$in_nav\", \"$description\", \"$body\")";
                    if (!$mysqli->query($query)) {
                        echo $mysqli->error;
                    } else {
                        redirect('/beheer/page');
                    }
                }
            } else {
                echo "Deze doelmap bestaat al.";
            }
        } else {
            echo "Vul text in.";
        }
    } else {
        echo "Vul een titel in.";
    }
}
