
<?php
minRole(2);
/**
 * @var $id Project ID, niet user ID
 */
$id = urlSegment(3);

$query = $mysqli->query('SELECT * FROM photo WHERE pid = ' . $id);
echo @$mysqli->error;
if ($query->num_rows == 0) {
    echo "<div class='alert-error'> Op dit moment zijn er nog geen foto's toegevoegd, gelieve op een ander
    moment terug te komen.</div>";
    return;
}

if (isset($_POST['btnSubmit'])) {
    foreach ($_POST as $photoId => $value) {
        if ($photoId == "btnSubmit") continue;
            print_r($_POST);
    }
}


?>
<a href="/beheer/dashboard" class="button">Terug naar overzicht</a>

<h1>Project <span id="currentPhotos">0</span>/<span id="maxPhotos">0</span></h1>

    <form method="POST">
        <section class="row">
        <?php
        while ($row = $query->fetch_object()) {
            ?>
            <figure <?php if ($row->selected == true) {
                echo 'class="selected"';
            } ?>>
                <a href="/thumb.php?photo=<?php echo $row->id; ?>&type=project" data-lightbox="image-1"
                   data-title="<?php echo $row->name; ?>">
                    <img src="/thumb.php?photo=<?php echo $row->id; ?>&type=project" alt=""/>
                </a>
                <figcaption>
                    <?php echo $row->name; ?>
                    <input type="checkbox" name="<?php echo $row->id; ?>" class="selector" <?php if($row->selected == true){ echo 'checked';} ?>>
                </figcaption>
            </figure>
        <?php
        }
        ?>
        </section>
        <input type="submit" value="Verstuur Selectie" name="btnSubmit">
    </form>
