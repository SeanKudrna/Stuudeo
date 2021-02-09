<?php

//--Include Statments--//
include('session.php');
include('functions.php');
unset($_SESSION['try_again']);
unset($_SESSION['error']);
$_SESSION['establish_crew'] = [[]];

if(!isset($_SESSION['login_user'])){
$_SESSION['login_user'] = 'Guest';
$_SESSION['username'] = 'Guest';
}
?>

<!--HTML Headder-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Stuudeo</title>
    <link rel="shortcut icon" href="assets/branding/favicon.ico" />
    <meta name="description" content="seo_description_goes_here">
    <meta name="keywords" content="seo_keywords_here">

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
<body class="template-page">

<!--NavBar-->
<?php NavBar() ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome to Stuudeo!</h1>
                <p>	Stuudeo is the best place to showcase your work, credit your collaborators, and join a thriving filmmaking community.</p>
                <video controls poster="assets/video/about_poster.jpg" style="width: 850px; max-width: 100%; margin-bottom: 20px;">
                    <source src="assets/video/about_stuudeo.mp4" type="video/mp4">
                </video>
                <h3>Get Connected</h3>
                <p>If you’re on Stuudeo, it’s because you have a passion for creating. Guess what? You’re not alone. Connect with content creators from coast to coast, create new communities, and support each other's work!</p>
                <h3>Get Weird</h3>
                <p>Don’t be afraid! Experiment! Do something that’ll get heads scratching. </p>
                <h3>Get Real</h3>
                <p>You have a story to tell. Now, you have an audience to share that story with. Make something that <em>only you can.</em></p>
            </div>
        </div>
    </div>

    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>


</body>
</html>
