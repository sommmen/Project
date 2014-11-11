

<table><th>Voornaam</th>
        <th>Achternaam</th>
        <th>Adres</th>
        <th>Postcode</th>
        <th>Woonplaats</th>
        <th>Email</th>
<?php

/**
 *  Weergeeft een tabel met users en desbetreffende gegevens
 * 
 */
$query = "SELECT * FROM user";
$result = $mysqli->query($query);
    while ($row = $result->fetch_object()) {
         echo '<tr>';
         echo '<td>'. $row->name.' </td>'; 
         echo '<td>'. $row->surname.' </td>';
         echo '<td>'. $row->adress.' </td>';
         echo '<td>'. $row->zipcode.' </td>';
         echo '<td>'. $row->city.' </td>';
         echo '<td>'. $row->email.' </td>';
         echo '<td> <a href="kbs.klanten.kevin889.nl/beheer/customers/edit/'. $row->uid .'">Edit</a></td>';
         echo '<td> <a href="kbs.klanten.kevin889.nl/beheer/customers/delete/'. $row->uid .'">Edit</a></td>';
         echo '</tr>';
    }
?>
</table>


