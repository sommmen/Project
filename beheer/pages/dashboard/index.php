<h1>Welkom <?php echo user_data('name').' '.user_data('surname');?></h1>

<?php
$id = user_data('id');

function showProjects($uid){
    global $mysqli;
    $query = $mysqli->query('SELECT * FROM project WHERE uid = '.$uid.' ORDER BY created');
    if($mysqli->error) return 404;
    if($query ->num_rows == 0){
        echo "<div class='alert-error'> U bent op dit moment nog niet gekoppeld aan een project</div>";
        return;
    }
    echo '<tr><th>Project Naam</th><th>Aanmaakdatum</th><th>Items</th></tr>';
    while($row = $query->fetch_array()){
        echo '<tr>';
        echo '<td>'.$row['title'].'</td>';
        echo '<td>'.$row['created'].'</td>';
        echo "<td> <a href='/beheer/customers/projectsView/". $row['id']."'>Foto's</a></td>";
        echo '</tr>';
    }
}
?>
<table>

    <?php showProjects($id)?>
</table>
