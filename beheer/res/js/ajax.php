<?php
include('../../../system/core.php');

if(isset($_POST)){

    if($_POST['func'] == 'dynSearch'){
        $attribute = post('attr');
        $value = post('val');
        if($value) {
            $query = "SELECT * FROM user WHERE $attribute LIKE '%" . $value . "%' AND role = 2";
            if ($result = $mysqli->query($query)) {

                while ($user = $result->fetch_object()) {
                    $list[$user->id]['id'] = $user->id;
                    $list[$user->id]['name'] = $user->name;
                    $list[$user->id]['surname'] = $user->surname;
                    $list[$user->id]['email'] = $user->email;
                    $list[$user->id]['address'] = $user->address;
                    $list[$user->id]['zipcode'] = $user->zipcode;
                    $list[$user->id]['city'] = $user->city;
                    $list[$user->id]['telephone'] = $user->telephone;
                }
                if (isset($list)) {
                    echo json_encode($list);
                }

            }
        }

    }

}

