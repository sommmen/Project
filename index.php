<?php
require_once('system/core.php');

/* Set environment */
if($config['environment'] == 'develop'){
    error_reporting(E_ALL ^ E_NOTICE);
    ini_set('display_errors', '1');
} elseif($config['environment'] == 'public'){
    error_reporting(0);
    ini_set('display_errors', '0');
}

if(!urlSegment(1)){
    $pageTitle = getProp('site_name').' ~ '.getProp('site_slug');
}else{
    $pageTitle = urlSegment(1).' ~ '.getProp('site_name');
}


?>

<!DOCTYPE html>

<html class="no-js">
<head>
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="desc" />
    <meta name="keywords" content="keywords" />
    <meta name="author" content="Kevin Pijning" />
    <meta charset="UTF-8" />
    <meta name="author" content="kevin889" />
    <meta name="robots" content="index, follow" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="/res/css/reset.css" />
    <link rel="stylesheet" href="/res/css/style.css" />

    <script src="/res/js/modernizr.js"></script>
    <script src="/res/js/jquery.js"></script>
    <script src="/res/js/custom.jq.js"></script>
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

<section id="top_image">
    <header>
        <section class="logo">
            <a href="<?php echo getProp('base_url');?>"><img src="/res/img/logo.png" alt="Michael Verbeek - Fotografie / Geluidstechniek"/></a>
        </section>

        <button id="mobileMenu"></button>

        <nav>
            <ul>
                <?php
                $menuSQL = "SELECT * FROM page WHERE in_nav != 0 AND published = 1 ORDER BY in_nav";
                $result = $mysqli->query($menuSQL);
                while($row = $result->fetch_object()){

                    if(urlSegment(1) == $row->slug){
                        $active = 'class="current"';
                    }else{
                        $active = '';
                    }

                    echo '<li '.$active.'><a href="/'.$row->slug.'">'.$row->title.'</a></li>';
                }
                ?>

            </ul>
        </nav>

    </header>

    <section class="content_slider">
        <h1>Beleef <span class="red">momenten</span></h1>
        <h2>Alsof u er zelf bij was.</h2>
    </section>

    <section class="main">

        <section class="content">
            <?php

            if(!urlSegment(1)){
                $current_page = getProp('default_page');
            }else{
                $current_page = urlSegment(1);
            }

            $pageSQL = "SELECT * FROM page WHERE (slug = '".urlSegment(1)."' OR id = '".$current_page."') AND published = 1";
            $result = $mysqli->query($pageSQL);
            if($result->num_rows != 0) {
                $row = $result->fetch_object();

                $pageTitle = explode(' ', $row->title);
                if(count($pageTitle) > 1) {
                    $pageTitle[count($pageTitle) - 1] = '<span class="red">' . $pageTitle[count($pageTitle) - 1] . '</span>';
                    $pageTitle = implode(" ", $pageTitle);
                } else {
                    $pageTitle = $row->title;
                }
                ?>
                <hgroup>
                    <h1><?php echo $pageTitle;?></h1>
                    <?php if($row->description){
                        echo '<h2>'.$row->description.'</h2>';
                    }
                    ?>
                </hgroup>

                <?php echo includeTags($row->body);?>

            <?php
            }else{
                echo "<h1>Pagina niet gevonden</h1>";
            }
            ?>
        </section>

    </section>


    <footer>
        <section class="container">
            <section class="content">

                <section class="col-4">
                    &copy; Copyright 2014<br/>
                    <br/>
                    <ul>
                        <li><a href="#">Privacy policy</a></li>
                        <li><a href="#">Disclaimer</a></li>
                        <li><a href="/beheer/">Klanten</a></li>
                    </ul>
                </section>

                <section class="col-4">
                    <ul>
                        <?php
                        $menuSQL = "SELECT * FROM page WHERE in_nav != 0";
                        $result = $mysqli->query($menuSQL);
                        while($row = $result->fetch_object()){

                            echo '<li><a href="/'.$row->slug.'">'.$row->title.'</a></li>';
                        }
                        ?>
                    </ul>
                </section>

                <section class="col-4">
                    U kan contact met mij opnemen via:<br/>
                    <br/>
                    <a href="#">info@michaelverbeek.eu</a><br/>
                    06-123 34 56
                </section>

                <section class="col-4">

                    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                    <br>
                    <a class="twitter-follow-button"
                       accesskey=""href="https://twitter.com/formaestroke"
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
                    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/formaestroke" data-widget-id="527467523709468672">Tweets by @formaestroke</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


                </section>

            </section>
        </section>
    </footer>

</section>

</body>

</html>
