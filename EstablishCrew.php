<?php

//--Include Statments--//
include('session.php');
include('functions.php');
unset($_SESSION['error']);


if(!isset($_SESSION['login_user']) || $_SESSION['username'] == "guest"){
header("location: login.php"); // Redirecting To Home Page
}


if (isset($_POST['url']))
{
    $url = $mysqli->real_escape_string($_POST['url']);
    $_SESSION['url'] = $url;

}

if (isset($_POST['finish']))
    {
        header ("location: FinishCrew.php");
    }


//--Start Session--//
session_start();
$mysqli = ConnectDB();

$tag = 0;
$username = $_SESSION['username'];

//Set Glbobal array
$_SESSION['array'] = [];



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        

        if($_POST['contributor'] != ''){$contributor = $_POST['contributor'];}
        else{$contributor = GetEmail(GetCurrentUsername());}
        if(isset($_POST["subject"]))  
            { 
                //First, add email to front of array (array[0])
                array_push($_SESSION['array'], $contributor);

                // Retrieving each selected option and pushing to array
                foreach ($_POST['subject'] as $subject)  
                {
                    //Next, add Contributor tags to Array
                    array_push($_SESSION['array'], $subject);
                }
                array_push($_SESSION['establish_crew'], $_SESSION['array']);
                
            }

    }
else{
    $_SESSION['establish_crew'] = [[]];
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>
    <link rel="shortcut icon" href="assets/branding/favicon.ico" />
    <meta name="description" content="seo_description_goes_here">
    <meta name="keywords" content="seo_keywords_here">

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/1572784ea9.js" crossorigin="anonymous"></script>

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
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

<!--Add Content Form-->
    <div class="container">
        <div class="row">
            <h2 style="margin-bottom: 20px; width: 100%;">Add a Film to Your Profile</h2>
             <form class='content-submission-form' action='EstablishCrew.php' method='post' enctype='multipart/form-data' autocomplete='off'>
                <?php
               if ($_SERVER['REQUEST_METHOD'] == 'POST'){
               echo'<div class="label-input-group">
                    <label>Crew member &#40;leave empty if yourself&#41;</label>
                    <input type="text" placeholder="email@example.com" name="contributor">
                </div>';
               }
               else{
                echo'<div class="label-input-group">
                    <label>Video</label>
                    <input type="text" placeholder="https://www.youtube.com/watch?v=jt_tHQ1hCLI" name="url" required>
                </div>';
                echo'<div class="label-input-group">
                    <label>Crew member &#40;leave empty if yourself&#41;</label>
                    <input type="text" placeholder="email@example.com" name="contributor">
                </div>';
               }
                ?>
                
                <select name = 'subject[]' class="selectpicker" multiple data-live-search="true">
                  <option>Director</option>
                  <option>Screenwriter</option>
                  <option>Story by</option>
                  <option>Producer</option>
                  <option>Production Designer</option>
                  <option>Director of Photography</option>
                  <option>Editor</option>
                  <option>1st Assistant Director</option>
                  <option>2nd Assistant Director</option>
                  <option>1st Camera Assistant</option>
                  <option>2nd Camera Assistant</option>
                  <option>Production Sound Mixer</option>
                  <option>Color Grader</option>
                  <option>Moral Support</option>    
                </select>

                <button class="add-new-contributor-btn">&#43; Add contributor</button>
                <button class="btn btn-primary" type = "submit" name = "finish">Finished: Preview Post</button>
                
                <?php
                    //Print the linked contributors
                    $tmp_array = $_SESSION['establish_crew'];
                    echo "<br><br>Linked Contributors: <br><hr>";
                    //Get arrays out of multidimentional array
                    for ($j = 1; $j<=count($tmp_array)+1;)
                    {   
                        echo $tmp_array[$j][0];
                        echo "<br>";
                        $j++;
                    }
                ?>

            </form>
        </div>
            
        </div>
    
    
    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>
    
    <script src="assets/js/bootstrap-select.min.js"></script>
    
    </body>
</html>