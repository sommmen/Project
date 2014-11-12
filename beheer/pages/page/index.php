<?php
minRole(3);
?>
<a href="/beheer/page/add" class="button blue">Pagina toevoegen</a>
<table>
    <tr>
        <th>Titel</th>
        <th>link</th>
        <th>Laatst bewerkt</th>
        <th>zichtbaar</th>
        <th>Acties</th>
    </tr>
    <?php
    $query = "SELECT * FROM page ORDER BY id";
    $result = $mysqli->query($query);
    while ($page = $result->fetch_object()) {
        if ($page->published == 1) {
            $published = "ja";
        } else {
            $published = "nee";
        }
        //TODO als er geen pagina's zijn, dan moet er een melding worden gegeven dat er geen pagina's zijn.
        ?>
        <tr>
            <td><?php echo $page->title; ?></td>
            <td><?php echo $page->slug; ?></td>
            <td><?php echo $page->last_modified; ?></td>
            <td><?php echo $published; ?></td>
            <td>
                <a href="/beheer/page/edit/<?php echo $page->id; ?>"><img src="/beheer/res/img/pencil90.png" alt="edit"/></a> |
                <a href="/beheer/page/delete/<?php echo $page->id; ?>" onClick="return confirm('Weet je zeker dat je deze pagina wilt verwijderen?')"><img src="/beheer/res/img/black393.png" alt="edit"/></a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<br>
