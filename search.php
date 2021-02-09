<?php
//--Include Statments--//
include('session.php');
include('functions.php');

//--Auto Log In As Guest--//
if(!isset($_SESSION['login_user'])){
$_SESSION['login_user'] = 'Guest';
$_SESSION['username'] = 'Guest';
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for a user</title>
    <link rel="shortcut icon" href="assets/branding/favicon.ico" />
    <meta name="description" content="seo_description_goes_here">
    <meta name="keywords" content="seo_keywords_here">

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/1572784ea9.js" crossorigin="anonymous"></script>

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css">

</head>

<!--HTML Body-->
<body class="template-page">

<!--NavBar-->
<?php NavBar() ?>

<!--Search Form-->
    <div class="container">
        <div class="row">
            <h1 class="d-block" style="width: 100%;">Search for a user below:</h1>
        </div>
        <div class="row">
            <form action="profile.php" method="GET">
                <label class="d-block">Username:</label>
                <input class="d-block" type="text" id="username" name="username">
                <input style="margin-top: 10px;" class="d-block" type="submit" name="submit" value="View Profile!">
            </form>
        </div>
    </div>
    
    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>

</body>
</html>