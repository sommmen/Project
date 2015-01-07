<?php
//require_once '../../system/core.php';
/* 
 * Dion leurink s1080954
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




if(isset($_POST['thumb']) && !empty($_POST['thumb']) ){
    $portfolio_album = addslashes(trim(htmlspecialchars($_POST['thumb'])));
    
    global $mysqli;
    
    $query = "SELECT * FROM photo WHERE portfolio_album = '$portfolio_album'";
    $keys = [];
    $values = [];
    while($result = $mysqli->query($query)){
        array_push($key, $result->id); 
        array_push($value, $result->filename); 
    }
    
    echo json_encode(array_combine($keys, $values));
    //echo json_encode(array("name"=>"John","time"=>"2pm"));
}