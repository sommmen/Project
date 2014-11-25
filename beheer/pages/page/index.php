<?php minRole(3);
?>
<a href="/beheer/page/add" class="button blue">Pagina toevoegen</a>
<h1>Pagina overzicht</h1>

<table>
    <tr>
        <th>Titel</th>
        <th>Link</th>
        <th>Laatst bewerkt</th>
        <th>zichtbaar</th>
        <th>Menu volgorde</th>
        <th>Acties</th>

    </tr>
    <?php
    $query = "SELECT * FROM page ORDER BY id";
    $result = $mysqli->query($query);
    if ($result->num_rows <= 0) {
        ?>
        <h1>er zijn nog geen pagina's aangemaakt.</h1>
        <p>zodra er nieuwe pagina's zijn gemaakt kunt u ze hier zien.</p>
        <a href="/beheer/page/add">voeg een nieuwe pagina toe!</a>
    <?php
    }
    while ($page = $result->fetch_object()) {
        if ($page->published == 1) {
            $published = "ja";
        } else {
            $published = "nee";
        }
        if ($page->in_nav == 0) {
            $in_nav = 'niet getoond';
        } else {
            $in_nav = $page->in_nav;
        }
        ?>
        <tr>
            <td><?php echo $page->title; ?></td>
            <td><?php echo $page->slug; ?></td>
            <td><?php echo $page->last_modified; ?></td>
            <td><?php echo $published; ?></td>
            <td><?php echo $in_nav; ?></td>
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
