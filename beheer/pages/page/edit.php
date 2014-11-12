<?php
minRole(3);

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

if (isset(post('submit'))) {
    $title = post('titel');
    $description = post('description');
    $slug = post('slug');
    $body = post('body');
    $published = post('published');
    $in_nav = post('in_nav');
    $time = $query = "UPDATE pagina SET title = $title,description = $description, slug = $slug, body = $body, published = $published, in_nav = $in_nav WHERE id = $id";
    $mysqli->query($query);
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
    <select name="in_nav">

        <?php
        $amount_in_nav = $mysqli->query("SELECT COUNT(*) FROM page WHERE in_nav > 0");
        $checked = $mysqli->query("SELECT in_nav FROM page WHERE id = $id");

        for ($index = 0; $index <= $amoun_in_nav; $index++) {
            if($index == 0){
                $option = "niet weergeven";
            } else {
                $option = $index;
            }
            if ($checked == $index) {
                ?>
                <option selected="selected" value="<?php echo set_value("selected", $index); ?>"><?php echo $option; ?></option>
            <?php } else { ?>
                <option value="<?php echo set_value("selected", $index); ?>"><?php echo $option; ?></option>
                <?php
                }
                }
                ?>
    </select>
    <input type="submit" name="submit" value="Edit">
</form>

