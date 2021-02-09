<?php

//--Include Statments---//
include('session.php');
include("vendor/autoload.php");
include("config-cloud.php");
$mysqli = ConnectDB();



//                             //
//-----{GENERAL FUNCTIONS}-----//
//                             //



//--Generate Code--//
function GenTempPassword()
{
    //Start Session
    session_start();
    $mysqli = ConnectDB();

    //Possible Characters
    $gen = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

    //Generate Code (1 in 1,037,158,320 Chance of Generating The Same Code Twice)
    $one_time_code =  substr(str_shuffle($gen), 0, 8) . '_' . substr(str_shuffle($gen), 0, 6);

    //Log Code in Database
    $log_code = "INSERT INTO one_time_codes (code)" 
    . "VALUES ('$one_time_code')";
   

    if($mysqli->query($log_code) === true){
        return $one_time_code;
    }
}


//---Connect to Database---//
function ConnectDB()
{
$mysqli = new mysqli(/*Hidden DB info for Public Sharing*/);//reset server connection

    //This is for localhost db
    //$mysqli = new mysqli(Hidden DB info for Public Sharing);//reset server connection
    return $mysqli;
}

//--Display NavBar--//
function NavBar()
{
    //Add To navbar-nav ml-auto flex-nowrap ul for Search

    //<form class="form-inline my-2 my-lg-0 ml-auto" action="profile.php" method="GET" style="text-align:center;">
        //<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="username" name="username">
        //<button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
    //</form>

    echo'
    <div class="nav-container">
    <nav class="navbar navbar-expand-sm navbar-light">
        <a class="navbar-brand navbar-brand-full" href="index.php"><img src="assets/branding/logo_full.png" alt="Stuudeo Logo"></a>
        <a class="navbar-brand navbar-brand-small" href="index.php"><img src="assets/branding/logo_small.png" alt="Stuudeo Condensed Logo"></a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-1 text-center" id="navbarNavDropdown">

            <ul class="navbar-nav ml-auto flex-nowrap">

                <li class="nav-item">
                    <a class="nav-link" href="explore">Explore</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link" href="about">About</a>
                </li> -->
        ';

        // Original Search Page Link
        //<li class="nav-item">
        //    <a class="nav-link" href="search.php">Search</a>
        //</li>

                //Guest NavBar
                if(isset($_SESSION['login_user']) && $_SESSION['username'] != "Guest"){ 
                    $username = $_SESSION['username'];
                     echo"
                     <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>My Profile</a>

                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <a class='dropdown-item' href='$username'>View Profile</a>
                            <a class='dropdown-item' href='EstablishCrew'>Add Content</a>
                            <a class='dropdown-item' href='#' data-toggle= 'modal' data-target='#settingsModal'>Settings</a>

                            <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='logout_alg.php'>Logout</a>
                        </div> 
                     </li>"; 
                 }
                     
                 else{
                        echo "<li class='nav-item'><a class='nav-link' href='login'>Login</a></li>";
                     }
    echo'
            </ul>
        </div>
        </nav>
    </div>
    ';

}


//--Show Header [Homepage]--//
function HomepageHeader()
{
    echo'
    <div class="intro-banner">
    <div class="container">
        <div class="row">
            <div class="banner-text"> 
                <h1>Welcome to Stuudeo</h1>';
                if ($_SESSION['username'] == 'STuuDEOAdmin')
                     echo"<p>-Admin Access Mode-</p>";
                else
                echo"<p>Beta</p>";

            echo'
            </div>
        </div>
    </div>
    <div class="bg-overlay"></div>

    <div class="video-container hero_banner">
        <!-- <video autoplay loop muted src="assets/video/landing_banner.mp4"></video> -->
    </div>
    </div>';
}


