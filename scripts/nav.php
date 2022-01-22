<?php
session_start();

// Only expose the extra tabs in the user is signed in
if (isset($_SESSION['session_id']) && $_SESSION['session_id'] === session_id()) {
    $view = true;
    $log_out_nav = "log-out-nav";
    $adjusted_width = "adj-width";
} else {
    $nav_bar_adj = "navbar-ul-adj";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>AÉB Software Consultancy</title>
        <meta name="generator" content="Hugo 0.48" />
        <meta charset="utf-8">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="keywords" content="Andre Bertram">
        <meta property="og:title" content="Andre Bertram - Software Developer">
        <meta property="og:url" content="abertram.ca">
        <meta property="og:description" content="A developer from Kelowna BC">
        <meta property="og:site_name" content="abertram.ca">
        <meta property="og:type" content="software">
        <?php if($homepage) {
            $about_us = "page/about-us.php";
            $featured = 'page/featured-projects.php';
            $home = '../abertram/index.php';
            include '../abertram/html/homepageLinks.html';
        }
        else {
            $about_us = "../page/about-us.php";
            $featured = '../page/featured-projects.php';
            $home = '../index.php';
            include '../html/regularLinks.html';
        }
        ?>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Passion One|Istok Web|Audiowide|Shippori Antique|Noto Sans Korean">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.1/font/bootstrap-icons.min.css" integrity="sha512-WYaDo1TDjuW+MPatvDarHSfuhFAflHxD87U9RoB4/CSFh24/jzUHfirvuvwGmJq0U7S9ohBXy4Tfmk2UKkp2gA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.css" rel="stylesheet">         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script href="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <?php
        if ($homepage) {
            echo "<script src=\"../abertram/assets/js/navigation.js\"></script>";
        } else {
            echo "<script src=\"../assets/js/navigation.js\"></script>";
        }
        ?>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-inverse">
                <div id="nav-container-wrapper">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <div>
                                <a class="navbar-brand" href="<?php echo $home?>">
                                    <h4>AÉB Software Consultancy</h4>
                                </a>
                            </div>
                        </div>
                        <ul id="navbar-ul" class="nav navbar-nav <?php echo $adjusted_width;
        echo $nav_bar_adj;
        ?>">
                            <li class="bg-blend-screen bg-all bg-green zoom">
                                <a href="<?php echo $featured ?>" id="feature-projects-tab" tabindex="featured-projects-wrapper">
                                    <ruby>
                                        <h4>Featured Projects</h4>
                                        <rp>(</rp><rt><i class="bi bi-award-fill"></i></rt><rp>)</rp>
                                    </ruby>
                                </a>
                            </li>

                            <?php
                            if ($view) {
                                if ((include '../abertram/html/extra-tab-s.html')) {
                                    // Do nothing.
                                } else {
                                    include '../html/extra-tabs.html';
                                }
                            }
                            ?>

                            <li class="bg-blend-screen bg-all bg-yellow zoom">
                                <a href="<?php echo $about_us ?>" tabindex="about-us-wrapper">
                                    <ruby>
                                        <h4>About Us</h4>
                                        <rp>(</rp><rt><i class="bi bi-building"></i></rt><rp>)</rp>
                                    </ruby>
                                </a>
                            </li>
                        </ul>
                        <ul id="user-nav"  class="nav navbar-nav navbar-right <?php echo $log_out_nav ?>">
                            <?php
                            if (!$view) {
                                if ((include '../abertram/html/signUpSignInNav.html')) {
                                    // Do nothing.
                                } else {
                                    include '../html/signUpSignInNav.html';
                                }
                            } else {
                                if ((include '../abertram/html/signOutNav.html')) {
                                    // Do nothing.
                                } else {
                                    include '../html/signOutNav.html';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div id="content-container-wrapper" style="background: ghostwhite;">
            <div id="content-container">