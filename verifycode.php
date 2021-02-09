<?php
//--Include Statments--//
include('functions.php');

//--Start Session--//
$_SESSION['message'] = '';
$mysqli = ConnectDB();
session_start();

$flag = false;

if (isset($_SESSION['login_user']) && $_SESSION['username'] != "Guest"){
    header("location: index.php");
}

//--Check For Form Submission--//
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $code = $_POST['code'];

//--UNCOMMENT IF WE EVER NEED TO HAVE UNIQUE CODES AGAIN--//
//--Check For Invalid Code--//
//    $sql = "SELECT * FROM one_time_codes";
//    $result = $mysqli->query($sql);
//    while($row = $result->fetch_assoc()){
//     if ($row['code'] != $code){
//        $_SESSION['message'] = 'That activation code is invalid.';
//      }
//      else
//          $flag = true; 
//    }

//--If Code Is Correct, Delete Code From Database And Authorize Registration--//
//   if ($flag){

//        $removeCode = "DELETE FROM one_time_codes WHERE code = '$code'";

//        if($mysqli->query($removeCode) === true){

//--Route To Registration With Succesfull Activation Message--//
        if ($code == 'GR3XVCNZ_PID3HL'){
          $_SESSION['activation'] = "STuuDEO Activation Code Verified!";
          header("location: register");
        }

//--If Code Could Not Be Validated Due To Some Internal Error, Display Message--//
        else{$_SESSION['message'] = "This code could not be validated at this time. Please try again later or contact STuuDEO support for assistance."; }

    }
//}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation | Stuudeo</title>
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
<body style="padding: 0;">

<!--NavBar-->
<?php NavBar();?>
       
<!--Code Validation Form-->
    <div class="login-register-page">
        <div class="container">
            <div class="row form-container" id="register-form">
                <form class = "login-form" action="verifycode.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['message'])){
                        $errorM = $_SESSION['message'];
                    echo'
                    <div class="alert alert-error"> '.$_SESSION['message'].'</div>';
                    }
                    ?>
                    <input type = "text" placeholder = "Enter Your Stuudeo Activation Code" name = "code" required/>
                    <button>Activate Me!</button>
                </form>
                <p style="margin-top: 15px; margin-bottom: 0;">Already Registered? <a href= "login">Login</a></p>

            </div>
        </div>
    </div>
    </body>
</html>
