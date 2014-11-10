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


    <link rel="stylesheet" href="res/css/reset.css" />
    <link rel="stylesheet" href="res/css/style.css" />

    <script src="res/js/modernizr.js"></script>
    <script src="res/js/jquery.js"></script>
    <script src="res/js/custom.jq.js"></script>
</head>

<body>
<header>
    <section class="container">
        Michael Verbeek beheer
    </section>
</header>

<section class="container">

    <?php
    if(logged_on()){
    ?>

    <aside>
        <nav>
            <ul><li><a href="#">Home</a></li>
                <ul><li><a href="#">Home</a></li>
                    <ul><li><a href="#">Home</a></li>
                        <ul><li><a href="#">Home</a></li>
                            <ul><li><a href="#">Home</a></li>
        </nav>
    </aside>

    <section class="content">
        <?php
        echo 'welkom '. user_data('username');
        ?>
    </section>
    <?php
    }else{

        require_once('pages/login.php');

    } ?>
</section>
</body>

</html>