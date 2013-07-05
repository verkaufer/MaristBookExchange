<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
  <!--
Begin header 
-->
    <meta charset="utf-8">

    <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Marist Book Exchange | mBEx</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="humans.txt">

    <link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

    <!-- Facebook Metadata /-->
    <meta property="fb:page_id" content="" />
    <meta property="og:image" content="" />
    <meta property="og:description" content=""/>
    <meta property="og:title" content=""/>

    <!-- Google+ Metadata /-->
    <meta itemprop="name" content="">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    <!-- We highly recommend you use SASS and write your custom styles in sass/_custom.scss.
       However, there is a blank style.css in the css directory should you prefer -->
    <link rel="stylesheet" href="css/gumby.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/libs/modernizr-2.6.2.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>

<style>
  html, body {
    background: #fefefe;
  }

    h1.head{
        font-size: 75px;
        font-family: Georgia;
        font-style: italic;
    }

    .directions{
        text-align: center;
        font-weight: bold;
    }

    .center{
        text-align: center;
    }

</style>
<!-- begin 
  body -->
<body>
<div class="container">

    <div class="row">
      <div class="twelve columns special head">
        <h1 class="head">Marist Book Exchange</h1>
<!--        <h2>A new way to resell books</h2> -->
      </div>
    </div>


    <div class="row navbar" id="nav1">
    <!-- Toggle for mobile navigation, targeting the <ul> -->
    <a class="toggle" gumby-trigger="#nav1 > .row > ul" href="#"><i class="icon-menu"></i></a>
    <ul class="twelve columns">
    <li><a href="index.php">Home</a></li>
    <li><a href="contact.php">Contact</a></li>
    <li>
    <a href="#">Browse</a>
    <div class="dropdown">
    <ul>
    <li><a href="mytrades.php">My Trades</a></li>
    <li><a href="browse.php">Recently Listed</a></li>
    <li><a href="stats.php">Statistics</a></li>
    </ul>
    </div>
    </li>
    <?php
        if(isset($_SESSION['uid']) && $_SESSION['uid'] !=""){
            echo "<li><a href='login.php?do=logout'>Logout</a></li>";
        } else {
            echo "<li><a href='login.php'>Login/Register</a></li>";
        }
    ?>
    </ul>
    </div>