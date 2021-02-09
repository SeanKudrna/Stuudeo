<?php
include('functions.php');

$mysqli = ConnectDB();

//Video to feature
$username = Get_GetUsername();
$videoid = Get_GetVideoID();

$RoutingNumber = GetUserID($username);



//Remove Featured Status From Video That is Currently Featured
$move2Links = "INSERT INTO links SELECT * FROM featured_links WHERE RoutingNumber = '$RoutingNumber'";
mysqli_query($mysqli, $move2Links);

$remFeatured = "DELETE FROM featured_links WHERE RoutingNumber = '$RoutingNumber'";
mysqli_query($mysqli, $remFeatured);


header("location: profile.php?username=$username");

?>