//--Display All Users--//
function DisplayAllUsers()
{
    $mysqli = ConnectDB();
    $sql = 'SELECT * FROM users';
    $result = $mysqli->query($sql); //$result = mysqli_result object
                 
    while($row = $result->fetch_assoc()){
        $username = $row['username'];
        $location = $row['location'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $avatar = $row['avatar'];


        $image = cl_image_tag($avatar);
        //Dont Display Admin User
        if ($username != 'STuuDEOAdmin' && $firstname != 'Unregistered' && (GetNumVideos($username) != 0)){
            echo "
            <div class='users-grid-profile col-lg-2 col-md-4 col-sm-6'>
                <a href='$username'>
                        <img src='https://res.cloudinary.com/stuudeo/image/upload/f_auto,q_auto,w_600/v1/$avatar' alt='$firstname $lastname'>
                </a>

                <a class='users-grid-name' href='$username'>
                    <p>$firstname $lastname</p>
                </a>

                <p class='meta-location'>@$username</p>
            </div>
            ";
        }
    }
}


//--Display Featured Users--//
function DisplayFeaturedUsers()
{
    $mysqli = ConnectDB();
    $sql = 'SELECT * FROM users where featured != 0';
    $result = $mysqli->query($sql);

    //Gather User Information
    while($row = $result->fetch_assoc()){
        $username = $row['username'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $avatar = $row['avatar'];

        //Display Users
        echo "
        <div class='users-grid-profile col-lg-2 col-md-4 col-sm-6 col-xs-6'>
              <a href='$username'>
              <img src='https://res.cloudinary.com/stuudeo/image/upload/f_auto,q_auto,w_600/v1/$avatar' alt='$firstname $lastname'>
              </a>

              <a class='users-grid-name' href='$username'>
                  <p>$firstname $lastname</p>
              </a>
        </div>
        ";
    }
}



//                                    //
//-----{USER DATA AND ALTERATION}-----//
//                                    //



//--Check For User From Username (REQUIRED: Username)--//
//--Returns True if user exists, False otherwise--//
function userExists($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT username FROM users WHERE username = '$username'";

    $result = $mysqli->query($sql);

    while($row = $result->fetch_assoc()){ //Fetch Data
        if($username = $row['username']){return true;}
    }

    return false;
}


//--Checks to see if a user is an Actor (REQUIRED: Username)--//
//--Returns True if user is an actor, False otherwise--//
function isActor($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT actor FROM users WHERE username = '$username' AND actor = 1";

    $result = $mysqli->query($sql);

    while($row = $result->fetch_assoc()){
        if($username = $row['username']){return true;}
    }

    return false;
}


//--Check For User (REQUIRED: Email)--//
//--Returns True if user exists, False otherwise--//
function userExists_Email($email)
{
    $mysqli = ConnectDB();
    $sql = "SELECT email FROM users WHERE email = '$email'";

    $result = $mysqli->query($sql);

    while($row = $result->fetch_assoc()){ //Fetch Data
        if($email = $row['email']){return true;}
    }

    return false;
}


//--Create User If None Exists (Auto Creation) (REQURIED: Email)--//
function autoCreate($email)
{
        $mysqli = ConnectDB();

        //Set username = email
        $username = $email;

        //Set username = first part of email. ie.) spkudrna@gmail.com becomes spkudrna.
        $username = substr($username, 0, strpos($username, '@'));
    
        $firstname = 'Unregistered';
        $lastname = 'User';
        $password = md5("STunclaimedAccnts123!");
        $avatar_path = ('images/default.png');
        $location = '';
        $bio = '';
      

        //Insert User Into Database
        $sql = "INSERT INTO users (username, password, firstname, lastname, email, avatar, location, featured, bio, instagram, twitter, linkedin) "
                    ."VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$avatar_path', '$location', '0', '$bio', '', '', '')";
        
        //Firstname = 'Unregistered'
        //Lastname = 'User'
        //Password = Randomly Generated Code
        //Avatar = Default Image
        //Location = ''
        //Tag = 0
        //Bio = ''
        $mysqli->query($sql);
}


//--Feature User (REQUIRED: Username)--//
function FeatureUser($username)
{
    $mysqli = ConnectDB();
    $sql = "UPDATE users SET featured = 1 WHERE username = '$username'";

    if (mysqli_query($mysqli, $sql)){
        header('location: explore.php');
    } 

    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
}


//--UnFeature User (REQUIRED: Username)--//
function UnfeatureUser($username)
{
    $mysqli = ConnectDB();
    $sql = "UPDATE users SET featured = 0 WHERE username = '$username'";

    if (mysqli_query($mysqli, $sql)){
        header('location: explore.php');
    } 

    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
}


//--Get The Current Logged In User's Username--//
function GetCurrentUsername()
{
    return $_SESSION['username'];
}



//--Get A Users Username From Email (REQUIRED: Email)--//
function GetUsername_Email($email)
{
    $mysqli = ConnectDB();
    $sql = "SELECT username FROM users WHERE email = '$email'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ //Fetch Data
            $username = $row['username']; 
        }
    return $username;
}


//--Get A Users Username From ID (REQUIRED: ID)--//
function GetUsername_ID($id)
{
    $mysqli = ConnectDB();
    $sql = "SELECT username FROM users WHERE id = '$id'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ //Fetch Data
            $username = $row['username']; 
        }
    return $username;
}


//--Get The Current Looged In User's ID--//
function GetCurrentUserID()
{
    $mysqli = ConnectDB();
    $username = $_SESSION['username'];

    $getID = "SELECT id FROM users WHERE username = '$username'";
    $IDresult = $mysqli->query($getID);
        while($row = $IDresult->fetch_assoc()){ 
            $id = $row['id'];
        }
    
    return $id;
}


//--Get User Avatar From Username (REQUIRED: Username)--//
function GetAvatar($username)
{
    $mysqli = ConnectDB();

    $sql = "SELECT avatar FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);
        while($row = $result->fetch_assoc()){ 
            $avatar = $row['avatar'];
        }
    
    return $avatar;
}


