<?php
minRole(3);
?>
<script type="text/javascript" src="/Project/beheer/res/javascript/wysiwyg-editor.js"></script>
<script type="text/javascript" src="javascript/slug.js"></script>
<script type="text/javascript">
    function setSpanZero() {
        if (document.getElementById('in_nav').value === 0) {
            document.getElementById('onZero').textContent = "niet tonen.";
        }
        setSpanZero();
    }
</script>

<?php
//TODO
//kijken in welk formaat 'tijd' in de tabel staat.
//wysiwyg editor.

if (!is_numeric($id = urlSegment(3))) {
    redirect('/beheer/page');
}

$query = "SELECT * FROM page WHERE id = $id LIMIT 1";
$result = $mysqli->query($query);



if ($result->num_rows == 0){
    redirect('/beheer/page');
}
$radio_published = ["", ""];
$page = $result->fetch_object();

if ($page->published == 1) {
    $radio_published[0] = "checked";
} else {
    $radio_published[1] = "checked";
}

if (isset($_POST["submit"])) { //dit geeft errors.
    $title = post('titel');
    $description = post('description');
    $slug = post('slug');
    $body = addslashes($_POST['body']);
    $published = post('published');


    date_default_timezone_set($config['timezone']);
    $time = date("Y-m-d");
    if (empty($title)) {
        $error = "vul een titel in";
    } elseif (empty($body)) {
        $error = "vul tekst in";
    } else {

        if(!isset($_POST['in_nav-checkbox'])){
            $in_nav = 0;
        }else{
            $in_nav = post('in_nav-number');
        }

        echo $in_nav;

        $query = "UPDATE page SET title = '$title', description = '$description', slug = '$slug', body = '$body', published = '$published', in_nav = '$in_nav', last_modified = '$time' WHERE id = '$id'";
        if (!$mysqli->query($query)) {
            $error = $mysqli->error;
        }else{
            setMessage("Pagina succesvol bijgewerkt.");
            redirect('/beheer/page');
        }
    }
}


if (isset($error)) {
    echo '<div class="alert-error">' . @$error . '</div>';
}
?>
<a href="/beheer/page" class="button">Terug naar overzicht</a>
<h1>Pagina bewerken</h1>


<form action="" method="POST">
    <section class="row">
        <section class="half">
            <label>Titel</label>
            <input onkeyup="updateValue()" type="text" name="titel" value="<?php echo set_value("titel", $page->title); ?>">
            <label>Description</label>
            <input type="text" name="description" value="<?php echo set_value("description", $page->description); ?>">
            <label>Link</label>
            <input id="slug" type="text" name="slug" value="<?php echo set_value("slug", $page->slug); ?>">
        </section>
        <section class="half">
            <label>Gepubliceerd</label>
            <input type="radio" name="published" value="1" <?php echo $radio_published[0] ?>>Ja<br>
            <input type="radio" name="published" value="0" <?php echo $radio_published[1] ?>>Nee
            <label>Navigatiebalk</label>
            <input id="in_nav-checkbox" type="checkbox" name="in_nav-checkbox" value="0" onchange="showIn_nav()" <?php if((!isset($_POST['in_nav-checkbox']) && $page->in_nav != 0) || isset($_POST['in_nav-checkbox'])) { echo'checked';} ?>>
            <input id="in_nav-number" type="number" name="in_nav-number" value="<?php echo set_value("in_nav", $page->in_nav); ?>" <?php if($page->in_nav != 0 || isset($_POST['in_nav-checkbox'])){ echo 'style="display:inline;"'; }?>>
        </section>
    </section>
    <label>Text</label>
    <textarea name="body" style="width: 100%;"><?php echo set_value("body", $page->body); ?></textarea>

    <br>
    <input type="submit" name="submit" value="Bijwerken">
</form>

