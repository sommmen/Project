
<?php
/**
 *  Gemaakt door Eelco Eikelboom
 */
minRole(2);
/**
 * @var $id Project ID, niet user ID
 */
$id = urlSegment(3);

$query = $mysqli->query('SELECT * FROM photo WHERE pid = ' . $id);
$selected = $mysqli->query('SELECT * FROM photo WHERE pid = ' . $id. ' AND selected = 1');
$selectedNum = $selected->num_rows;
$project = $mysqli->query("SELECT * FROM project WHERE id = '".$id."' AND uid = '".user_data('id')."'");

if($project->num_rows == 0){
    redirect('/beheer/');
}
$project = $project->fetch_object();
if ($query->num_rows == 0) {
    echo "<div class='alert-error'> Op dit moment zijn er nog geen foto's toegevoegd, gelieve op een ander
    moment terug te komen.</div>";
    return;
}
/**
 * Wordt aangeroepen wanneer de button wordt ingeklikt.
 * '$info' = Een lijst van informatie van elke geselecteerde foto. Dit is
 * nodig voor de email.
 */
if (isset($_POST['btnSubmit'])) {
    resetData($id);
    $info = "";
    foreach ($_POST as $photoId => $value) {
        if ($photoId == "btnSubmit") continue;
        $info .= addInfo($photoId);
        $mysqli->query('UPDATE photo SET selected = 1 WHERE id = '.$photoId);
    }
    sendMail($info, $id);
    setMessage('De foto\'s zijn succesvol verstuurd! U krijgt zo spoedig mogelijk bericht!');
    redirect('/beheer/customers/projectsView/'.$id);

}
/**
 * @param $projectID Idee van het project.
 * @return int Hij returnt een error als de query niet werkt.
 * resetData zorgt er voor dat alle gerelateerde foto's van dit project eerst worden
 * gezet naar 'NIET geselecteerd', daarna zoek ik naar de wél geselecteerde foto's, en die zet ie dan weer
 * terug. Dit betekend dat de klant dynamisch zijn foto's kan selecteren, omdat de foto's die hij eerder geselecteerd had
 * Nu ook geselecteerd zijn. (Het is heel logisch als je je voor je ziet)
 */
function resetData($projectID){
    global $mysqli;
    $mysqli->query('UPDATE photo SET selected = null WHERE pid = '.$projectID);
    if($mysqli->error) return 404;
}

/**
 * @param $info Staat voor de lijst met uitgekozen foto's. Heb een verslaving aan functies ;)
 * @param $id Id staat voor het ID van het project van de foto's.
 * Deze functie stuurt een nette mail naar de admin met de aanvraag van de klant. Gegevens van de klant
 * (email etc) wordt uit de database gehaald.
 */
function sendMail($info, $id){
    $subject = 'Michael Verbeek - Er is een nieuw verzoek van '.user_data('name').' '.user_data('surname');
    $to = getProp('admin_mail');
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $header .= 'From: '.user_data('name').' '.user_data('surname').'<'.user_data('email').'>';
    mail($to, $subject,
        'Hallo michael, '.user_data('name').' '.user_data('surname').' heeft een keuze kunnen maken. <br>
        De volgende foto\'s zijn uitgekozen: <br>'. $info.
        '<br> Gelieve de heer/mevrouw '.user_data('name').' '.user_data('surname').' terug te mailen.<br><br>
        Klik <a href="'.getProp('base_url').'/beheer/projects/view/'.$id.'">hier</a> om het project te bezoeken.',
        $header);
}

/**
 * @param $photoId Id van de foto.
 * @return int|string Geeft een String met informatie terug. (Naam en bestandsnaam in 1 string)
 * Dit gebruik ik om een lijst op te bouwen van elk geselecteerde foto.
 */
function addInfo($photoId){
    global $mysqli;
    $result = $mysqli->query('SELECT * FROM photo WHERE id = '.$photoId);
    if($mysqli->error) return 499904;
    if($row = $result->fetch_object()){
        return '- <strong>'. $row->name.'</strong>  - (<i>'. $row->file_name.')</i> <br>';
    }
}


?>
<a href="/beheer/dashboard" class="button">Terug naar overzicht</a>

<h1>Project <span id="currentSelectedPhotos"><?php echo $selectedNum; ?></span> / <span id="maxSelectedPhotos"><?php echo $project->max;?></span></h1>

<?php /** Laat een lijst zien van alle geuploade foto's betreffend het project (project id)
    *  Elke foto (elke <figure>) heeft een checkbox met als 'name' de id van de foto. Hiermee kan
    * ik makkelijk dingen met de foto's doen omdat ik de ids gewoon uit de POST kan halen. (Zie boven)
    */?>
<form method="POST">
    <section class="row">
        <?php
        while ($row = $query->fetch_object()) {
            ?>
            <figure <?php if ($row->selected == true) {
                echo 'class="selected"';
            } ?>>
                <a href="/thumb.php?photo=<?php echo $row->id; ?>&type=project" data-lightbox="image-1"
                   data-title="<?php echo $row->name; ?>">
                    <img src="/thumb.php?photo=<?php echo $row->id; ?>&type=project" alt=""/>
                </a>
                <figcaption>
                    <label for="photo<?php echo $row->id;?>" style="display: inline;"><?php echo $row->name; ?></label>
                    <input id="photo<?php echo $row->id;?>" type="checkbox" name="<?php echo $row->id; ?>" class="selector" <?php if($row->selected == true){ echo 'checked';} ?>>
                </figcaption>
            </figure>
        <?php
        }
        ?>
    </section>
    <input type="submit" value="Verstuur Selectie" name="btnSubmit">
</form>
