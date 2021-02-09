<?php
include('functions.php');

$mysqli = ConnectDB();

//Video to feature
$username = Get_GetUsername();
$videoid = Get_GetVideoID();

$RoutingNumber = GetUserID($username);



//Remove Featured Status From Video That is Currently Featured
$move2Links = "INSERT INTO links SELECT * FROM featured_links WHERE RoutingNumber = '$RoutingNumber'";
if (mysqli_query($mysqli, $move2Links)) {
$remFeatured = "DELETE FROM featured_links WHERE RoutingNumber = '$RoutingNumber'";
}
else{
    echo "Error: " . $remFeatured . "<br>" . mysqli_error($mysqli);

}


//If That Query is Succesfull...
if (mysqli_query($mysqli, $remFeatured)) {

    //Add Featured Status to New Video
    $setNewfeatured = "INSERT INTO featured_links SELECT * FROM links WHERE id = '$videoid'";

    //If That Query is Succesfull...
    if (mysqli_query($mysqli, $setNewfeatured)) {
        $remLink = "DELETE FROM links WHERE id = '$videoid'";
        if(mysqli_query($mysqli, $remLink)){

    //Route To Profile
    header("location: profile.php?username=$username");
    
    } 
    else{
        echo "Catastrophic Error";
    }
    }
    //Otherwise, Display Error.
    else {
    echo "Error: " . $setNewfeatured . "<br>" . mysqli_error($mysqli);
    }
}

//Otherwise, Display Error.
else {
    echo "Error: " . $remFeatured . "<br>" . mysqli_error($mysqli);
    }

?>