//--Get User ID From Username (REQUIRED: Username)--//
function GetUserID($username)
{
    $mysqli = ConnectDB();
    $getID = "SELECT id FROM users WHERE username = '$username'";
    $IDresult = $mysqli->query($getID);
        while($row = $IDresult->fetch_assoc()){ 
            $id = $row['id'];
        }
    
    return $id;
}


//--Get User ID From Email (Required: Email)--//
function GetUserID_Email($email)
{
    $mysqli = ConnectDB();
    $getID = "SELECT id FROM users WHERE email = '$email'";
    $IDresult = $mysqli->query($getID);
        while($row = $IDresult->fetch_assoc()){ 
            $id = $row['id'];
        }
    
    return $id;
}


//--Get Username from $_GET[' '] Function--//
function Get_GetUsername()
{
    return $_GET['username'];
}


//--Get Users Name From Username (REQUIRED: Username)--//
function GetFullName($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT firstname, lastname FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ //Fetch Data
            $firstname = $row['firstname']; 
            $lastname = $row['lastname'];
        }

        $FullName = $firstname." ".$lastname;
        return $FullName; 
}


//--Get Users First Name From Username (REQUIRED: Username)--//
function GetFirstName($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT firstname FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ //Fetch Data
            $firstname = $row['firstname']; 
        }

        return $firstname; 
}


//--Get Users Last Name From Username (REQUIRED: Username)--//
function GetLastName($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT lastname FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ //Fetch Data
            $lastname = $row['lastname']; 
        }

        return $lastname; 
}


//--Get Users Email From Username (REQUIRED: Username)--//
function GetEmail($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT email FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    while($row = $result->fetch_assoc()){
        $email = $row['email'];
    }
    
    return $email;
    
}


//--Get User Password From Username (REQUIRED: Username)--//
//--Returns Hashed Password--//
function GetPassword($username)
{

    $mysqli = ConnectDB();
    $id = GetCurrentUserID();

    $sql = "SELECT password FROM users WHERE id = '$id'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ //Fetch Data
            $password = $row['password']; 
        }

        return $password; 
}


//--Get Bio From Username (REQUIRED: Username)--//
function GetBio($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT bio FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()){
        $bio = $row['bio'];
    }

    return $bio;
}


//--Get Instagram From Username (REQUIRED: Username)--//
function GetInstagram($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT instagram FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()){
        $instagram = $row['instagram'];
    }

    return $instagram;
}


//--Get Twitter From Username (REQUIRED: Username)--//
function GetTwitter($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT twitter FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()){
        $twitter = $row['twitter'];
    }

    return $twitter;
}


//--Get Linkedin From Username (REQUIRED: Username)--//
function GetLinkedin($username)
{
    $mysqli = ConnectDB();
    $sql = "SELECT linkedin FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()){
        $linkedin = $row['linkedin'];
    }

    return $linkedin;
}

//--Get Users Full Name From Email (REQUIRED: Email)--//
function GetFullName_Email($email)
{
    $mysqli = ConnectDB();
    $sql = "SELECT firstname, lastname FROM users WHERE email = '$email'";
    $result = $mysqli->query($sql);

        while($row = $result->fetch_assoc()){ 
            $firstname = $row['firstname']; 
            $lastname = $row['lastname'];
        }

        $FullName = $firstname." ".$lastname;
        return $FullName; 
}


