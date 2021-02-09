<?php

//--Include Statments--//
include('session.php');
include('functions.php');
unset($_SESSION['try_again']);
unset($_SESSION['message']);

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
    <title>404 Error</title>
    <link rel="shortcut icon" href="assets/branding/favicon.ico" />

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
                <h1>Oh no! This page was not found.</h1>
                <h6 style="margin-bottom: 50px;">Error code: 404</h6>
                <p>Here are some helpful links instead:</p>
                <a href="index.php">Home</a> <br>
                <a href="explore.php">Explore</a> <br>
                <a href="login.php">Login</a>
            </div>
        </div>
    </div>

    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>


</body>
</html>
