<!DOCTYPE html>
<html>
    <head>
        <title>Whitehill Motors: %TITLE%</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Stylesheets -->
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />

        <!-- External Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    </head>
    <body>
        <header>
            <nav id="nav">
                <div class="logo">
                    <h1><a href="index.php?page=home">Whitehill Motors</a></h1>
                </div>

                <div class="nav-icon">
                    <a href="javascript:void(0);" onclick="collapseNav()">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </a>
                </div>

                <ul>
                    <li>
                        <a class="<?php echo ($action == 'home') ? 'active' : '' ?>" href="index.php?controller=pages&action=home"><i class="fa fa-home" aria-hidden="true"></i><br />Home</a>
                    </li>
                    <li>
                        <a class="<?php echo ($action == 'about') ? 'active' : '' ?>" href="index.php?controller=pages&action=about"><i class="fa fa-question-circle" aria-hidden="true"></i><br />About</a>
                    </li>
                    <li>
                        <a class="<?php echo ($controller == 'cars') ? 'active' : '' ?>" href="index.php?controller=cars&action=index"><i class="fa fa-car" aria-hidden="true"></i><br />Cars</a>
                    </li>
                    <li>
                        <a class="<?php echo ($action == 'services') ? 'active' : '' ?>" href="index.php?controller=pages&action=services"><i class="fa fa-wrench" aria-hidden="true"></i><br />Services</a>
                    </li>
                    <li>
                        <a class="<?php echo ($action == 'contact') ? 'active' : '' ?>" href="index.php?controller=pages&action=contact"><i class="fa fa-address-book" aria-hidden="true"></i><br />Contact</a>
                    </li>
                </ul>
            </nav>

            <div class="banner">
                <div class="banner-text">
                    <h1>%BANNERTEXT%</h1>
                </div>
            </div>
        </header>