//--Get Contributor Status (REQUIRED: Username, Link to Video)--//
function GetContributorStatus($username, $link)
{
    $mysqli = ConnectDB();
    $email = GetEmail($username);
    $RoutingNumber = GetUserID($username);

    $data = "";

    $sql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$RoutingNumber'";
    $result = $mysqli->query($sql);

    while($row = $result->fetch_assoc()){
        $director = $row['director'];
        $editor = $row['editor'];
        $writer = $row['writer'];
        $producer = $row['producer'];
        $cinematographer = $row['cinematographer'];
        $storyby = $row['storyby'];
        $productiondesigner = $row['productiondesigner'];
        $firstad = $row['1stassistantdirector'];
        $secondad = $row['2ndassistantdirector'];
        $firstac = $row['1stassistantcamera'];
        $secondac = $row['2ndassistantcamera'];
        $productionsm = $row['productionsoundmixer'];
        $colorgrader = $row['colorgrader'];
        $moralsupport = $row['moralsupport'];

    }

    $count = 0;

   if ($email == $director)
   {
        $data .= "Director ";
        $count++;
   }

   if ($email == $writer)
   {
       $data .= "Writer ";
       $count++;
   }

   if ($email == $storyby)
   {
       $data .= "Story&nbspBy ";
       $count++;
   }

   if ($email == $producer)
   {
       $data .= "Producer ";
       $count++;
   }

   if ($email == $productiondesigner)
   {
       $data .= "Production&nbspDesigner ";
       $count++;
   }

   if ($email == $cinematographer)
   {
       $data .= "Cinematographer ";
       $count++;
   }

   if ($email == $editor)
   {
       $data .= "Editor ";
       $count++;
   }

   if ($email == $firstad)
   {
       $data .= "1st&nbspAssistant&nbspDirector ";
       $count++;
   }

   if ($email == $secondad)
   {
       $data .= "2nd&nbspAssistant&nbspDirector ";
       $count++;
   }

   if ($email == $firstac)
   {
       $data .= "1st&nbspAssistant&nbspCamera ";
       $count++;
   }

   if ($email == $secondac)
   {
       $data .= "2nd&nbspAssistant&nbspCamera ";
       $count++;
   }

   if ($email == $productionsm)
   {
       $data .= "Production&nbspSound&nbspMixer ";
       $count++;
   }

   if ($email == $colorgrader)
   {
       $data .= "Color&nbspGrader ";
       $count++;
   }

   if ($email == $moralsupport)
   {
       $data .= "Moral&nbspSupport ";
       $count++;
   }

   $ReplaceWith = (', ');
   $ReplaceThis = (' ');
   $count = $count +1;

   $data .="END";
   $data = str_replace( $ReplaceThis, $ReplaceWith, $data);

   $ReplaceThis = (', END');
   $ReplaceWith = ('');
   $data = str_replace( $ReplaceThis, $ReplaceWith, $data);

   //Remove END if for some reason the user was not a contributor at all
   $ReplaceThis = ('END');
   $ReplaceWith = ('');
   $data = str_replace( $ReplaceThis, $ReplaceWith, $data);

   if ($data != '')
   {
   return $data;
   }

   else
   {
        if($director == '' &&
        $editor == '' &&
        $writer == '' &&
        $producer == '' &&
        $cinematographer == '' &&
        $storyby == '' &&
        $productiondesigner == '' &&
        $firstad == '' &&
        $secondad == '' &&
        $firstac == '' &&
        $secondac == '' &&
        $productionsm == '' &&
        $colorgrader == '' &&
        $moralsupport == '')
        {
        $data = "Solo Project";
        return $data;
        }
   }

   //Default (Did not link self as contributor)
   if (GetCurrentUsername() == $username)
   {
       $data = "You haven't linked yourself as a contributor. Make sure to give yourself proper credit!";
       return $data;
   }

   else{
       $data = "This artist hasn't specified their contribution.";
       return $data;
   }

}


//--Change Username (REQUIRED: Old Username, New Username)--//
//--Returns Old Username if Unsuccesfull, New Username Otherwise--//
function ChangeUsername($OldUsername, $NewUsername)
{

    if ($OldUsername == $NewUsername)
    {
        unset($_SESSION['error']);
        unset($_SESSION['try_again']);
        return $OldUsername;
    }

    $mysqli = ConnectDB();
    $id = GetUserID($OldUsername);

    $sql = 'SELECT username FROM users';
    $result = $mysqli->query($sql);
    $flag = false;

    while($row = $result->fetch_assoc())
    {

        //Prevent Duplication Of Usernames
        if (strtolower($row['username']) == strtolower($NewUsername)){
            $_SESSION['error'] = 'That username has already been taken.';
            $_SESSION['try_again'] = 'TRUE';
            return $OldUsername;
        }

        else
        {
        $flag = true;
        unset($_SESSION['error']);
        unset($_SESSION['try_again']);
        }
        
    }

    if ($flag)
    {
        $sql = "UPDATE users SET username = '$NewUsername' WHERE id = '$id'";
        $mysqli->query($sql);

        $_SESSION['login_user'] = $NewUsername;
        $_SESSION['username'] = $NewUsername;

        return $NewUsername;
    
    }
 

}


//--Change First Name (REQUIRED: Old First Name, New First Name)--//
//--Returns New First Name--//
function ChangeFirstName($NewFirstName)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetUserID($username);
    
    $sql = "UPDATE users SET firstname = '$NewFirstName' WHERE id = '$id'";
    $mysqli->query($sql);
    return $NewFirstName;
    
}


//--Change Last Name (REQUIRED: Old Last Name, New Last Name)--//
//--Returns New Last Name--//
function ChangeLastName($NewLastName)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetUserID($username);
    
    $sql = "UPDATE users SET lastname = '$NewLastName' WHERE id = '$id'";
    $mysqli->query($sql);

    return $NewLastName;
}


//--Change Email (REQUIRED: New Email)--//
//--Returns New Email--//
function ChangeEmail($NewEmail)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetUserID($username);

    $sql = "UPDATE users SET email = '$NewEmail' WHERE id = '$id'";
    $mysqli->query($sql);

    return $NewEmail;
}


