<?php
include("functions.php");

$tmp_array = $_SESSION['establish_crew'];
$url = $_SESSION['url'];
$_POST['contributor'] = '';
for ($j = 1; $j<=count($tmp_array)+1;)
{   
    $Contrib = $tmp_array[$j]; //Gets contributor array
    $email = $Contrib[0]; //Gets email from array

    $Contrib_array_size = (count($Contrib) - 1); //Gets the array size for indexing

    for ($k = 1; $k<=$Contrib_array_size;) //Loops from first contrib value to last
    {
        if ($tmp_array[$j][$k] == 'Director')
        {
            $directorLink = GetFullName_Email($email);
            $directorUN = GetUsername_Email($email);
            if ($directorLink == '' || $directorUN == '')
            {
                $directorLink = 'Unregistered User ('.$email.')';
                $directorUN = '#';
            }
            $director = $email;
        }
        if ($tmp_array[$j][$k] == 'Screenwriter')
        {
            $writerLink = GetFullName_Email($email);
            $writerUN = GetUsername_Email($email);
            if ($writerLink == '' || $writerUN == '')
            {
                $writerLink = 'Unregistered User ('.$email.')';
                $writerUN = '#';
            }
            $writer = $email;
        }
        if ($tmp_array[$j][$k] == 'Story by')
        {
            $storybyLink = GetFullName_Email($email);
            $storybyUN = GetUsername_Email($email);
            if ($storybyLink == '' || $storybyUN == '')
            {
                $storybyLink = 'Unregistered User ('.$email.')';
                $storybyUN = '#';
            }
            $storyby = $email;
        }
        if ($tmp_array[$j][$k] == 'Producer')
        {
            $producerLink = GetFullName_Email($email);
            $producerUN = GetUsername_Email($email);
            if ($producerLink == '' || $producerUN == '')
            {
                $producerLink = 'Unregistered User ('.$email.')';
                $producerUN = '#';
            }
            $producer = $email;
        }
        if ($tmp_array[$j][$k] == 'Production Designer')
        {
            $productiondesignerLink = GetFullName_Email($email);
            $productiondesignerUN = GetUsername_Email($email);
            if ($productiondesignerLink == '' || $productiondesignerUN == '')
            {
                $productiondesignerLink = 'Unregistered User ('.$email.')';
                $productiondesignerUN = '#';
            }
            $productiondesigner = $email;
        }
        if ($tmp_array[$j][$k] == 'Director of Photography')
        {
            $cinematographerLink = GetFullName_Email($email);
            $cinematographerUN = GetUsername_Email($email);
            if ($cinematographerLink == '' || $cinematographerUN == '')
            {
                $cinematographerLink = 'Unregistered User ('.$email.')';
                $cinematographerUN = '#';
            }
            $cinematographer = $email;
        }
        if ($tmp_array[$j][$k] == 'Editor')
        {
            $editorLink = GetFullName_Email($email);
            $editorUN = GetUsername_Email($email);
            if ($editorLink == '' || $editorUN == '')
            {
                $editorLink = 'Unregistered User ('.$email.')';
                $editorUN = '#';
            }
            $editor = $email;
        }
        if ($tmp_array[$j][$k] == '1st Assistant Director')
        {
            $firstadLink = GetFullName_Email($email);
            $firstadUN = GetUsername_Email($email);
            if ($firstadLink == '' || $firstadUN == '')
            {
                $firstadLink = 'Unregistered User ('.$email.')';
                $firstadUN = '#';
            }
            $firstad = $email;
        }
        if ($tmp_array[$j][$k] == '2nd Assistant Director')
        {
            $secondadLink = GetFullName_Email($email);
            $secondadUN = GetUsername_Email($email);
            if ($secondadLink == '' || $secondadUN == '')
            {
                $secondadLink = 'Unregistered User ('.$email.')';
                $secondadUN = '#';
            }
            $secondad = $email;
        }
        if ($tmp_array[$j][$k] == '1st Camera Assistant')
        {
            $firstacLink = GetFullName_Email($email);
            $firstacUN = GetUsername_Email($email);
            if ($firstacLink == '' || $firstacUN == '')
            {
                $firstacLink = 'Unregistered User ('.$email.')';
                $firstacUN = '#';
            }
            $firstac = $email;
        }
        if ($tmp_array[$j][$k] == '2nd Camera Assistant')
        {
            $secondacLink = GetFullName_Email($email);
            $secondacUN = GetUsername_Email($email);
            if ($secondacLink == '' || $secondacUN == '')
            {
                $secondacLink = 'Unregistered User ('.$email.')';
                $secondacUN = '#';
            }
            $secondac = $email;
        }
        if ($tmp_array[$j][$k] == 'Production Sound Mixer')
        {
            $productionsmLink = GetFullName_Email($email);
            $productionsmUN = GetUsername_Email($email);
            if ($productionsmLink == '' || $productionsmUN == '')
            {
                $productionsmLink = 'Unregistered User ('.$email.')';
                $productionsmUN = '#';
            }
            $productionsm = $email;
        }
        if ($tmp_array[$j][$k] == 'Color Grader')
        {
            $colorgraderLink = GetFullName_Email($email);
            $colorgraderUN = GetUsername_Email($email);
            if ($colorgraderLink == '' || $colorgraderUN == '')
            {
                $colorgraderLink = 'Unregistered User ('.$email.')';
                $colorgraderUN = '#';
            }
            $colorgrader = $email;
        }
        if ($tmp_array[$j][$k] == 'Moral Support')
        {
            $moralsupportLink = GetFullName_Email($email);
            $moralsupportUN = GetUsername_Email($email);
            if ($moralsupportLink == '' || $moralsupportUN == '')
            {
                $moralsupportLink = 'Unregistered User ('.$email.')';
                $moralsupportUN = '#';
            }
            $moralsupport = $email;
        }

        $k++; //Update iterator
    }

    $j++;
}

