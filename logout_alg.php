<?php
session_start();
unset($_SESSION['login_user']);
unset($_SESSION['username']);
unset($_SESSION['activation']);
unset($_SESSION['message']);
unset($_SESSION['error']);
unset($_SESSION['try_again']);
$_SESSION['establish_crew'] = [[]];

//This is only here for inital testing of one time codes. WILL BE REMOVED UPON EMAILING SETUP
if (isset($_GET['testroute'])){
    header("location: verifycode.php");
}

else if(!isset($_SESSION["login_user"])){
    header("location: login.php");
}
?>