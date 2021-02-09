<?php
//--Include Statment--//
include('functions.php');

//--Start Session--//
$mysqli = ConnectDB();

//Video to feature
$username = Get_GetUsername();
$videoid = Get_GetVideoID();


$remLink = "DELETE FROM links WHERE id = '$videoid'";
if(mysqli_query($mysqli, $remLink)){

//--Route Back To Profile Page--//
    header("location: profile.php?username=$username");
    
} 

//--If Video Fails To Delete, Display Error Message--//
else{echo "Catastrophic Error";}


?>
