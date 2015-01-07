<?php
/*
 * Door Kevin Pijning en Daan Stout
*/
minRole(3); // Minimale rol om deze pagina te bezoeken is rol 3 (beheerder)

// Verkrijg het opgevraagde project.
$query= "SELECT * FROM project  WHERE id = '".urlSegment(3)."'";
$result=$mysqli->query($query);

if($result->num_rows==1){
    $project=$result->fetch_object();


if(isset($_POST['verzenden'])){

    if(empty($_POST['project_naam'])){
        $error = 'U dient alle velden in te vullen.';
    }
    /*
     * Als de naam van het project wordt aangepast, moet ook de map naam worden bijgewerkt.
     */
    $targerPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($project->id . $project->title) . '/';

    if(post('customer') != $project->uid){
        //Als het project een nieuwe eigenaar krijgt, dan wordt er een email gestuurd naar de nieuwe eigenaar.
        $query = $mysqli->query("SELECT * FROM user WHERE id = '".post('customer')."'");
        $user = $query->fetch_object();

        $to = $user->email;
        $name = $user->name.' '.$user->surname;
        $email_content = 'Beste '.$name.',<br>'
            . '<br>'
            . 'Michael Verbeek heeft een nieuw project voor U aangemaakt.<br/>'
            . 'U kunt op de volgende link inloggen om het project te kunnen bekijken: <a href="'.getProp('base_url').'/beheer">'.getProp('base_url').'/beheer</a><br>'
            . '<br>'
            . 'Met vrienelijke groet,<br>'
            . '<br>'
            . 'Michael Verbeek';


        $subject = 'nieuw project aangemaakt';
        $headers =  "From: Michael Verbeek <".getProp('admin_mail').">\r\n".
            "MIME-Version: 1.0" . "\r\n" .
            "Content-type: text/html; charset=UTF-8" . "\r\n";

        mail($to, $subject, $email_content, $headers);

    }

        // Werk het project bij in de database.
        $result = $mysqli->query("UPDATE project SET title = '" . post('project_naam') . "', max = '" . post('project_max_photos') . "', uid = '".post('customer')."' WHERE id = '" . $project->id . "'");
        $result = $mysqli->query("SELECT * FROM project WHERE id = '" . $project->id . "'");
        if ($result->num_rows > 0) {
            $projects = $result->fetch_object();
            //Werk de naam van de map bij.
            $newPath = dirname(__FILE__) . '/../../../../uploads/' . sha1($projects->id . $projects->title) . '/';
            rename($targerPath, $newPath);
        }
        if ($result && !$error) {
            setMessage("Project succesvol bijgewerkt.");
            redirect('/beheer/projects/');
        } else {
            $error ='<div class="alert-error">'.$error.'</div>';
            echo $mysqli->error? $mysqli->error : $error;
        }

}

?>
<a href="/beheer/projects" class="button">Terug naar overzicht</a>
<h1>Project aanpassen</h1>
<form method="post" action="">
    <label>Project naam:</label>
    <input type="text" name="project_naam" value="<?php echo $project->title; ?>">
    <label>Max foto's</label>
    <input type="number" name="project_max_photos" value="<?php echo $project->max; ?>"><br><br>
    <label>Klant:</label>
    <select name="customer">
    <?php
    $query = $mysqli->query("SELECT * FROM user");
    while($klant = $query->fetch_object()){
        if($klant->id == $project->uid){
            $current = "SELECTED";
        }else{
            $current = "";
        }
       ?>
        <option value="<?php echo $klant->id;?>" <?php echo $current;?>><?php echo $klant->name.' '.$klant->surname;?></option>
        <?php
    }
    ?>
    </select>
    <br/><br/>
    <input type="submit" name="verzenden" value="project aanpassen">
</form>

<?php
}
?>