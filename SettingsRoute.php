<?php
include("functions.php");
$_SESSION['try_again'] = 'TRUE';

$username = Get_GetUsername();
header("location: profile.php?username=$username");
?>