//--Change Password (REQUIRED: New Password, Confirmation)--//
//--Returns Old Password If No Change, New Password If Succesfull Change--//
function ChangePassword($NewPassword, $ConfirmNew)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetCurrentUserID();

    //Check Two Passwords Are The Same
    if ($NewPassword == $ConfirmNew)
    {   
        //Check To See If New Password Is Same As Old
        if ($NewPassword == GetPassword($username))
        {
            return GetPassword($username);
        }

        else
        {
            //Hash New Password Before Inserting.
            $NewPassword = md5($NewPassword);

            $sql = "UPDATE users SET password = '$NewPassword' WHERE id = '$id'";
            $mysqli->query($sql);
            return $NewPassword;
        }

    }

    //Display Error Message If Passwords Dont Match
    else{$_SESSION['error'] = 'Passwords must match.'; $_SESSION['try_again'] = 'TRUE';}

    return GetPassword($username);


 
}


//--Change Instagram (REQUIRED: New Instagram)--//
//--Returns Old Instagram if No Change, New Instagram if Succesfull Change--//
function ChangeInstagram($NewInstagram)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetCurrentUserID();

    if ($NewInstagram == GetInstagram($username))
    {
        return GetInstagram($username);
    }

    $sql = "UPDATE users SET instagram = '$NewInstagram' WHERE id = '$id'";
    $mysqli->query($sql);

    return $NewInstagram;
}


//--Change Twitter (REQUIRED: New Twitter)--//
//--Returns Old Twitter if No Change, New Twitter if Succesfull Change--//
function ChangeTwitter($NewTwitter)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetCurrentUserID();

    if ($NewTwitter == GetTwitter($username))
    {
        return GetTwitter($username);
    }

    $sql = "UPDATE users SET twitter = '$NewTwitter' WHERE id = '$id'";
    $mysqli->query($sql);

    return $NewTwitter;
}


//--Change Linkedin (REQUIRED: New linkedin)--//
//--Returns Old linkedin if No Change, New linkedin if Succesfull Change--//
function ChangeLinkedin($NewLinkedin)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetCurrentUserID();

    if ($NewLinkedin == GetLinkedin($username))
    {
        return GetBio($username);
    }

    $sql = "UPDATE users SET linkedin = '$NewLinkedin' WHERE id = '$id'";
    $mysqli->query($sql);

    return $NewLinkedin;
}


//--Change Bio (REQUIRED: New Bio)--//
//--Returns Old Bio if No Change, New Bio if Succesfull Change--//
function ChangeBio($NewBio)
{
    $mysqli = ConnectDB();
    $username = GetCurrentUsername();
    $id = GetCurrentUserID();

    if ($NewBio == GetBio($username))
    {
        return GetBio($username);
    }

    $sql = "UPDATE users SET bio = '$NewBio' WHERE id = '$id'";
    $mysqli->query($sql);

    return $NewBio;
}


//                                            //
//-----{VIDEO DATA AND DISPLAY FUNCTIONS}-----//
//                                            //



//---Returns the number of videos a user has on their profile (REQUIRES: Username)---//
function GetNumVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);

    $sql = "SELECT id FROM links WHERE RoutingNumber = '$id'";
    $result = $mysqli->query($sql);
    $i=0;

    while($result->fetch_assoc()){
        $i++;
    }

    return $i;
}


//---Get Vimeo Thumbnail (REQUIRED: Vimeo URL)---//
function GetVimeoThumbnail($vimeo_url)
{
    if( !$vimeo_url ) return false;
    $data = json_decode( file_get_contents( 'https://vimeo.com/api/oembed.json?url=' . $vimeo_url ) );
    if( !$data ) return false;
    return $data->thumbnail_url;
} 



