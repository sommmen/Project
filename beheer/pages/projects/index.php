<?php
/*
 * Door Kevin Pijning
 */
minRole(3);
?>

<a href="/beheer/projects/add" class="button blue">Project toevoegen</a>
<h1>Projecten</h1>
<?php
/*
 * Hier wordt een lijst van een projecten weergegeven.
 */
$query = "SELECT *, project.id as project_id FROM project JOIN user ON user.id = project.uid ORDER BY created DESC";
$result = $mysqli->query($query);
if($result->num_rows > 0){
?>
<table>
    <tr class="head">
        <th>Project Naam</th>
        <th>Klant Naam</th>
        <th>Datum</th>
        <th>Acties</th>
    </tr>
<?php

    while ($project = $result->fetch_object()) {

        ?>
    <tr>
        <td><a href="/beheer/projects/view/<?php print_r($project->project_id);?>"><?php echo $project->title;?></a></td>
        <td><a href="/beheer/customers/profile/<?php echo $project->id;?>"><?php echo $project->name.' '.$project->surname;?></a></td>
        <td><?php echo $project->created;?></td>
        <td>
            <a href="/beheer/projects/edit/<?php echo $project->project_id;?>"><img src="/beheer/res/img/pencil90.png" alt="Bewerken"/></a> |
            <a href="/beheer/projects/delete/<?php echo $project->project_id;?>"><img src="/beheer/res/img/black393.png" alt="Verwijderen"/></a> |
            <a href="/beheer/projects/addPhotos/<?php echo $project->project_id;?>"><img src="/beheer/res/img/plus24.png" alt="Toevoegen"/></a>

        </td>
    </tr>
    <?php
}
?>
</table>
<?php
} else {
    echo '<div class="alert-error">Er zijn momenteel geen projecten.</div>';
}
?>