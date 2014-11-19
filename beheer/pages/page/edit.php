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
    echo "een fout met de url.";
}

$query = "SELECT * FROM page WHERE id = $id LIMIT 1";
$result = $mysqli->query($query);
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
    $in_nav = post('in_nav');

    date_default_timezone_set($config['timezone']);
    $time = date("Y-m-d");

    $query = "UPDATE page SET title = '$title', description = '$description', slug = '$slug', body = '$body', published = '$published', in_nav = '$in_nav', last_modified = '$time' WHERE id = '$id'";
    if (!$mysqli->query($query)) {
        echo $mysqli->error;
    }
    foreach ($_POST as $key => $value) {
        if (empty($value) && ($key == $title || $slug || $body)) {
            $error_velden .= $value . " ";
        }
    }
    if (!empty($error_velden)) {
        $error = $error_velden . "zijn verplicht! gelieve deze in te vullen.";
    }
    if ($mysqli->query("SELECT * FROM page WHERE slug = '$slug'")->num_rows > 0) {
        $error = "deze doelmap bestaat al!";
    }
}
if (isset($error)) {
    echo '<div class="alert-error">' . @$error . '</div>';
}
?>
<form action="" method="POST">
    <label>Titel</label>
    <input onkeyup="updateValue()" type="text" name="titel" value="<?php echo set_value("titel", $page->title); ?>">
    <label>Description</label>
    <input type="text" name="description" value="<?php echo set_value("description", $page->description); ?>">
    <label>Doelmap</label>
    <input id="slug" type="text" name="slug" value="<?php echo set_value("slug", $page->slug); ?>">
    <label>Text</label>
    <textarea name="body" style="width: 100%;"><?php echo set_value("body", $page->body); ?></textarea>
    <label>Gepubliceerd</label>
    <input type="radio" name="published" value="1" <?php echo $radio_published[0] ?>>Ja<br>
    <input type="radio" name="published" value="0" <?php echo $radio_published[1] ?>>Nee
    <label>Navigatiebalk</label>
    <input id="in_nav" type="number" name="in_nav" value="<?php echo set_value("in_nav", $page->in_nav); ?>" onKeyUp="setSpanZero()"><span id="onZero"></span>
    <br>
    <input type="submit" name="submit" value="Edit">
</form>

