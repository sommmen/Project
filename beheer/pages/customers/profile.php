<?php
minRole(3);
$id = urlSegment(3);

?>
<a href="/beheer/customers/edit/ID" class="button blue">Klant aanpassen</a>
<h1>Profiel</h1>
<section class="half">
    <?php


    
    $name = "";
    $surname = "";
    $address = "";
    $email = "";
    $zipcode = "";
    $city = "";
    $telephone = "";
    $result = $mysqli->query('SELECT * FROM user WHERE id = '.$id);

    if($result->num_rows == 0)
        redirect('/beheer/customers');
        
    while($row = $result->fetch_array()){
        $name = $row['name'];
        $surname = $row['surname'];
        $address = $row['address'];
        $zipcode = $row['zipcode'];
        $city = $row['city'];
        $email = $row['email'];
        $telephone = $row['telephone'];
    }
    ?>
    
    <table>
        <tr>
            <td>Naam:</td>
            <td><?php echo $name; ?></td>
        </tr>
        <tr>
            <td>Achternaam:</td>
            <td><?php echo $surname; ?></td>
        </tr>
        <tr>
            <td>Adres:</td>
            <td><?php echo $address; ?></td>
        </tr>
        <tr>
            <td>Postcode:</td>
            <td><?php echo $zipcode; ?></td>
        </tr>
        <tr>
            <td>Stad:</td>
            <td><?php echo $city; ?></td>
        </tr>
        <tr>
            <td>E-mail:</td>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
            <td>Telefoonnummer:</td>
            <td><?php echo $telephone; ?></td>
        </tr>
    </table>
</section>
<section class="half">
    <?php
    $result = $mysqli->query("SELECT * FROM project WHERE uid = ".$id." ORDER BY created");
    if($mysqli->error) return 404;

    echo "<table>";
    echo "<tr><th>Projectnaam</th></tr>";
    if($result->num_rows == 0){
        echo "<tr><td><div class='alert-error'>Deze persoon heeft geen projecten.</div></td></tr>";
    }
    while($row = $result->fetch_array()){
        echo "<tr>";
        echo "<td><a href='/beheer/projects/view/".$row['id']."'>".$row['title']."</a></td>";
        echo "</tr>";
    }
    ?>
</section>