//--Display Featured Video (REQUIRED: Username)--//
function DisplayFeaturedVideo($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);

    $sql = "SELECT link FROM featured_links WHERE RoutingNumber = '$id'";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()){
        $link = $row['link'];

        //Youtube
        if (strpos($link, "youtube")){

            //Fetch VideoID and Data
            $fetch=explode("v=", $link);
            $videoid=$fetch[1];

            $apikey = //Hidden because of public sharing;
                    
            $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$videoid.'&key='.$apikey.'&part=snippet');
            $ytdata = json_decode($json);
                    
            $title = $ytdata->items[0]->snippet->title;
            $description =$ytdata->items[0]->snippet->description;
            $description = substr($description, 0, 500);


            //Display Video, Title, and Description
            echo'
            <div class="small-margin">
            <div class="row">
            <div class="col-lg-7">
                <div class="iframe-container margin-bottom-tablet">
                    <iframe src="https://www.youtube.com/embed/'.$videoid.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>';
                if ($_SESSION['username'] == $username)
                {
                    if (GetBio($username) == '')
                    {
                    echo '<br><a href="#" style="display: inline-block; margin-bottom: 20px;" data-toggle="modal" data-target="#settingsModal" class="btn-secondary">Add a Custom Bio</a>';
                    }

                    echo'<br><a href="UnfeatureRoute.php?username='.$username.'&videoid='.$videoid.'" class="btn-secondary">Unmark Reel</a>';

                }

            echo'
            </div>

            <div class="col-lg-5">';

            
            if ($description != '')
            {
                echo'
                <h5>Featured Project</h5>';
                echo'<div class="featured-project-description">'.$description.'</div>'; 
                echo'<br><a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a></div>
                </div>
                </div>';
  
            }  
            else
            {
                $bio = 'Enjoy the show!';
                echo"
                <h5>Featured Project</h5>
                <div style='white-space: pre-wrap;'>$bio</div>";
                echo'<br><a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>
                </div>
                </div>
                </div>';


            }     
            
        }

        //Vimeo
        else if (strpos($link, "vimeo")){
                        
            //Fetch VideoID and Data
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;
            $description = $hash[0]->description;
            $description = substr($description, 0, 500);


            echo'
            <div class="small-margin">
            <div class="row">
            <div class="col-lg-7">
                <div class="iframe-container margin-bottom-tablet">
                    <iframe src="https://player.vimeo.com/video/'.$videoid.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                 </div>';
                 if ($_SESSION['username'] == $username && GetBio($username) == '')
                 {echo '<br><a href="#" style="display: inline-block; margin-bottom: 20px;" data-toggle="modal" data-target="#settingsModal" class="btn-secondary">Add a Custom Bio</a>';}
             echo'
                 </div>

             <div class="col-lg-5">';
             if ($description != '')
             {
                 echo'
                 <h5>Featured Project</h5>';
                echo'<div class="featured-project-description" style="white-space: normal;">'.$description.'</div>';
                echo'<br><a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a></div>
                </div>
                </div>';


             }
                
                //If No Description, Display Video Default
                else {
                $bio = 'Enjoy the show!';
                echo"
                <h5>Featured Project</h5>
                <div style='white-space: pre-wrap;'>$bio</div>";    
                echo'<br><a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>
                </div>
                </div>
                </div>';


                }
    }
}
}


//--Display All Other Fideos (REQUIRED: Username)--//
function DisplayOtherVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);

    $sql = "SELECT link, id, tagged FROM links WHERE RoutingNumber = '$id'";
    $result = $mysqli->query($sql);

    //Fetch Video Information
    while ($row = $result->fetch_assoc()){
        $link = $row['link'];
        $videoRoute = $row['id'];
        $tag = $row['tagged'];

        //Youtube
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

            //Display Thumbnail and Title
            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="https://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['username'] == $username){

                    //Remove From Portfolio Button
                        echo'
                        <div class="content-editing-btns">
                            
                            <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                    //Allow User To Switch Featured Content
                    echo'
                            <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
            </div>';
                }

            else{echo'</div>';}
        }

        
        //Vimeo
        else if (strpos($link, "vimeo")){

            //Fetch Video Information
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            //Get Thumbnail
            $thumbnail = GetVimeoThumbnail($link);

            //Remove Pre-Set Dimentions From Thumbnail Link
            $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;

            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                

            echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['login_user'] == $username){

                    //Remove From Portfolio Button
                        echo'<div class="content-editing-btns">
                        
                        <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                //Allow User To Switch Featured Content
                echo'
                    <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
                </div>';
                }
                
                else{echo'</div>';}
        }

    }

}


//--Displays all videos directed by given user (REQUIRED: Username)--//
function DisplayDirectedVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);
    $email = GetEmail($username);

    $sql = "SELECT link, id, tagged FROM links WHERE RoutingNumber = '$id' AND director = '$email'";
    $result = $mysqli->query($sql);

    //Fetch Video Information
    while ($row = $result->fetch_assoc()){
        $link = $row['link'];
        $videoRoute = $row['id'];
        $tag = $row['tagged'];

        //Youtube
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

            //Display Thumbnail and Title
            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="https://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['username'] == $username){

                    //Remove From Portfolio Button
                        echo'
                        <div class="content-editing-btns">
                            
                            <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                    //Allow User To Switch Featured Content
                    echo'
                            <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
            </div>';
                }

            else{echo'</div>';}
        }

        
        //Vimeo
        else if (strpos($link, "vimeo")){

            //Fetch Video Information
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            //Get Thumbnail
            $thumbnail = GetVimeoThumbnail($link);

            //Remove Pre-Set Dimentions From Thumbnail Link
            $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;

            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                

            echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['login_user'] == $username){

                    //Remove From Portfolio Button
                        echo'<div class="content-editing-btns">
                        
                        <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                //Allow User To Switch Featured Content
                echo'
                    <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
                </div>';
                }
                
                else{echo'</div>';}
        }

    }

}


