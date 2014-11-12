<?php
minRole(3);
?>
<a href="/beheer/customers/add" class="button blue">Klant toevoegen</a>
<table>
    <tr>
        <th>Naam</th>
        <th>Email</th>
        <th>Acties</th>
    </tr>
<?php

/**
 *  Weergeeft een tabel met users en desbetreffende gegevens
 * 
 */
$query = "SELECT * FROM user";
$result = $mysqli->query($query);
    while ($row = $result->fetch_object()) {
         echo '<tr>';
         echo '<td>'. $row->name.' '. $row->surname.'</td>';
         echo '<td>'. $row->email.' </td>';
         echo '<td> <a href="/beheer/customers/edit/'. $row->id .'"><img alt="edit" src="/beheer/res/img/pencil90.png"></a> | ';
         echo '<a href="/beheer/customers/delete/'. $row->id .'"><img alt="edit" src="/beheer/res/img/black393.png"></a></td>';
         echo '</tr>';
    }
?>
</table>


