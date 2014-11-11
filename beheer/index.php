<?php
session_start();
ob_start();

//session_destroy();
require_once('../system/core.php');

?>

<!DOCTYPE html>

<html class="no-js">
<head>
    <title>Beheer ~ <?php echo getProp('site_name');?></title>
    <meta name="description" content="desc" />
    <meta name="keywords" content="keywords" />
    <meta name="author" content="Kevin Pijning" />
    <meta charset="UTF-8" />
    <meta name="author" content="kevin889" />
    <meta name="robots" content="index, follow" />


    <link rel="stylesheet" href="/beheer/res/css/reset.css" />
    <link rel="stylesheet" href="/beheer/res/css/style.css" />
    <link rel="stylesheet" href="/beheer/res/css/dropzone.css" />

    <script src="/beheer/res/js/modernizr.js"></script>
    <script src="/beheer/res/js/jquery.js"></script>
    <script src="/beheer/res/js/dropzone.js"></script>
    <script src="/beheer/res/js/custom.jq.js"></script>
</head>

<body>
<header>
    <section class="container">
        Michael Verbeek beheer
    </section>
</header>

<section class="container">
    <?php echo getMessage(); ?>
</section>

<section class="container">

    <?php
    if(logged_on()){
    ?>

    <aside>
        <nav>
            <ul>
                <li><a href="/beheer/">Dashboard</a></li>
                <?php if(user_data('role') == 3){ ?>
                    <li><a href="/beheer/page">Pagina's</a></li>
                    <li><a href="/beheer/portfolio">Portfolio</a></li>
                    <li><a href="/beheer/projects">Projecten</a></li>
                    <li><a href="/beheer/customers">Klanten</a></li>
                    <li><a href="/beheer/settings">Instellingen</a></li>
                <?php }elseif(user_data('role') == 2){ ?>
                    <li><a href="/beheer/project">Project</a></li>
                <?php } ?>
                <li><a href="/beheer/user/logout">Uitloggen</a></li>
            </ul>

        </nav>
    </aside>

    <section class="content">
        <?php

        if(@!urlSegment(1)){
            $current_page = 'pages/dashboard/index';
        }elseif(urlSegment(1) && @!urlSegment(2)){
            $current_page = 'pages/'.urlSegment(1).'/index';
        }else{
            $current_page = 'pages/'.urlSegment(1).'/'.urlSegment(2);
        }

        if(file_exists($current_page.'.php') && is_file($current_page.'.php')) {

            require_once($current_page . '.php');

        }else{
            echo 404;
        }
        ?>

    </section>
    <?php
    }else{

        require_once('pages/user/login.php');

    } ?>
</section>
</body>

</html>