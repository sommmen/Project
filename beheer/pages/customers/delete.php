<?php
    /** Gemaakt door Eelco */
    minRole(3);
    $id = urlSegment(3);

/**
 * @param $id Id van de klant
 * @return int|string Geeft de naam + achternaam terug uit de database mits de query kan worden uitgevoerd
 * anders heeft ie een 404 error terug.
 */
    function getKlant($id){
        global $mysqli;
        $result = $mysqli->query('SELECT name, surname FROM user WHERE id = '. $id);
        if(!$result || $result->num_rows < 1) return 404;
        while($row = $result->fetch_array()){
            return $row['name'].' '.$row['surname'];
        }
    }

/**
 * Geeft de resultaten van de query in een dropdown menu weer.
 * Het id van elke option wordt opgeslagen in de value. Zo kan je weer per option
 * het id opvragen, en van daaruit weer meer informatie krijgen.
 */
    function showDropdown(){
        echo '<select name="portfolioSelection">';
        echo '<option value="remove"><strong>..</strong></option>';
        global $mysqli;
        $result = $mysqli->query('SELECT id, name FROM portfolio');
        if($mysqli->error) return 404;
        while($row = $result->fetch_object()){
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo '</select>';
    }

/**
 * @param $photoid ID van de foto
 * Verplaats de foto van een project naar een uitgekozen portfolio.
 * In deze functie worden de mapjes gesorteerd die buiten public_html zijn, als de
 * mapjes niet bestaan worden ze gemaakt e.d.
 */
	function moveFile($photoid){ //Photo id
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
		rename(dirname(__FILE__).$ds.$projectDir.$ds.$filename, dirname(__FILE__).$ds.$portfolioDir.$ds.$filename);
        echo dirname(__FILE__).$ds.$projectDir.$ds.$filename. '<br>';
        echo dirname(__FILE__).$ds.$portfolioDir.$ds.$filename. '<br>';
        echo $filename;
	}

/**
 * @param $id Id van de klant
 * Weergeeft de lijst met projecten van elke klant met opties erbij.
 */
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
                echo '<td>'; showDropdown(); echo '</td>';
                echo '</tr>';
            }
        }
    }

/**
 * @param $projectId Id van het project
 * Functie die wordt uigevoerd wanneer er op submit wordt gedrukt.
 * Elk project wordt afgehandeld (verwijderd, verplaatst etc.)
 */
    function submitProject($projectId){
        global $mysqli;
        $mysqli->query('DELETE FROM project WHERE id ='.$projectId);
        $newLoc = $_POST['portfolioSelection'];
        if($newLoc == 'remove'){
            $mysqli->query('DELETE FROM photo WHERE pid = '.$projectId);
            setMessage('Klant sucessvol verwijderd! De foto\'s verwijderd!');
            return;
        }
        $mysqli->query('UPDATE photo SET portfolio_album = '.$newLoc.' WHERE pid = '.$projectId);
        setMessage('Klant sucessvol verwijderd! De foto\'s zijn verplaatst!');
        $result = $mysqli->query('SELECT id FROM photo WHERE pid = '.$projectId);
        while($row = $result->fetch_object()){
            moveFile($row->id);
        }
    }

/**
 * @param $id Id van de klant die je wilt verwijderen
 * Klant wordt verwijderd mits er geen error ontstaat. Anders
 * print ie de error.
 */
    function deleteUser($id){
        global $mysqli;
        if(!$mysqli->query('DELETE FROM user WHERE id = '.$id)){
            echo $mysqli->error;
        }
    }

/**
 * Spreekt redelijk voor zich. Wordt uigevoerd wanneer submit button wordt ingedrukt.
 */
    if(isset($_POST['deleteSubmit'])){
        $result = $mysqli->query('SELECT id FROM project WHERE uid = '.$id);
        while($row = $result->fetch_object()){
            submitProject($row->id);
        }
        deleteUser($id);
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