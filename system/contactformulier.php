<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="contactformulier.css"/>
        <title></title>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.0";
             fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <p class="header">
            Contact formulier:
        </p>
        <p class="info_1">
            Alles met een asterisk is een verplicht veld
        </p>
        <?php
        if(isset($_POST["submit"])){
            if(empty($_POST["Voornaam"])||empty($_POST["Achternaam"])||empty($_POST["Email"])||empty($_POST["Onderwerp"])||empty($_POST["Bericht"])){
                Print("Vul alstublieft alle verplichte velden in. <br>");
            }
        }
        
        function set_value($post, $default=''){
            return $_POST[$post] ? post($post) : '';
        }
        
        ?>
        <br>
        <form method="Post" action="contactformulier.php">
            Voornaam*:<br> <input type="text" name="Voornaam" value="<?php print(@$_POST["Voornaam"]); ?>"> <?php if(isset($_POST["submit"])){if(empty($_POST["Voornaam"])){print("VERPLICHT!");}} ?> <br>
            Achternaam*:<br> <input type="text" name="Achternaam" value="<?php print(@$_POST["Achternaam"]); ?>">  <?php if(isset($_POST["submit"])){if(empty($_POST["Achternaam"])){print("VERPLICHT!");}} ?> <br>
            E-mail*:<br> <input type="text" name="Email" value="<?php print(@$_POST["Email"]); ?>">  <?php if(isset($_POST["submit"])){if(empty($_POST["Email"])){print("VERPLICHT!");}} ?> <br>
            Telefoon nummer:<br> <input type="text" name="Tel" value="<?php print(@$_POST["Tel"]); ?>"><br>
            Adres:<br> <input type="text" name="Adres" value="<?php print(@$_POST["Adres"]); ?>"><br>
            Woonplaats:<br> <input type="text" name="Woonplaats" value="<?php print(@$_POST["Woonplaats"]); ?>"><br>
            Postcode:<br> <input type="text" name="Postcode" value="<?php print(@$_POST["Postcode"]); ?>"><br>
            Onderwerp*:<br> <input type="text" name="Onderwerp" value="<?php print(@$_POST["Onderwerp"]); ?>">  <?php if(isset($_POST["submit"])){if(empty($_POST["Onderwerp"])){print("VERPLICHT!");}} ?> <br>
            Bericht*:<br> <input type="textarea" name="Bericht" value="<?php print(@$_POST["Bericht"]); ?>">  <?php if(isset($_POST["submit"])){if(empty($_POST["Bericht"])){print("VERPLICHT!");}} ?> <br>
            <input type="submit" value="Versturen" name="submit">
            <br>
            <?php
                if(isset($_POST[submit])){
                    $message = ("Michael verbeek, U heeft een nieuwe klant. De heer/mevrouw ".$_POST["Voornaam"]." ".$_POST["Achternaam"]." heeft zich aangemeld en heeft als bericht: ".$_POST["Bericht"]);
                    $header =   'From: formaestroke@gmail.com' . "\r\n" .
                                'Reply-To: '.$_POST["Email"] . "\r\n" .
                                 'X-Mailer: PHP/' . phpversion();
                    mail("formaestroke@gmail.com", $_POST["Onderwerp"], $message, $header);
                }
            ?>
            <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
            <br>
            <a class="twitter-follow-button"
               accesskey=""href="https://twitter.com/twitterdev"
               data-show-count="true"
               data-lang="en">
            Follow @twitterdev
            </a>
            <script type="text/javascript">
            window.twttr = (function (d, s, id) {
                 var t, js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id)) return;
                 js = d.createElement(s); js.id = id;
                 js.src= "https://platform.twitter.com/widgets.js";
                 fjs.parentNode.insertBefore(js, fjs);
                 return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
            }(document, "script", "twitter-wjs"));
            </script>
        </form>
    </body>
</html>
