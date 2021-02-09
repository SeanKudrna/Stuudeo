<?php

//--Include Statments--//
include('session.php');
include('functions.php');
$_SESSION['try_again'] = 'FALSE';
$_SESSION['establish_crew'] = [[]];


if(!isset($_SESSION['login_user'])){
header("location: login.php"); 
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore | Stuudeo</title>
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
<body>
   
<!--NavBar-->
<?php NavBar(); ?>


   
<!--Start Session-->
<?php session_start(); ?>

    <?php    
    echo"<div class='col-lg-12 text-center' style='margin-top: 20px;'><h1>Inspiration</h1></div><div class='horizontal-scroll-container'>";
        $sql = "SELECT * FROM featured_links ORDER BY RAND() LIMIT 4";
        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()){

            $link = $row['link'];
            $RoutingNumber = $row['RoutingNumber'];
            $username = GetUsername_ID($RoutingNumber);

            //--Fetch Video Info For Youtube--//
            if(strpos($link, "youtube")){

                $fetch=explode("v=", $link);
                $videoid=$fetch[1];

                $apikey = //Hidden because of public sharing;   

                $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
                $ytdata = json_decode($json);

                $title = $ytdata->items[0]->snippet->title;
            }

            //--Fetch Video Info For Vimeo
            else if (strpos($link, "vimeo")){

                //Fetch videoid
                $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
                $videoid = (int)$urlParts[count($urlParts)-1];

                //Fetch title using Vimeo api
                $hash = json_decode(file_get_contents("http://vimeo.com/api/v2/video/{$videoid}.json"));
                $title = $hash[0]->title;
            }

            //--Horitzonal Scroll of Recommended Videos--//
            echo'
                <div class="horizontal-scroll-element">
                    <div class="iframe-container">';
                        if(strpos($link, "youtube")){
                            echo'
                            <iframe src="https://www.youtube.com/embed/'.$videoid.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        }

                        else if (strpos($link, "vimeo")){
                            echo'
                            <iframe src="https://player.vimeo.com/video/'.$videoid.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        }
                        echo'
                    </div>
                </div>
                    ';
        }
        echo"</div>";
    ?>
   
    <!--Page Header-->
    <div class="container page-header">
        <div class="row">
            <h1>Meet Fellow Creators</h1>
        </div>
    </div>
    
    <!--User Profiles-->
    <div class="container">
        <div class="row users-grid">
            <div class="text-center">
                <!--Display Featured Users-->
                <?php DisplayAllUsers(); ?>
            </div>
        </div>
    </div>
    
    

    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>

</body>
</html>
