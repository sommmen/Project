<?php
minRole(3);

$query = "SELECT * FROM project WHERE id = '".urlSegment(3)."'";
$result = $mysqli->query($query);
if($result->num_rows == 0){
    redirect('/beheer/projects');
}
$project = $result->fetch_object();

$query = "SELECT * FROM photo WHERE pid = '".$project->id."'";
$result = $mysqli->query($query);
?>
<a href="/beheer/projects" class="button">Terug naar overzicht</a>
<a href="/beheer/customers/profile/<?php echo $project->uid;?>" class="button blue">Klant informatie</a>
<a href="/beheer/projects/addPhotos/<?php echo $project->id;?>" class="button blue">Foto's toevoegen</a>

<h1><?php echo $project->title;?> <a href="/beheer/projects/edit/<?php echo $project->id; ?>"><img src="/beheer/res/img/pencil90.png" alt="Bewerken"/></a></h1>

<section class="row">
<?php
if($result->num_rows > 0) {
    while($photo = $result->fetch_object()) {
        ?>
        <figure <?php if($photo->selected == true){ echo 'class="selected"'; } ?>>
            <a href="/thumb.php?photo=<?php echo $photo->id;?>&type=project" data-lightbox="image-1" data-title="<?php echo $photo->name;?>">
                <img src="/thumb.php?photo=<?php echo $photo->id;?>&type=project" alt=""/>
            </a>
            <figcaption>
                <abbr title="<?php echo $photo->name;?>"><?php echo substr($photo->name, 0, 20); ?></abbr>
                <a href="/beheer/projects/deletePhoto/<?php echo $photo->id;?>" onClick="return confirm('Weet je zeker dat je deze afbeelding wilt verwijderen?')"><img src="/beheer/res/img/black393.png" alt="delete"/></a>
            </figcaption>
        </figure>
    <?php
    }
} else {
    echo 'Dit project heeft momenteel geen foto\'s. <a href="/beheer/projects/addPhotos/'.$project->id.'">Klik hier</a> om foto\'s toe te voegen.';
}
?>
</section>