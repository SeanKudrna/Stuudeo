<?php
//--Include Statments--//
include('functions.php');
include("vendor/autoload.php");
include("config-cloud.php");
$_SESSION['message'] = '';

//--Start Session--//
session_start();
$mysqli = ConnectDB();



//--Prevent Access Without Code--//
if (!isset($_SESSION['activation'])){
  header("location: verifycode.php");
}

//--Check For Form Completion--//
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $sql = 'SELECT username FROM users';
    $result = $mysqli->query($sql); 
    while($row = $result->fetch_assoc()){

//--Prevent Duplication Of Usernames--//
      if (strtolower($row['username']) == strtolower($_POST['username'])){
        $_SESSION['message'] = 'That username has already been taken';
        $flag = false;
      break;
      }

      else
          $flag = true; 
    }

    if ($flag){

//--Check That Both Passwords Are Equal To Eachother--//
  if($_POST['password'] == $_POST['confirmpassword']){

    if (userExists_Email($_POST['email']))
    {
      $_SESSION['message'] = "An account with this email already exists.\n
      If you haven't made an account before, please sign in with the first part of your email (before the @) and the password STunclaimedAccnts123!";
    }
    else{

//--Set And Save Vital Data--//
    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);

    $firstname = $mysqli->real_escape_string($_POST['firstname']);
    $lastname = $mysqli->real_escape_string($_POST['lastname']);
    $password = md5($_POST['password']);
    $avatar_path = $mysqli->real_escape_string('images/'.$_FILES['avatar']['name']);
    $location = '';
  

//--Verify File Type Is An Image--//
    if (preg_match("!image!", $_FILES['avatar']['type'])){

      $name= $_FILES['avatar']['name'];
      $tmp_name= $_FILES['avatar']['tmp_name'];
      $size= $_FILES['avatar']['size'];


//--Limit File Size to 20MB--//
      if ($size < 20971520)
      {

        $_SESSION['username'] = $username;

//--Insert User Into Database--//
        $sql = "INSERT INTO users (username, password, firstname, lastname, email, avatar, location, featured, bio, actor, instagram, twitter, linkedin) "
                ."VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$avatar_path', '$location', '0', '', '0', '', '', '')";

//Strip .jpg, .jpeg, .png, etc From image name before upload
      $avatar_path = substr($avatar_path, 0, strpos($avatar_path, '.'));

//Upload image to cloudinary
      \Cloudinary\Uploader::upload($tmp_name, array("public_id" => $avatar_path));

//--Login, Route To Homepage--//
        if($mysqli->query($sql) === true){
          $_SESSION['login_user'] = $username;
          $_SESSION['username'] = $username;
          header("location: index.php");
        }

//--If Error Adding User To Database, Display Message--//
        else{
          $_SESSION['message'] = "User could not be added to database.";
        }

    }
    else {
      $_SESSION['message'] = "Please select a file under 20MB.";
    }
    }

//--If User Doesnt Select Image, Provide Default--//
    else{
      $sql = "INSERT INTO users (username, password, firstname, lastname, email, avatar, location, featured, bio, actor, instagram, twitter, linkedin) "
      ."VALUES ('$username', '$password', '$firstname', '$lastname', '$email', 'images/default.png', '$location', '0', '', '0', '', '', '')";

//--Route To Homepage--//
      if($mysqli->query($sql) === true){
      $_SESSION['login_user'] = $username; 
      $_SESSION['username'] = $username;
      // header("location: profile.php?username=$username");
      header("location: $username");
      }
    }
  }
}

//--If Passwords Dont Match, Display Message--//
  else{
    $_SESSION['message'] = "Passwords do not match.";
  }

}
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Stuudeo</title>
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

<!--NavBar-->
<?php NavBar() ?>
       
<!--Registration Form-->
    <div class="login-register-page">
        <div class="container">
            <div class="row form-container" id="register-form">
                <form class = "login-form" action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <?php

//--Check For Activation Success--//

                    if (isset($_SESSION['activation'])){
                    echo'
                    <div class="alert alert-success"> '.$_SESSION['activation'].'</div>';
                    }
                ?>
                    <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                    <input type = "text" placeholder = "Username" name = "username" required/>
                    <input type = "email" placeholder = "Email" name = "email" required/>
                    <input type = "firstname" placeholder = "First Name" name = "firstname" required/>
                    <input type = "lastname" placeholder = "Last Name" name = "lastname" required/>
                    <input type = "password" placeholder = "Password" name = "password" required>
                    <input type = "password" placeholder = "Confirm Password" name="confirmpassword" required/>
                    <p>SELECT YOUR AVATAR:</p><input type="file" name="avatar" accept="image/jpeg, image/png, image/webp">
                    <button>Create</button>
                </form>
                <p style="margin-top: 15px;">Already Registered? <a href= "login">Login</a></p>
            </div>
        </div>
    </div>



    <!-- BOOTSTRAP REQUIRED RESOURCES -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>