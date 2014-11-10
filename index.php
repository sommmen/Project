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

<section id="top_image">
    <header>
        <section class="logo">
            <a href="#"><img src="/res/img/logo.png" alt="Michael Verbeek - Fotografie / Geluidstechniek"/></a>
        </section>

        <button id="mobileMenu"></button>

        <nav>
            <ul>
                <?php
                $menuSQL = "SELECT * FROM page WHERE in_nav != 0";
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

            $pageSQL = "SELECT * FROM page WHERE slug = '".urlSegment(1)."' OR id = '".$current_page."'";
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

                <?php echo $row->body; ?>

            <?php
            }else{
                echo 404;
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
                        <li><a href="#">Klanten</a></li>
                    </ul>
                </section>

                <section class="col-4">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About me</a></li>
                        <li><a href="#">Portfolio</a></li>
                        <li><a href="#">Costs</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Sound</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </section>

                <section class="col-4">
                    U kan contact met mij opnemen via:<br/>
                    <br/>
                    <a href="#">info@michaelverbeek.eu</a><br/>
                    06-123 34 56
                </section>

                <section class="col-4">
                    twitter en fb ofzo?



                </section>

            </section>
        </section>
    </footer>

</section>

</body>

</html>
