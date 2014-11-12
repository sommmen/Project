

<table>
    <tr>
        <th>Naam</th>
        <th>Adres</th>
        <th>Postcode</th>
        <th>Woonplaats</th>
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
         echo '<td>'. $row->address.' </td>';
         echo '<td>'. $row->zipcode.' </td>';
         echo '<td>'. $row->city.' </td>';
         echo '<td>'. $row->email.' </td>';
         echo '<td> <a href="kbs.klanten.kevin889.nl/beheer/customers/edit/'. $row->id .'"><img alt="edit" src="/beheer/res/img/pencil90.png"></a> | ';
         echo '<a href="kbs.klanten.kevin889.nl/beheer/customers/delete/'. $row->id .'"><img alt="edit" src="/beheer/res/img/black393.png"></a></td>';
         echo '</tr>';
    }
?>
</table>


