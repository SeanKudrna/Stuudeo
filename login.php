<?php
//--Include Statments--//
include('functions.php');
session_start();

if(isset($_SESSION['login_user']) && $_SESSION['username'] != "Guest"){
    header("location: index.php"); 
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Stuudeo</title>
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
<body style="padding: 0;">
    <?php NavBar(); ?>
        
    <div class="login-register-page">
        <div class="container">
            <div class="row form-container">
                <form class="login-form" action = "login.php" method="POST">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $errorM = $_SESSION['message'];
                    echo'
                    <div class="alert alert-error"> '.$errorM.'</div>';
                    }
                    ?>
                    <input type = "text" name = "username" id = "username" placeholder = "Username" required/>
                    <input type = "password" name = "password" id = "password" placeholder = "Password" required/>
                    <button type = "submit" name = "login">Login</button>
                </form>
                
                <p style="margin-top: 15px;">Not Registered? <a href="verifycode">Register</a></p>
                <p>Or</p>
                <p style="margin-bottom: 0;"><a href = "guest_route.php">Continue as a Guest</a></p>
            </div>
        </div>
        
    </div>

    <!-- BOOTSTRAP REQUIRED RESOURCES -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    </body>
</html>

<?php

    session_start(); // Starting Session
    $error = ''; // Variable To Store Error Message
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['message'] = "Username or Password was incorrect";
    }

    else{
        // Define $username and $password
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // mysqli_connect() function opens a new connection to the MySQL server.
        $conn = ConnectDB();

        // SQL query to fetch information of registerd users and finds user match.
        $query = "SELECT username, password from users where username=? AND password=? LIMIT 1";

        // To protect MySQL injection for Security purpose
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($username, $password);
        $stmt->store_result();
        
        if($stmt->fetch()) {//fetching the contents of the row {
            $_SESSION['login_user'] = $username; // Initializing Session
            $_SESSION['username'] = $username; //sets current username
            $_SESSION['establish_crew'] = [[]];
            unset($_SESSION['message']); //Unset any error messages
            if ($username == 'STuuDEOAdmin'){header("location: explore.php");} //If Stuudeo Admin, route to explore
            else{header("location: index.php");} //If standard user, route to profile
        }

        else{
            $_SESSION['message'] = "Username or Password was incorrect.";
            header("location: login.php");
        }

    }
    mysqli_close($conn); // Closing Connection

?>
