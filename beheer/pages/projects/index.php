<?php
minRole(3);
?>

<a href="/beheer/projects/add" class="button blue">Project toevoegen</a>
<table>
    <tr class="head">
        <th>Project Naam</th>
        <th>Klant Naam</th>
        <th>Datum</th>
        <th>Acties</th>
    </tr>
<?php
$query = "SELECT *, project.id as project_id FROM project JOIN user ON user.id = project.uid ORDER BY created DESC";
$result = $mysqli->query($query);
    while ($project = $result->fetch_object()) {
        //TODO de klantnaam laten weergeven dmv een join in de query?
        //TODO als er geen pagina's zijn, dan moet er een melding worden gegeven dat er geen pagina's zijn.
        ?>
    <tr>
        <td><a href="/beheer/projects/view/<?php print_r($project->project_id);?>"><?php echo $project->title;?></a></td>
        <td><a href="/beheer/customer/profile/<?php echo $project->id;?>"><?php echo $project->name.' '.$project->surname;?></a></td>
        <td><?php echo $project->created;?></td>
        <td>
            <a href="/beheer/projects/edit/<?php echo $project->project_id;?>"><img src="/beheer/res/img/pencil90.png" alt="edit"/></a> |
            <a href="/beheer/projects/delete/<?php echo $project->project_id;?>" onClick="return confirm('Weet je zeker dat je dit project wilt verwijderen?')"><img src="/beheer/res/img/black393.png" alt="edit"/></a> |
            <a href="/beheer/projects/addPhotos/<?php echo $project->project_id;?>"><img src="/beheer/res/img/plus24.png" alt="add"/></a>
        </td>
    </tr>
    <?php
        //dit is kut, en moeilijk te begrijpen voor daan.
        //print("<tr><td>$page->title</td><td>$page->uid</td><td>$page->created</td><td><a href=\"/beheer/projects/edit/$page->title\">Edit</a>\<a href=\"/beheer/projects/delete/$page->title\">Delete</a></td></tr>");
    }
?>
</table>