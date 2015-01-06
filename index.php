<?php
/*
 * Door Kevin Pijning
 */
require_once('system/core.php');

/* Set environment */
if($config['environment'] == 'develop'){ //Geef errors weer
    error_reporting(E_ALL ^ E_NOTICE);
    ini_set('display_errors', '1');
} elseif($config['environment'] == 'public'){ //Verberg errors
    error_reporting(0);
    ini_set('display_errors', '0');
}

/*
 * Hier wordt de pagina titel bepaald.
 * Als er geen url is opgegeven dan wordt standaard de site naam en de site slug weergegeven in de titel
 * Als er wel een url is ingevuld, dan wordt de pagina in de database opgezocht, en de pagina titel wordt weergegeven.
 * Als de pagina niet gevonden is wordt er een 404 error geplaatst.
 */
if(!urlSegment(1)){
    $pageTitle = getProp('site_name').' ~ '.getProp('site_slug');
}else{
    $pageSQL = "SELECT * FROM page WHERE (slug = '".urlSegment(1)."' OR id = '".$current_page."') AND published = 1";
    $result = $mysqli->query($pageSQL);
    if($result->num_rows != 0) {
        $row = $result->fetch_object();
        $pageTitle = $row->title . ' ~ ' . getProp('site_name');
    }else{
        $pageTitle = 'Pagina niet gevonden ~ ' . getProp('site_name');
    }
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
    <link rel="stylesheet" href="/res/css/lightbox.css" />

    <script src="/res/js/modernizr.js"></script>
    <script src="/res/js/jquery.js"></script>
    <script src="/res/js/lightbox.min.js"></script>
    <script src="/res/js/custom.jq.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
                /*
                 * Hier wordt het menu samengesteld.
                 * Alleen pagina's die gepubliceerd zijn en pagina's waarvan aangegeven is dat ze in het menu zichtbaar moeten zijn worden weergegeven.
                 * Er wordt gesorteerd op in_nav, omdat je kan opgeven op welke plek het item moet komen.
                 */
                $menuSQL = "SELECT * FROM page WHERE in_nav != 0 AND published = 1 ORDER BY in_nav";
                $result = $mysqli->query($menuSQL);
                while($row = $result->fetch_object()){

                    /*
                     * Hier wordt de class "current" toegewezen aan een menu item als de gebruiker zich op die pagina bevindt.
                     */
                    if(urlSegment(1) == $row->slug || ($row->id == getProp('default_page') && empty($_GET) )){
                        $active = 'class="current"';
                    }else{
                        /*
                         * Hier gebeurt het zelfde, maar dan voor sub-pagina's.
                         * Omdat sub-pagina's niet overeenkomen met de slug die in het menu staat wordt de huidige slug gesplitst,
                         * en als het eerste deel van de slug overeenkomt met de slug in het menu dan wordt de class "current" toegewezen aan dat menu item.
                         */
                        $ex1 = explode('-', urlSegment(1));
                        $ex2 = explode('-', $row->slug);
                        if($ex1[0] == $ex2[0]){
                            $active = 'class="current"';
                        }else{
                            $active = '';
                        }
                    }
                    /*
                     * Uitendelijke weergave van het menu.
                     */
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

            if(!urlSegment(1)){     //Als er geen url is ingevuld wordt de current_page gezet op het default_page id uit de database.
                $current_page = getProp('default_page');
            }else{
                $current_page = urlSegment(1);
            }

            /*
             * Hier wordt de opgevraagde pagina geladen.
             * De pagina moet gepubliceerd zijn om weergegeven te kunnen worden.
             */
            $pageSQL = "SELECT * FROM page WHERE (slug = '".urlSegment(1)."' OR id = '".$current_page."') AND published = 1";
            $result = $mysqli->query($pageSQL);
            // Als de pagina bestaat wordt hij weergegeven, anderes krijg je een 404 error.
            if($result->num_rows != 0) {
                $row = $result->fetch_object();

                /*
                 * Het laatste woord in de titel wordt altijd rood gekleurd, dit wordt gedaan door de titel op te spitsen aan de hand van spaties.
                 * Het laatste item krijgt span.red
                 */
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
                <?php
                /*
                 * Hier wordt de html content uit de database gefilterd op tags voor de widgets.
                 */
                echo includeTags($row->body);
                ?>

            <?php
            }else{
                echo "<center><h1>Pagina niet gevonden</h1></center>";
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
                        <li><a href="/privacy-policy">Privacy policy</a></li>
                        <li><a href="/disclaimer">Disclaimer</a></li>
                        <li><a href="/beheer/">Klanten login</a></li>
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
                    <a href="/contact"><?php echo getProp('admin_mail');?></a><br/>
                    06-123 34 56
                </section>

                <section class="col-4">

                    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                    <br>

                    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/craftnewz" data-widget-id="527467523709468672">Tweets by @formaestroke</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


                </section>

            </section>
        </section>
    </footer>

</section>

<script src="/res/js/cookieControl-6.2.min.js" type="text/javascript"></script>
<script type="text/javascript">//<![CDATA[
    cookieControl({
        t: {
            title: '<p>Deze website gebruikt cookies om statistieken bij te houden.</p>',
            intro: '<p>De cookies worden gebruikt om statistieken van de website bij te houden</p>',
            full:'<p>Deze cookies worden gebruikt om de statistieken van de website bij te houden.</p><p>By using our site you accept the terms of our <a href="http://kbs.klanten.kevin889.nl/privacy-policy">Privacy Policy</a>.</p>'
        },
        position:CookieControl.POS_LEFT,
        style:CookieControl.STYLE_TRIANGLE,
        theme:CookieControl.THEME_LIGHT, // light or dark
        startOpen:true,
        autoHide:7000,
        subdomains:true,
        protectedCookies: [], // list the cookies you do not want deleted, for example ['analytics', 'twitter']
        apiKey: '53e8269dcd21fec52c85cc2f65fd59067030614c',
        product: CookieControl.PROD_FREE,
        consentModel: CookieControl.MODEL_INFO,
        onAccept:function(){ccAddAnalytics()},
        onReady:function(){},
        onCookiesAllowed:function(){ccAddAnalytics()},
        onCookiesNotAllowed:function(){}
    });

    function ccAddAnalytics() {
        jQuery.getScript("http://www.google-analytics.com/ga.js", function() {
            var GATracker = _gat._createTracker('UA-57306320-1');
            GATracker._trackPageview();
        });
    }
    //]]>
</script>

</body>

</html>