//--Displays all videos edited by given user (REQUIRED: Username)--//
function DisplayEditedVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);
    $email = GetEmail($username);

    $sql = "SELECT link, id, tagged FROM links WHERE RoutingNumber = '$id' AND editor = '$email'";
    $result = $mysqli->query($sql);

    //Fetch Video Information
    while ($row = $result->fetch_assoc()){
        $link = $row['link'];
        $videoRoute = $row['id'];
        $tag = $row['tagged'];

        //Youtube
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

            //Display Thumbnail and Title
            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="https://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['username'] == $username){

                    //Remove From Portfolio Button
                        echo'
                        <div class="content-editing-btns">
                            
                            <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                    //Allow User To Switch Featured Content
                    echo'
                            <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
            </div>';
                }

            else{echo'</div>';}
        }

        
        //Vimeo
        else if (strpos($link, "vimeo")){

            //Fetch Video Information
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            //Get Thumbnail
            $thumbnail = GetVimeoThumbnail($link);

            //Remove Pre-Set Dimentions From Thumbnail Link
            $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;

            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                

            echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['login_user'] == $username){

                    //Remove From Portfolio Button
                        echo'<div class="content-editing-btns">
                        
                        <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                //Allow User To Switch Featured Content
                echo'
                    <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
                </div>';
                }
                
                else{echo'</div>';}
        }

    }

}


//--Displays all videos written by given user (REQUIRED: Username)--//
function DisplayWrittenVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);
    $email = GetEmail($username);

    $sql = "SELECT link, id, tagged FROM links WHERE RoutingNumber = '$id' AND writer = '$email'";
    $result = $mysqli->query($sql);

    //Fetch Video Information
    while ($row = $result->fetch_assoc()){
        $link = $row['link'];
        $videoRoute = $row['id'];
        $tag = $row['tagged'];

        //Youtube
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

            //Display Thumbnail and Title
            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="https://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['username'] == $username){

                    //Remove From Portfolio Button
                        echo'
                        <div class="content-editing-btns">
                            
                            <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                    //Allow User To Switch Featured Content
                    echo'
                            <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
            </div>';
                }

            else{echo'</div>';}
        }

        
        //Vimeo
        else if (strpos($link, "vimeo")){

            //Fetch Video Information
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            //Get Thumbnail
            $thumbnail = GetVimeoThumbnail($link);

            //Remove Pre-Set Dimentions From Thumbnail Link
            $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;

            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                

            echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['login_user'] == $username){

                    //Remove From Portfolio Button
                        echo'<div class="content-editing-btns">
                        
                        <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                //Allow User To Switch Featured Content
                echo'
                    <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
                </div>';
                }
                
                else{echo'</div>';}
        }

    }

}


//--Displays all videos produced by given user (REQUIRED: Username)--//
function DisplayProducedVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);
    $email = GetEmail($username);

    $sql = "SELECT link, id, tagged FROM links WHERE RoutingNumber = '$id' AND producer = '$email'";
    $result = $mysqli->query($sql);

    //Fetch Video Information
    while ($row = $result->fetch_assoc()){
        $link = $row['link'];
        $videoRoute = $row['id'];
        $tag = $row['tagged'];

        //Youtube
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

            //Display Thumbnail and Title
            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="https://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['username'] == $username){

                    //Remove From Portfolio Button
                        echo'
                        <div class="content-editing-btns">
                            
                            <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                    //Allow User To Switch Featured Content
                    echo'
                            <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
            </div>';
                }

            else{echo'</div>';}
        }

        
        //Vimeo
        else if (strpos($link, "vimeo")){

            //Fetch Video Information
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            //Get Thumbnail
            $thumbnail = GetVimeoThumbnail($link);

            //Remove Pre-Set Dimentions From Thumbnail Link
            $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;

            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                

            echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['login_user'] == $username){

                    //Remove From Portfolio Button
                        echo'<div class="content-editing-btns">
                        
                        <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                //Allow User To Switch Featured Content
                echo'
                    <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
                </div>';
                }
                
                else{echo'</div>';}
        }

    }

}


//--Displays all videos Cinemagraphed by given user (REQUIRED: Username)--//
function DisplayCinemagraphedVideos($username)
{
    $mysqli = ConnectDB();
    $id = GetUserID($username);
    $email = GetEmail($username);

    $sql = "SELECT link, id, tagged FROM links WHERE RoutingNumber = '$id' AND cinematographer = '$email'";
    $result = $mysqli->query($sql);

    //Fetch Video Information
    while ($row = $result->fetch_assoc()){
        $link = $row['link'];
        $videoRoute = $row['id'];
        $tag = $row['tagged'];

        //Youtube
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

            //Display Thumbnail and Title
            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="https://img.youtube.com/vi/'.$videoid.'/hqdefault.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['username'] == $username){

                    //Remove From Portfolio Button
                        echo'
                        <div class="content-editing-btns">
                            
                            <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                    //Allow User To Switch Featured Content
                    echo'
                            <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
            </div>';
                }

            else{echo'</div>';}
        }

        
        //Vimeo
        else if (strpos($link, "vimeo")){

            //Fetch Video Information
            $urlParts = explode("/", parse_url($link, PHP_URL_PATH));
            $videoid = (int)$urlParts[count($urlParts)-1];

            //Get Thumbnail
            $thumbnail = GetVimeoThumbnail($link);

            //Remove Pre-Set Dimentions From Thumbnail Link
            $thumbnail = substr($thumbnail, 0, strpos($thumbnail, "_"));
                
            $hash = json_decode(file_get_contents("https://vimeo.com/api/v2/video/{$videoid}.json"));
            $title = $hash[0]->title;

            echo'
            <div class="col-lg-6 user-feed-item"> 
                <a href="project.php?link='.$link.'&username='.$username.'"><img src="'.$thumbnail.'.jpg" alt=""></a>
                <a href="project.php?link='.$link.'&username='.$username.'"><h3>'.$title.'</h3></a>';

                //Display Contributer Tag
                echo'<h6 style="color: #767676; margin: -10px 0 20px;">'.GetContributorStatus($username, $link).'</h6>';
                

            echo'<a href="project.php?link='.$link.'&username='.$username.'" class="btn-primary">Watch Now</a>';


                //Check If Current User Is Viewing Own Profile
                if ($_SESSION['login_user'] == $username){

                    //Remove From Portfolio Button
                        echo'<div class="content-editing-btns">
                        
                        <a href="remVid.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Remove From Portfolio</a> &ensp;';

                //Allow User To Switch Featured Content
                echo'
                    <a href="featureRoute.php?username='.$username.'&videoid='.$videoRoute.'" class="btn-secondary">Mark as Reel</a>
                    </div>
                </div>';
                }
                
                else{echo'</div>';}
        }

    }

}







