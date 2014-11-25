<?php

minRole(3);

if (isset($_POST["submit"])) {
    if (!empty($_POST["titel"])) {
        if (!empty($_POST["body"])) {
            if (!(empty($_POST['slug']) || $mysqli->query("SELECT * FROM page WHERE slug = '$slug'")->num_rows > 0)) {
                $titel = post('titel');
                $description = post('description');
                $body = addslashes($_POST['body']);
                $slug = urlencode(strtolower(post('slug')));

                if (post('publish') == 1) {
                    $published = 1;
                } else {
                    $published = 0;
                }
                if (isset($_POST['in_nav-checkbox'])) {
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
                $error = "Deze doelmap bestaat al.";
            }
        } else {
            $error = "Vul text in.";
        }
    } else {
        $error = "Vul een titel in.";
    }
}
?>


<a href="/beheer/page" class="button">Terug naar overzicht</a>
<h1>Nieuwe pagina</h1>
<?php
if(isset($error)) {
    echo '<div class="alert-error">' . @$error . '</div>';
}
?>
<form action="" method="post">
    <section class="row">
        <section class="half">
            <label>Titel</label>
            <input type="text" name="titel" onkeyup="updateValue()" id="title" value="<?php echo set_value("titel"); ?>">
            <label>Onderschrift</label>
            <input type="text" name="description" value="<?php echo set_value("description"); ?>">
            <label>Link</label>
            <input type="text" name="slug" value="<?php echo set_value("slug"); ?>" id="slug">
        </section>
        <section class="half">
            <label>publiceren</label>
            <input type="checkbox" name="publish" value="1" <?php if(isset($_POST['publish'])) { echo 'checked'; } ?>>
            <label id="in_nav-text">in navigatie?</label>
            <input id="in_nav-checkbox" type="checkbox" name="in_nav-checkbox" value="0" onchange="showIn_nav()" <?php if(isset($_POST['in_nav-checkbox'])) { echo 'checked'; } ?>>
            <input id="in_nav-number" type="number" name="in_nav-number" value="<?php echo set_value("in_nav-number",0); ?>"  <?php if(isset($_POST['in_nav-checkbox'])) { echo 'style="display: inline;"'; } ?> >
        </section>
    </section>
    <label>Tekst</label>
    <textarea rows="4" cols="50" name="body" ><?php echo set_value("body"); ?></textarea>

    <br>
    <input type="submit" name="submit" value="versturen">
</form>

