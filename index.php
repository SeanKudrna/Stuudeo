<?php
//--Include Statments--//
include('session.php');
include('functions.php');
unset($_SESSION['try_again']);
unset($_SESSION['error']);

//--If No Login, Auto Login as Guest
if(!isset($_SESSION['login_user'])){
$_SESSION['login_user'] = 'Guest';
$_SESSION['username'] = 'Guest';
$_SESSION['establish_crew'] = [[]];

}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stuudeo | Showcasing the Best Young Filmmakers in the U.S.</title>
    <link rel="icon" href="assets/branding/favicon.ico" type="image/x-icon" />
    <meta name="description" content="Discover, browse, and connect with some of the most talented young filmmakers and content creators across the United States through interactive portfolios.">
    
    <meta property="og:title" content="Stuudeo | Showcasing the Best Young Filmmakers in the U.S." />
    <meta property="og:image" content="assets/branding/social_image.png" />

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/1572784ea9.js" crossorigin="anonymous"></script>

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-171706122-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-171706122-1');
    </script>


</head>

<!--HTML Body-->
<body>
   
<?php 

NavBar();
HomepageHeader();

?>


<!----- GATHERING DATA ----->
    <?php
        session_start();
    ?>

    <!----- USER PROFILES ----->
    <div class="container">
        <div class="row users-grid">
            <div class="text-center">
                <?php
                 DisplayFeaturedUsers();
                ?>
            </div>
        </div>
    </div>
    
    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>

    <script>
    if ($(window).width() > 767) {
       $( ".hero_banner" ).append( $( "<video autoplay loop muted src='assets/video/landing_banner.mp4'></video>" ) );
    }
    </script>
    
</body>
</html>

