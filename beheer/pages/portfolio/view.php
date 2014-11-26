<?php
minRole(3);

$query = "SELECT * FROM portfolio WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/portfolio');
}
$portfolio = $result->fetch_object();

$query = "SELECT * FROM photo WHERE portfolio_album = '".$portfolio->id."'";
$result = $mysqli->query($query);
?>
<a href="/beheer/portfolio" class="button">Terug naar overzicht</a>
<a href="/beheer/portfolio/addPhoto/<?php echo $portfolio->id;?>" class="button blue">Foto's toevoegen</a>

<h1><?php echo $portfolio->name;?></h1>

<section class="row">
<?php
if($result->num_rows > 0) {
    while($photo = $result->fetch_object()) {
        ?>
        <figure <?php if($photo->selected == true){ echo 'class="selected"'; } ?>>
            <a href="/thumb.php?photo=<?php echo $photo->id;?>&type=portfolio" data-lightbox="image-1" data-title="<?php echo $photo->name;?>">
                <img src="/thumb.php?photo=<?php echo $photo->id;?>&type=portfolio" alt=""/>
            </a>
            <figcaption>
                <?php echo $photo->name; ?>
                <a href="/beheer/portfolio/deletePhoto/<?php echo $photo->id;?>" onClick="return confirm('Weet je zeker dat je deze afbeelding wilt verwijderen?')"><img src="/beheer/res/img/black393.png" alt="delete"/></a>
            </figcaption>
        </figure>
    <?php
    }
} else {
    echo 'Dit portfolio heeft momenteel geen foto\'s. <a href="/beheer/portfolio/addPhoto/'.$portfolio->id.'">Klik hier</a> om foto\'s toe te voegen.';
}
?>
</section>