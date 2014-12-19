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

    function showDropdown($projectID){
        echo '<select name='.$projectID.'>';
        echo '<option value="remove"><strong>..</strong></option>';
        global $mysqli;
        $result = $mysqli->query('SELECT id, name FROM portfolio');
        if($mysqli->error) return 404;
        while($row = $result->fetch_object()){
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo '</select>';
    }
	
	function moveFile($photoid, $delete){ //Photo id
		global $mysqli;
        /**Retrieve project ID */
        $projectid = 0;
        $project_result = $mysqli->query('SELECT pid FROM photo WHERE id = '.$photoid.' LIMIT 1');
        if($row = $project_result->fetch_object()){
            $projectid = $row->pid;
        }
        /**Retrieve portfolio ID */
        $portfolioid = 0;
        $portfolio_result = $mysqli->query('SELECT portfolio_album FROM photo WHERE id ='.$photoid.' LIMIT 1');
        if($row = $portfolio_result->fetch_object()){
            $portfolioid = $row->portfolio_album;
        }

        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = '../../../../uploads';

        /** Retrieve project folder */
		$projectDir = '';
        $folder_result = $mysqli->query('SELECT id, title FROM project WHERE id = '.$projectid);
		if($row = $folder_result->fetch_object()){
			$projectDir = $storeFolder.$ds.sha1($row->id.$row->title);
		}
        /**Retrieve portfolio folder */
		$portfolioDir = '';
        $portfolio_result = $mysqli->query('SELECT id, name FROM portfolio WHERE id ='.$portfolioid);
		if($row = $portfolio_result->fetch_object()){
			$portfolioDir = $storeFolder.$ds.sha1($row->id.$row->name);
		}
        /** Retrieve file name */
        $filename = '';
        $file_query = $mysqli->query('SELECT file_name FROM photo WHERE id ='.$photoid.' LIMIT 1');
        if($row = $file_query->fetch_object()){
            $filename = $row->file_name;
        }
        if($delete == false) {
            if(!is_dir(dirname(__FILE__) . $ds . $portfolioDir)){
                mkdir(dirname(__FILE__) . $ds . $portfolioDir);
            }
            rename(dirname(__FILE__) . $ds . $projectDir . $ds . $filename, dirname(__FILE__) . $ds . $portfolioDir . $ds . $filename);
        }
        if(is_dir(dirname(__FILE__) . $ds . $projectDir)){
            rmdir(dirname(__FILE__) . $ds . $projectDir);
        }
	}
	

    function showProjectList($id){
        global $mysqli;
        $result = $mysqli->query('SELECT id, title, created FROM project WHERE uid = '. $id);
        if(!$result) return 404;
        if($result->num_rows < 1){
            echo '<label>Deze klant is niet gebonden aan een project.</label>';
        }else{
            echo '<h2>Welke foto\'s wilt u bewaren?</h2>';
            echo '<tr><th>Project Naam</th><th>Aanmaakdatum</th><th>Verplaats foto\'s</th></tr>';
            while($row = $result->fetch_array()){
                echo '<tr>';
                echo '<td>'. $row['title'] .'</td>';
                echo '<td>'. $row['created'] .'</td>';
                echo '<td>'; showDropdown($row['id']); echo '</td>';
                echo '</tr>';
            }
        }
    }
    function submitProject($projectId){
        global $mysqli;
        $newLoc = $_POST[$projectId];
        if($newLoc == 'remove'){
            $mysqli->query('DELETE FROM photo WHERE pid = '.$projectId);
            setMessage('Klant sucessvol verwijderd! De foto\'s verwijderd!');
            $result = $mysqli->query('SELECT id FROM photo WHERE pid = '.$projectId);
            while($row = $result->fetch_object()){
                moveFile($row->id, true);
            }
            return;
        }
        $mysqli->query('UPDATE photo SET portfolio_album = '.$newLoc.' WHERE pid = '.$projectId);
        setMessage('Klant sucessvol verwijderd! De foto\'s zijn verplaatst!');
        $result = $mysqli->query('SELECT id FROM photo WHERE pid = '.$projectId);
        while($row = $result->fetch_object()){
            moveFile($row->id, false);
        }
        $mysqli->query('DELETE FROM project WHERE id ='.$projectId);
    }
    function deleteUser($id){
        global $mysqli;
        if(!$mysqli->query('DELETE FROM user WHERE id = '.$id)){
            echo $mysqli->error;
        }
    }
    if(isset($_POST['deleteSubmit'])){
        $result = $mysqli->query('SELECT id FROM project WHERE uid = '.$id);
        deleteUser($id);
        if($result->num_rows > 0){
            while($row = $result->fetch_object()) {
                submitProject($row->id);
            }
        }
        redirect('/beheer/customers');
    }
?>

<a href="/beheer/customers" class="button">Terug naar overzicht</a>
<h1>Verwijdering <?php echo getKlant($id);?></h1>

<form method="POST" action="">
    <br />
         <table>
         <?php showProjectList($id);?>
        </table>
    <br/>
    <input type="submit" value="Verwijder" name="deleteSubmit"/>
    
</form>