$id = GetUserID(GetCurrentUsername());

//--Fetch Video Info For Youtube--//
$link = $url;

if(strpos($link, "youtube")){
                    
    $fetch=explode("v=", $link);
    $videoid=$fetch[1];

    if(strpos($videoid, "&"))
    {
        $videoid = substr($videoid, 0, strpos($videoid, '&'));
    }

    $apikey = //Hidden because of public sharing;   
    
    $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
    $ytdata = json_decode($json);
    
    $title = $ytdata->items[0]->snippet->title;
    $description =$ytdata->items[0]->snippet->description;
    $description = substr($description, 0, 500);
}

//--Fetch Video Info For Vimeo
else if (strpos($link, "vimeo")){
                        
    //Fetch videoid
    $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
    $videoid = (int)$urlParts[count($urlParts)-1];

    //Fetch title using Vimeo api
    $hash = json_decode(file_get_contents("http://vimeo.com/api/v2/video/{$videoid}.json"));
    $title = $hash[0]->title;
    $description = $hash[0]->description;
    $description = substr($description, 0, 500);
}
?>
   
    <!DOCTYPE HTML>
    <html>
    <head>
    <meta charset="utf-8">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- FontAwesome Icons -->
<script src="https://kit.fontawesome.com/1572784ea9.js" crossorigin="anonymous"></script>

