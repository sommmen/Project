<?php
    
    minRole(3);
    $id = urlSegment(3);
    
    function getKlant($id){
        global $mysqli;
        $result = $mysqli->query('SELECT name, surname FROM user WHERE id = '. $id);
        if(!$result || $result->num_rows < 1) return 404;
        while($row = $result->fetch_array()){
            return $row['name'].' '.$row['surname'];
        }
    }
    function showProjectList($id){
        global $mysqli;
        $result = $mysqli->query('SELECT id, title, created FROM project WHERE uid = '. $id);
        if(!$result) return 404;
        if($result->num_rows < 1){
            echo '<label style="color: red;">Deze klant is niet gebonden aan een project.</label>';
        }else{
            echo '<h2>Welke projecten wilt u bewaren?</h2>';
            echo '<tr><th width="50">Bewaar</th><th>Project Naam</th><th>Aanmaakdatum</th></tr>';
            while($row = $result->fetch_array()){
                echo '<tr>';
                echo '<td><input type="checkbox" name="ckBoxValue[]" value="'.$row['id'].'"/> </td>';
                echo '<td>'. $row['title'] .'</td>';
                echo '<td>'. $row['created'] .'</td>';
                echo '</tr>';
            }
        }
    }
    function archiveProject($projectID){
        global $mysqli;
        $mysqli->query('UPDATE project SET uid = 0 WHERE id = '. $projectID);
    }
    
    function deleteUser($id){
        global $mysqli;
        if(!$mysqli->query('DELETE FROM user WHERE id = '.$id)){
            echo $mysqli->error;
        }
    }
    function deleteProject($id){
        global $mysqli;
        $result = $mysqli->query('DELETE FROM project WHERE uid = '.$id. ' AND id != 0');
        if(!$result){
            echo 404;
        }
    }
    
    if(isset($_POST['deleteSubmit'])){
        foreach($_POST['ckBoxValue'] as $checkBox){
            archiveProject($checkBox);
        }
        deleteUser($id);
        deleteProject($id);
        redirect('/beheer/customers');
    }
?>

<a href="/beheer/customers" class="button">Terug naar overzicht</a>

<form method="POST" action="">
    <h1>Verwijdering <?php echo getKlant($id);?></h1>
    <br />
    <table>
    <?php showProjectList($id);?>
    </table>
    <br/>
    <input type="submit" value="Verwijder" name="deleteSubmit"/>
    
</form>