//--Retruns array of profiles (usernames) similar to current profile--//
function TopCollaborators($username)
{
    $mysqli = ConnectDB();
    $RoutingNumber = GetUserID($username);

    //--Find Director With Most Credits From User ($username)--//
    $sql = "SELECT director, count(*) AS Occurences 
    FROM links WHERE RoutingNumber = '$RoutingNumber'
    GROUP BY director
    ORDER BY
    count(*)
    DESC";

    $result = $mysqli->query($sql);

    $director = "FIRST";
    while ($row = $result->fetch_assoc())
    {  
        if ($row['director'] != '' && $director == 'FIRST')
        {
        $director = $row['director']; //Email of director credited most by user
        break;
        }
    }

    $DirUN = GetUsername_Email($director);

    //--Find Editor With Most Credits From User ($username)--//
    $sql = "SELECT editor, count(*) AS Occurences 
    FROM links WHERE RoutingNumber = '$RoutingNumber'
    GROUP BY editor
    ORDER BY
    count(*)
    DESC";

    $result = $mysqli->query($sql);

    $editor = "FIRST";
    while ($row = $result->fetch_assoc())
    {  
        if ($row['editor'] != '' && $editor == 'FIRST')
        {
        $editor = $row['editor']; //Email of editor credited most by user
        break;
        }
    }

    $EdiUN = GetUsername_Email($editor);

    //--Find Writer With Most Credits From User ($username)--//
    $sql = "SELECT writer, count(*) AS Occurences 
    FROM links WHERE RoutingNumber = '$RoutingNumber'
    GROUP BY writer
    ORDER BY
    count(*)
    DESC";

    $result = $mysqli->query($sql);

    $writer = "FIRST";
    while ($row = $result->fetch_assoc())
    {  
        if ($row['writer'] != '' && $writer == 'FIRST')
        {
        $writer = $row['writer']; //Email of writer credited most by user
        break;
        }
    }

    $WriUN = GetUsername_Email($writer);

    //--Find Producer With Most Credits From User ($username)--//
    $sql = "SELECT producer, count(*) AS Occurences 
    FROM links WHERE RoutingNumber = '$RoutingNumber'
    GROUP BY producer
    ORDER BY
    count(*)
    DESC";

    $result = $mysqli->query($sql);

    $producer = "FIRST";
    while ($row = $result->fetch_assoc())
    {  
        if ($row['producer'] != '' && $producer == 'FIRST')
        {
        $producer = $row['producer']; //Email of producer credited most by user
        break;
        }
    }

    $ProUN = GetUsername_Email($producer);

    //--Find Cinematographer With Most Credits From User ($username)--//
    $sql = "SELECT cinematographer, count(*) AS Occurences 
    FROM links WHERE RoutingNumber = '$RoutingNumber'
    GROUP BY cinematographer
    ORDER BY
    count(*)
    DESC";

    $result = $mysqli->query($sql);

    $cinematographer = "FIRST";
    while ($row = $result->fetch_assoc())
    {  
        if ($row['cinematographer'] != '' && $cinematographer == 'FIRST')
        {
        $cinematographer = $row['cinematographer']; //Email of cinematographer credited most by user
        break;
        }
    }

    $CinUN = GetUsername_Email($cinematographer);

    return [$DirUN, $EdiUN, $WriUN, $ProUN, $CinUN];
}

//--Get VideoID From $_GET[' '] Function--//
function Get_GetVideoID()
{
    return $_GET['videoid'];
}


//--Get Link From $_GET[' '] Function--//
function Get_GetLink()
{
   return $_GET['link'];
}


?>