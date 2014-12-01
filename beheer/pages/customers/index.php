<?php
minRole(3);
?>
<h1>Klanten overzicht</h1>
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
$query = "SELECT * FROM user ORDER BY name";
$result = $mysqli->query($query);
    while ($row = $result->fetch_object()) {
         echo '<tr>';
         echo '<td><a href="/beheer/customers/profile/'.$row->id.'">'. $row->name.' '. $row->surname.'</a></td>';
         echo '<td>'. $row->email.' </td>';
         echo '<td> <a href="/beheer/customers/edit/'. $row->id .'"><img alt="edit" src="/beheer/res/img/pencil90.png"></a> | ';
         echo '<a href="/beheer/customers/delete/'. $row->id .'"><img alt="edit" src="/beheer/res/img/black393.png"></a></td>';
         echo '</tr>';
    }
?>
</table>


