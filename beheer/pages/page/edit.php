<?php
$id = urlSegment(3);

$query = "SELECT * FROM page WHERE id = $id LIMIT 1";
$result = $mysqli->query($query);
$radio_published = ["", ""];
$radio_in_nav = ["", ""];

$page = $result->fetch_object();


if ($page->published == 1) {
    $radio_published[0] = "checked";
} else {
    $radio_published[1] = "checked";
}
if ($page->in_nav == 1) {
    $radio_in_nav[0] = "checked";
} else {
    $radio_in_nav[1] = "checked";
}

if(isset(post('submit'))){
    $query = "UPDATE pagina SET "
}


?>
<form action="" method="POST">
    <label>Titel</label>
    <input type="text" name="titel" value="<?php echo set_value("titel", $page->title); ?>">
    <label>Description</label>
    <input type="text" name="description" value="<?php echo set_value("description", $page->description); ?>">
    <label>Doelmap</label>
    <input type="text" name="slug" value="<?php echo set_value("slug", $page->slug); ?>">
    <label>Text</label>
    <textarea name="body"><?php echo set_value("body", $page->body); ?></textarea>
    <label>Gepubliceerd</label>
    <input type="radio" name="published" value="1" <?php echo $radio_published[0] ?>>Ja<br>
    <input type="radio" name="published" value="0" <?php echo $radio_published[1] ?>>Nee
    <label>Navigatiebalk</label>
    <input type="radio" name="in_nav" value="1" <?php echo $radio_in_nav[0] ?>>Ja<br>
    <input type="radio" name="in_nav" value="0" <?php echo $radio_in_nav[1] ?>>Nee
    <input type="submit" name="submit" value="Edit">
</form>

