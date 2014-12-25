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
    <link rel="stylesheet" href="/beheer/res/css/lightbox.css" />
    <link rel="stylesheet" href="/beheer/res/css/dropzone.css" />

    <script src="/beheer/res/js/modernizr.js"></script>
    <script src="/beheer/res/js/jquery.js"></script>
    <script src="/beheer/res/js/lightbox.min.js"></script>
    <script src="/beheer/res/js/dropzone.js"></script>
    <script src="/beheer/res/js/custom.jq.js"></script>
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            content_css: "/beheer/res/css/style.css",
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
        });
    </script>

</head>

<body>
<header>
    <section class="container">
        <a href="/"><?php echo getProp('site_name');?> beheer</a>
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
                    <li><a href="/beheer/customers/editProfile">Mijn gegevens</a></li>
                <?php }elseif(user_data('role') == 2){ ?>
                    <li><a href="/beheer/project">Project</a></li>
                    <li><a href="/beheer/customers/editProfile">Gegevens</a></li>
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