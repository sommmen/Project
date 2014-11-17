<?php
    
    minRole(3);
    $id = urlSegment(3);
    
    function getKlant($id){
        global $mysqli;
        $result = $mysqli->query('SELECT name, surname FROM user WHERE id = '. $id);
        if(!$result || $result->num_rows < 1) return 404;
        while($row = $mysqli->fetch_array($result)){
            return $row['name'].' '.$row['surname'];
        }
    }
    function showProjectList($id){
        global $mysqli;
        $result = $mysqli->query('SELECT id, title, created FROM project WHERE uid = '. $id);
        if(!$result || $result->num_rows < 1) return 404;
        while($row = $mysqli->fetch_array($result)){
            echo '<tr>';
            echo '<td>'. $row['title'] .'</td>';
            echo '<td>'. $row['created'] .'</td>';
            echo '<td> <input type="checkbox" name="ckBoxValue[]" value="'.$row['id'].'"/> </td>';
            echo '</tr>';
        }
    }
    function archiveProject($projectID){
        global $mysqli;
        $mysqli->query('UPDATE project SET id = 0 WHERE id = '. $projectID);
    }
    
    function deleteUser($id){
        global $mysqli;
        $mysqli->query('DELETE FROM user WHERE id = '.$id);
        
    }
    
    if(isset($_POST['deleteSubmit'])){
        foreach($_POST['ckBoxValue'] as $checkBox){
            archiveProject($checkBox);
        }
        deleteUser($id);
    }
?>

<form method="POST" action="index.php">
    <h1>Verwijdering <?php echo getKlant($id);?></h1>
    <br />
    Projecten gerelateerd met deze klant:
    <table>
    <h3>Welke projecten wilt u archiveren?</h3>
    <tr><thead>Project Naam</thead><thead>Aanmaakdatum</thead></tr>
    <?php showProjectList($id);?>
    </table>
    <img src="/beheer/res/img/deletebin.png"/><input type="submit" value="Verwijder" name="deleteSubmit"/>
    
</form>