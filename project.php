<?php
//--Include Statments--//
include('session.php');
include('functions.php');
unset($_SESSION['try_again']);
unset($_SESSION['error']);


//Auto Log In As Guest
if(!isset($_SESSION['login_user'])){
$_SESSION['login_user'] = 'Guest';
$_SESSION['username'] = 'Guest';
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php

    //--Set And Save Vital Data--//
    $username = Get_GetUsername();
    $link = Get_GetLink();
    $id = GetUserID($username);
    $fullname = GetFullName($username);
    $bio = GetBio($username);

    //--Start Session--//
    $mysqli = ConnectDB();


    //--Fetch Video Info For Youtube--//
    if(strpos($link, "youtube")){

        $fetch=explode("v=", $link);
        $videoid=$fetch[1];

        $apikey = //Hidden because of public sharing;   

        $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
        $ytdata = json_decode($json);

        $title = $ytdata->items[0]->snippet->title;
        $YTflag = 1;
        $description =$ytdata->items[0]->snippet->description;
        $description = substr($description, 0, 500);
        $description_short = substr($description, 0, 160);
    }

    //--Fetch Video Info For Vimeo
    else if (strpos($link, "vimeo")){

        //Fetch videoid
        $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
        $videoid = (int)$urlParts[count($urlParts)-1];

        //Fetch title using Vimeo api
        $hash = json_decode(file_get_contents("http://vimeo.com/api/v2/video/{$videoid}.json"));
        $title = $hash[0]->title;
        $YTflag = 0;
        $description = $hash[0]->description;
        $description = substr($description, 0, 500);
        $description_short = substr($description, 0, 160);
    }

    ?>

    <!--Project Title-->
    <title><?php echo"$title - $fullname"?></title>
    <link rel="shortcut icon" href="assets/branding/favicon.ico" />
    <meta name="description" content="<?php echo "$description_short"?>...">

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

<!--Show Video-->
<div class="container small-margin">
        <div class="row profile-page-head">
            <h1><?php echo $title?></h1>
            <?php
            echo'
            <a href="profile.php?username='.$username.'"><h4>'.$fullname.'</h4></a>';
            ?>
        </div>
    </div>
    
    <div class="container small-margin">
        <div class="row">
            <div class="col-lg-12">
                <div class="iframe-container">
                    <?php
                    if(strpos($link, "youtube")){
                    echo'
                    <iframe src="https://www.youtube.com/embed/'.$videoid.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }
                    else if (strpos($link, "vimeo")){
                    echo'
                    <iframe src="https://player.vimeo.com/video/'.$videoid.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<!--Fetch Contributer Data-->
<?php
$sql = "SELECT * FROM links WHERE RoutingNumber = '$id' AND link = '$link'";
$result = $mysqli->query($sql);
$i = 0;

while($row = $result->fetch_assoc()){


//--Fetch Director Info from Email--//
    $director = $row['director'];
    
    $directorLink = GetFullName_Email($director);
    $directorUN = GetUsername_Email($director);

//--Fetch Editor Name from Email--//
    $editor = $row['editor'];

    $editorLink = GetFullName_Email($editor);
    $editorUN = GetUsername_Email($editor);

//--Fetch Writer Name from Username--//
    $writer = $row['writer'];

    $writerLink = GetFullName_Email($writer);
    $writerUN = GetUsername_Email($writer);

//--Fetch Producer Name from Username--//
    $producer = $row['producer'];

    $producerLink = GetFullName_Email($producer);
    $producerUN = GetUsername_Email($producer);


//--Fetch Cinematographer Name from Username--//
    $cinematographer = $row['cinematographer'];

    $cinematographerLink = GetFullName_Email($cinematographer);
    $cinematographerUN = GetUsername_Email($cinematographer);

//--Fetch Story By Name from Username--//
    $storyby = $row['storyby'];

    $storybyLink = GetFullName_Email($storyby);
    $storybyUN = GetUsername_Email($storyby);

//--Fetch Production Designer Name from Username--//
    $productiondesigner = $row['productiondesigner'];

    $productiondesignerLink = GetFullName_Email($productiondesigner);
    $productiondesignerUN = GetUsername_Email($productiondesigner);

//--Fetch 1st AD Name from Username--//
    $firstad = $row['1stassistantdirector'];

    $firstadLink = GetFullName_Email($firstad);
    $firstadUN = GetUsername_Email($firstad);

//--Fetch 2nd AD Name from Username--//
    $secondad = $row['2ndassistantdirector'];

    $secondadLink = GetFullName_Email($secondad);
    $secondadUN = GetUsername_Email($secondad);

//--Fetch 1st AC Name from Username--//
    $firstac = $row['1stassistantcamera'];

    $firstacLink = GetFullName_Email($firstac);
    $firstacUN = GetUsername_Email($firstac);

//--Fetch 2nd AC Name from Username--//
    $secondac = $row['2ndassistantcamera'];

    $secondacLink = GetFullName_Email($secondac);
    $secondacUN = GetUsername_Email($secondac);

//--Fetch Production Sound Mixer Name from Username--//
    $productionsm = $row['productionsoundmixer'];

    $productionsmLink = GetFullName_Email($productionsm);
    $productionsmUN = GetUsername_Email($productionsm);

//--Fetch Color Grader Name from Username--//
    $colorgrader = $row['colorgrader'];

    $colorgraderLink = GetFullName_Email($colorgrader);
    $colorgraderUN = GetUsername_Email($colorgrader);

//--Fetch Moral Support Name from Username--//
    $moralsupport = $row['moralsupport'];

    $moralsupportLink = GetFullName_Email($moralsupport);
    $moralsupportUN = GetUsername_Email($moralsupport);

    $i++;

}

//--If Video Isnt Found In Links-> Its A Featured Video. Gather Data--//
if($i <= 0)
{
$sql = "SELECT * FROM featured_links WHERE RoutingNumber = '$id' AND link = '$link'";
$result = $mysqli->query($sql);

while($row = $result->fetch_assoc()){


//--Fetch Director Info from Email--//
    $director = $row['director'];
    
    $directorLink = GetFullName_Email($director);
    $directorUN = GetUsername_Email($director);

//--Fetch Editor Name from Email--//
    $editor = $row['editor'];

    $editorLink = GetFullName_Email($editor);
    $editorUN = GetUsername_Email($editor);

//--Fetch Writer Name from Username--//
    $writer = $row['writer'];

    $writerLink = GetFullName_Email($writer);
    $writerUN = GetUsername_Email($writer);

//--Fetch Producer Name from Username--//
    $producer = $row['producer'];

    $producerLink = GetFullName_Email($producer);
    $producerUN = GetUsername_Email($producer);


//--Fetch Cinematographer Name from Username--//
    $cinematographer = $row['cinematographer'];

    $cinematographerLink = GetFullName_Email($cinematographer);
    $cinematographerUN = GetUsername_Email($cinematographer);

    //--Fetch Story By Name from Username--//
    $storyby = $row['storyby'];

    $storybyLink = GetFullName_Email($storyby);
    $storybyUN = GetUsername_Email($storyby);

//--Fetch Production Designer Name from Username--//
    $productiondesigner = $row['productiondesigner'];

    $productiondesignerLink = GetFullName_Email($productiondesigner);
    $productiondesignerUN = GetUsername_Email($productiondesigner);

//--Fetch 1st AD Name from Username--//
    $firstad = $row['1stassistantdirector'];

    $firstadLink = GetFullName_Email($firstad);
    $firstadUN = GetUsername_Email($firstad);

//--Fetch 2nd AD Name from Username--//
    $secondad = $row['2ndassistantdirector'];

    $secondadLink = GetFullName_Email($secondad);
    $secondadUN = GetUsername_Email($secondad);

//--Fetch 1st AC Name from Username--//
    $firstac = $row['1stassistantcamera'];

    $firstacLink = GetFullName_Email($firstac);
    $firstacUN = GetUsername_Email($firstac);

//--Fetch 2nd AC Name from Username--//
    $secondac = $row['2ndassistantcamera'];

    $secondacLink = GetFullName_Email($secondac);
    $secondacUN = GetUsername_Email($secondac);

//--Fetch Production Sound Mixer Name from Username--//
    $productionsm = $row['productionsoundmixer'];

    $productionsmLink = GetFullName_Email($productionsm);
    $productionsmUN = GetUsername_Email($productionsm);

//--Fetch Color Grader Name from Username--//
    $colorgrader = $row['colorgrader'];

    $colorgraderLink = GetFullName_Email($colorgrader);
    $colorgraderUN = GetUsername_Email($colorgrader);

//--Fetch Moral Support Name from Username--//
    $moralsupport = $row['moralsupport'];

    $moralsupportLink = GetFullName_Email($moralsupport);
    $moralsupportUN = GetUsername_Email($moralsupport);

}
}

?>

<!--Film Description-->
<div class="container medium-margin">
    <div class="row">
        <div class="col-lg-5 col-md-6 offset-lg-1 margin-bottom-mobile">
            <?php
            if ($description != '')
            {
                // YouTube videos should have white-space: pre-wrap, while Vimeo videos should have white-space: normal

                if ($YTflag == 1)
                {
                echo"
                <h5>Film description</h5>
                <div style='white-space: pre-wrap;'>$description</div>";
                }

                else if ($YTflag == 0)
                {
                echo"
                <h5>Film description</h5>
                <div style='white-space: normal;'>$description</div>";
                }
            }
            else
            {
                if ($bio == '')
                {
                    $bio = 'Enjoy the show!';
                    echo"
                    <h5>Proud Stuudeo Creator</h5>
                    <div style='white-space: pre-wrap;'>$bio</div>";

                }
                else
                {
                    echo"
                    <h5>About This Filmmaker</h5>
                    <div style='white-space: pre-wrap;'>$bio</div>";
                }
            }

            ?>
        </div>
        <div class="col-lg-5 col-md-6 offset-lg-1 contributors">

<!--Contributers-->
                <?php
                if ($directorUN != '' || $writerUN != "" || $storybyUN != "" || $producerUN != "" || $productiondesignerUN != "" || $cinematographerUN != "" || $editorUN != "" || $firstadUN != "" || $secondadUN != "" || $firstacUN != "" || $secondacUN != "" || $productionsmUN != "" || $colorgraderUN != "" || $moralsupportUN != "")
                {
                echo "<h5>Crew</h5>";

                if ($directorUN != ""){
                echo"<p><b>Director: </b><a href='profile.php?username=$directorUN'>$directorLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'dir'>
                    <input type='email' placeholder='Director Email' name = 'director' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link DIR.</button><br><br>
                    </form>";}}
                if ($editorUN != ""){
                echo"<p><b>Editor: </b><a href='profile.php?username=$editorUN'>$editorLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'edi'>
                    <input type='email' placeholder='Editor Email' name = 'editor' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link EDT.</button><br><br>
                    </form>";}}
                if ($writerUN != ""){
                echo "<p><b>Screenwriter: </b><a href='profile.php?username=$writerUN'>$writerLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'wri'>
                    <input type='email' placeholder='Writer Email' name = 'writer' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link WRT.</button><br><br>
                     </form>";}}
                if ($producer != ""){
                echo"<p><b>Producer: </b><a href='profile.php?username=$producerUN'>$producerLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'pro'>
                    <input type='email' placeholder='Producer Email' name = 'producer' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link PRO.</button><br><br>
                    </form>";}}
                if ($cinematographerUN != ""){
                echo "<p><b>Cinematographer: </b><a href='profile.php?username=$cinematographerUN'>$cinematographerLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Cinematographer Email' name = 'cinematographer' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link DOP.</button><br><br>
                    </form>";}}
                if ($storybyUN != ""){
                echo "<p><b>Story By: </b><a href='profile.php?username=$storybyUN'>$storybyLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Story By Email' name = 'storyby' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link STB.</button><br><br>
                    </form>";}}
                if ($productiondesignerUN != ""){
                echo "<p><b>Production Designer: </b><a href='profile.php?username=$productiondesignerUN'>$productiondesignerLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Production Designer Email' name = 'productiondesigner' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link PDS.</button><br><br>
                    </form>";}}
                if ($firstadUN != ""){
                echo "<p><b>1st Assistant Director: </b><a href='profile.php?username=$firstadUN'>$firstadLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='1st Assistant Director Email' name = 'firstad' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link FAD.</button><br><br>
                    </form>";}}
                if ($secondadUN != ""){
                echo "<p><b>2nd Assistant Director: </b><a href='profile.php?username=$secondadUN'>$secondadLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='2nd Assistant Director Email' name = 'secondad' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link SAD.</button><br><br>
                    </form>";}}
                if ($firstacUN != ""){
                echo "<p><b>1st Assistant Camera: </b><a href='profile.php?username=$firstacUN'>$firstacLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='1st Assistant Camera Email' name = 'firstac' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link FAC.</button><br><br>
                    </form>";}}
                if ($secondacUN != ""){
                echo "<p><b>2nd Assistant Camera: </b><a href='profile.php?username=$secondacUN'>$secondacLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='2nd Assistant Camera Email' name = 'secondac' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link SAC.</button><br><br>
                    </form>";}}
                if ($productionsm != ""){
                echo "<p><b>Production Sound Mixer: </b><a href='profile.php?username=$productionsmUN'>$productionsmLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Production Sound Mixer Email' name = 'productionsm' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link PSM.</button><br><br>
                    </form>";}}
                if ($colorgrader != ""){
                echo "<p><b>Color Grader: </b><a href='profile.php?username=$colorgraderUN'>$colorgraderLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Color Grader Email' name = 'colorgrader' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link CGR.</button><br><br>
                    </form>";}}
                if ($moralsupport != ""){
                echo "<p><b>Moral Support: </b><a href='profile.php?username=$moralsupportUN'>$moralsupportLink</p></a>";}
                else{
                if ($_SESSION['login_user'] == $username){
                echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Moral Support Email' name = 'moralsupport' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link MSP.</button><br><br>
                    </form>";}}
                }
                else{
                    echo "<h5>Solo Project</h5>";
                    echo "<p>$fullname worked on this project alone</p>";

                    if ($_SESSION['login_user'] == $username){
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'dir'>
                    <input type='email' placeholder='Director Email' name = 'director' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link DIR.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'edi'>
                    <input type='email' placeholder='Editor Email' name = 'editor' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link EDT.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'wri'>
                    <input type='email' placeholder='Writer Email' name = 'writer' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link WRT.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'pro'>
                    <input type='email' placeholder='Producer Email' name = 'producer' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link PRO.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Cinematographer Email' name = 'cinematographer' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link DOP.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Story By Email' name = 'storyby' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link STB.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Production Designer Email' name = 'productiondesigner' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link PDS.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='1st Assistant Director Email' name = 'firstad' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link FAD.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='2nd Assistant Director Email' name = 'secondad' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link SAD.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='1st Assistant Camera Email' name = 'firstac' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link FAC.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='2nd Assistant Camera Email' name = 'secondac' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link SAC.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Production Sound Mixer Email' name = 'productionsm' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link PSM.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Color Grader Email' name = 'colorgrader' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link CGR.</button><br><br>
                    </form>";
                    echo"<form method = 'POST' action = 'addContrib.php?link=$link&username=$username&id=$id' style='margin: -10px 0 0;' name = 'cin'>
                    <input type='email' placeholder='Moral Support Email' name = 'moralsupport' style='margin: 0; padding: 5px; width: 300px; max-width: 100%;'>
                    &ensp;
                    <button class='btn-primary'>Link MSP.</button><br><br>
                    </form>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    
<!--More Videos By Section-->
    <div class="container small-margin"> 
        <div class="row user-feed">
            <?php
                if (GetNumVideos($username) > 1)
                {
                $firstname = GetFirstName($username);
                echo"<div class='col-lg-12'><h2>More films from $firstname</h2></div>";
                $sql = "SELECT * FROM links WHERE RoutingNumber = '$id' AND link != '$link' ORDER BY RAND() LIMIT 2";
                $result = $mysqli->query($sql);
            
                while ($row = $result->fetch_assoc()){
        
                $dblink = $row['link'];
                    
//--Youtube--//
                if(strpos($dblink, "youtube")){
                    
                    $fetch=explode("v=", $dblink);
                    $videoid=$fetch[1];

                    if(strpos($videoid, "&"))
                    {
                        $videoid = substr($videoid, 0, strpos($videoid, '&'));
                    }

                    $apikey = //Hidden because of public sharing;   
    
                     $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
                     $ytdata = json_decode($json);
    
                     $title = $ytdata->items[0]->snippet->title;
                    if ($dblink != $link)
                    {
                     echo'
                        <div class="col-lg-6 user-feed-item"> 
                          <a href="project.php?link='.$dblink.'&username='.$username.'"><img src="http://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                         <a href="project.php?link='.$dblink.'&username='.$username.'"><h3>'.$title.'</h3></a>
                         <a href="project.php?link='.$dblink.'&username='.$username.'" class="btn-primary">Watch Now</a>
                     </div>';
                    }
            }

//--Vimeo--//
            else if (strpos($dblink, "vimeo")){

                $urlParts = explode("/", parse_url($dblink, PHP_URL_PATH));
                $videoid = (int)$urlParts[count($urlParts)-1];

                //Get thumbnail from link
                $thumbnail = GetVimeoThumbnail($dblink);

                //Strip thumbnail dimensions off of image url for stylizing purposes.
                $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
                //Fetch title using Vimeo api
                $hash = json_decode(file_get_contents("http://vimeo.com/api/v2/video/{$videoid}.json"));
                $title = $hash[0]->title;

                
                echo'
                <div class="col-lg-6 user-feed-item"> 
                    <a href="project.php?link='.$dblink.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                    <a href="project.php?link='.$dblink.'&username='.$username.'"><h3>'.$title.'</h3></a>
                    <a href="project.php?link='.$dblink.'&username='.$username.'" class="btn-primary">Watch Now</a>
                </div>';
                }
            } 
        }
        
            ?>
        </div>
    </div>
    
   
    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>

</body>
</html>