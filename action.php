<?php
include("functions.php");
include("vendor/autoload.php");
include("config-cloud.php");



$username = GetCurrentUsername();

//--Verify File Type Is An Image--//
if (preg_match("!image!", $_FILES['avatar']['type'])){

    $mysqli = ConnectDB();

    $name= $_FILES['avatar']['name'];
    $tmp_name= $_FILES['avatar']['tmp_name'];
    $size= $_FILES['avatar']['size'];
    $avatar_path = $mysqli->real_escape_string('images/'.$_FILES['avatar']['name']);


//--Limit File Size to 20MB--//
    if ($size < 20971520)
    {

      $_SESSION['username'] = $username;
    
//--Insert User Into Database--//
      $sql = "UPDATE users SET avatar = '$avatar_path' WHERE username = '$username'";

      //Strip .jpg, .jpeg, .png, etc From image name before upload
      $avatar_path = substr($avatar_path, 0, strpos($avatar_path, '.'));

      //Upload image to cloudinary
      \Cloudinary\Uploader::upload($tmp_name, array("public_id" => $avatar_path));

//--Login, Route To Homepage--//
      $mysqli->query($sql);
      $newAvatar = getAvatar($username);

}
else {$_SESSION['error'] = "Please select a file under 20MB."; $_SESSION['try_again'] = 'TRUE';}

}
else {
    $_SESSION['error'] = "This file is not supported. Please select another image."; $_SESSION['try_again'] = 'TRUE';
    }
    

if (isset($_POST['username']))
{
    if ($_POST['username'] != '')
    {
    $oldUsername = getCurrentUsername();
    ChangeUsername($username, $_POST['username']);
    $newUsername = getCurrentUsername();

    if ($oldUsername != $newUsername){$flag = true;}
    }
}

if (isset($_POST['Fname']))
{
    if ($_POST['Fname'] != '')
    {
    $oldFirst = getFirstName($username);
    ChangeFirstName($_POST['Fname']);
    $newFirst = getFirstName($username);

    if ($oldFirst != $newFirst){$flag = true;}
    }
}

if (isset($_POST['Lname']))
{
    if ($_POST['Lname'] != '')
    {
    $oldLast = getLastName($username);
    ChangeLastName($_POST['Lname']);
    $newLast = getLastName($username);

    if ($oldLast != $newLast){$flag = true;}
    }
}

if (isset($_POST['email']))
{
    if ($_POST['email'] != '')
    {
    $oldEmail = getEmail($username);
    ChangeEmail($_POST['email']);
    $newEmail = getEmail($username);

    if ($oldEmail != $newEmail){$flag = true;}
    }
}

if (isset($_POST['password']))
{
    if ($_POST['password'] != '')
    {
    $oldPassword = getPassword($username);
    ChangePassword($_POST['password'], $_POST['confirmpassword']);
    $newPassword = getPassword($username);

    if ($oldPassword != $newPassword){$flag = true;}
    }
}

if (isset($_POST['instagram']))
{

        $oldInsta = getInstagram($username);
        ChangeInstagram($_POST['instagram']);
        $newInsta = getInstagram($username);

        if ($oldInsta != $newInsta){$flag = true;}
    
}

if (isset($_POST['twitter']))
{

        $oldTwitter = getTwitter($username);
        ChangeTwitter($_POST['twitter']);
        $newTwitter = getTwitter($username);

        if ($oldTwitter != $newTwitter){$flag = true;}
    
}

if (isset($_POST['linkedin']))
{

        $oldLinkedin = getLinkedin($username);
        ChangeLinkedin($_POST['linkedin']);
        $newLinkedin = getLinkedin($username);

        if ($oldLinkedin != $newLinkedin){$flag = true;}
    
}

if (isset($_POST['bio']))
{
    if ($_POST['bio'] != '')
    {
    $oldBio = getBio($username);
    ChangeBio($_POST['bio']);
    $newBio = getBio($username);

    if ($oldBio != $newBio){$flag = true;}
    }
}




if ($flag)
{
    $_SESSION['try_again'] = 'FALSE';
    $_SESSION['error'] = '';
}
$ResetRoute = GetCurrentUsername();
header("location: profile.php?username=$ResetRoute");



?>