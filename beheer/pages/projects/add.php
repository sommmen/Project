<?php
if(isset($_POST['submit'])){

    if(empty($_POST['title'])){
        $error = "U dient alle verplichte velden in te vullen.";
    }elseif($_POST['user_id'] == 0){
        if(empty($_POST['name']) ||
            empty($_POST['surname']) ||
            empty($_POST['email']) ||
            empty($_POST['address']) ||
            empty($_POST['zipcode']) ||
            empty($_POST['telephone'])){
            $error = "U dient alle verplichte velden in te vullen.";
        }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error = "U dient een geldig email adres op te geven.";
        }
    }

}

echo @$error;

?>

    <form action="" method="post" class="dropzone" id="my-awesome-dropzone">

        <input type="hidden" name="user_id" id="user_id" value="<?php echo set_value('user_id', '0');?>">

        <label for="title">Project naam:<span>*</span></label>
        <input type="text" name="title" id="title" value="<?php echo set_value('title');?>">

        <section class="customerData">
            <section class="half form" style="<?php if($_POST['user_id'] != 0){ echo 'display: none;'; } ?>">

                <label for="name">Klant voornaam:<span>*</span></label>
                <input type="text" name="name" id="name" value="<?php echo set_value('name');?>">

                <label for="surname">Klant achternaam:<span>*</span></label>
                <input type="text" name="surname" id="surname" value="<?php echo set_value('surname');?>">

                <label for="email">Klant email:<span>*</span></label>
                <input type="text" name="email" id="email" value="<?php echo set_value('email');?>">

                <label for="address">Klant adres:<span>*</span></label>
                <input type="text" name="address" id="address" value="<?php echo set_value('address');?>">

                <label for="zipcode">Klant postcode:<span>*</span></label>
                <input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode');?>">

                <label for="city">Klant woonplaats:<span>*</span></label>
                <input type="text" name="city" id="city" value="<?php echo set_value('city');?>">

                <label for="telephone">Klant telefoon:<span>*</span></label>
                <input type="text" name="telephone" id="telephone" value="<?php echo set_value('telephone');?>">

            </section>

            <section class="half results">

                <?php
                if(isset($_POST['user_id']) && $_POST['user_id'] != 0) {

                    $result = $mysqli->query("SELECT * FROM user WHERE id = '".post('user_id')."'");
                    if($result->num_rows == 0){
                        unset($_POST);
                        redirect('/beheer/projects/add');
                    }else{
                        $user = $result->fetch_object();
                    }

                    ?>
                    <ul id="user-1" class="user" style="display: block;">
                        <li>
                            <?php echo $user->name." ".$user->surname;?>
                            <ul style="display: block;">
                                <li><?php echo $user->email;?></li>
                                <li><?php echo $user->address;?></li>
                                <li><?php echo $user->zipcode;?></li>
                                <li><?php echo $user->city;?></li>
                                <li><?php echo $user->telephone;?></li>
                            </ul>
                        </li>
                    </ul>
                <?php
                }
                ?>

            </section>

        </section>

        <label for="max">Maximaal te selecteren foto's:</label>
        <input type="number" name="max" id="max" min="0" value="<?php echo set_value('max',0);?>">

        <br/><br/>
        <div class="dropzone-previews"></div>
        <br/><br/>
        <input type="submit" name="submit" value="Aanmaken"/>
    </form>

