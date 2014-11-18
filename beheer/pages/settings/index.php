<?php
minRole(3);

?>
<h1>Instellingen</h1>
<table>
    <th>key</th>
    <th>value</th>
<?php
    $result = $mysqli->query("SELECT * FROM setting");
    while($setting = $result->fetch_object()){
 ?>   
    <tr>
        <td><?php echo $setting->key;?></td>
        <td><?php echo $setting->value;?></a></td>
    </tr> 
    <?php
    }
    ?>
</table>