<!-- CSS Stylesheets -->
<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="assets/css/custom.css">

    </head>
    <body>
    <!-- Modal Fullscreen xl -->
            
            <div class="container small-margin">
                <div class="row profile-page-head">
                    <h1>Post Preview<hr> <br><?php echo $title?></h1>
                    <?php
            echo'
            <a href="profile.php?username='.GetCurrentUsername().'"><h4>'.GetFullName(GetCurrentUsername()).'</h4></a>';
            ?>
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
            </div>
            
            <div class="container medium-margin">
                <div class="row">
                    <div class="col-lg-5 col-md-6 offset-lg-1 margin-bottom-mobile">
                    <?php
                    $username = GetBio(GetCurrentUsername());
                    $bio = GetBio($username);
                    if ($description != '')
                    {
                    echo"
                    <h5>Film description</h5>
                    <div style='white-space: pre-wrap;'>$description</div>";
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
                echo "<br><h6>Do you see your name below? If not, make sure to go back and specify your contribution!</h6><br>";
                echo "<h5>Crew</h5>";
                if ($directorUN != ""){
                echo"<p><b>Director: </b><a href='profile.php?username=$directorUN'>$directorLink</p></a>";}
                
                if ($writerUN != ""){
                echo "<p><b>Screenwriter: </b><a href='profile.php?username=$writerUN'>$writerLink</p></a>";}
                
                if ($storybyUN != ""){
                echo "<p><b>Story By: </b><a href='profile.php?username=$storybyUN'>$storybyLink</p></a>";}
                
                if ($producerUN != ""){
                echo"<p><b>Producer: </b><a href='profile.php?username=$producerUN'>$producerLink</p></a>";}
                
                if ($productiondesignerUN != ""){
                echo"<p><b>Production Designer: </b><a href='profile.php?username=$productiondesignerUN'>$productiondesignerLink</p></a>";}
                
                if ($cinematographerUN != ""){
                echo "<p><b>Director of Photography: </b><a href='profile.php?username=$cinematographerUN'>$cinematographerLink</p></a>";}
                
                if ($editorUN != ""){
                echo"<p><b>Editor: </b><a href='profile.php?username=$editorUN'>$editorLink</p></a>";}
                
                if ($firstadUN != ""){
                echo "<p><b>1st Assistant Director: </b><a href='profile.php?username=$firstadUN'>$firstadLink</p></a>";}
                
                if ($secondadUN != ""){
                echo "<p><b>2nd Assistant Director: </b><a href='profile.php?username=$secondadUN'>$secondadLink</p></a>";}
                
                if ($firstadUN != ""){
                echo "<p><b>1st Assistant Camera: </b><a href='profile.php?username=$firstacUN'>$firstacLink</p></a>";}
                
                if ($secondacUN != ""){
                echo "<p><b>2nd Assistant Camera: </b><a href='profile.php?username=$secondacUN'>$secondacLink</p></a>";}
                
                if ($productionsmUN != ""){
                echo "<p><b>Production Sound Mixer: </b><a href='profile.php?username=$productionsmUN'>$productionsmLink</p></a>";}
                
                if ($colorgraderUN != ""){
                echo "<p><b>Color Grader: </b><a href='profile.php?username=$colorgraderUN'>$colorgraderLink</p></a>";}
                
                if ($moralsupportUN != ""){
                echo "<p><b>Moral Support: </b><a href='profile.php?username=$moralsupportUN'>$moralsupportLink</p></a>";}
                }

                else{
                    $fullname = GetFullName(GetCurrentUsername());
                    echo "<h5>Solo Project</h5>";
                    echo "<p>$fullname worked on this project alone</p>";
                }
                
                ?>
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <?php echo "<button type='button' onclick='history.back()' class='btn btn-secondary'>Return to edit</button>"; ?>
            <?php echo"<a href = 'confirm.php?director=$director&writer=$writer&storyby=$storyby&producer=$producer&productiondesigner=$productiondesigner&cinematographer=$cinematographer&editor=$editor&firstad=$firstad&secondad=$secondad&firstac=$firstac&secondac=$secondac&productionsm=$productionsm&colorgrader=$colorgrader&moralsupport=$moralsupport'><button type='button' class='btn btn-primary-og'>Publish</button></a>"; ?>
          </div>
        </div>
      </div>
    </div>
    </body>
</html>