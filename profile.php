<?php
//--Include Statments--//
include('session.php');
include('functions.php');
$_SESSION['establish_crew'] = [[]];

//---Conect to Database---//
$mysqli = ConnectDB();

//--Get Profile Information (username, fullname)--//
$username = Get_GetUsername();
$fullname = GetFullName($username);
$bio = GetBio($username);

//$filter = $_GET['profile-content-filter'];
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$fullname"?> | Stuudeo</title> 
    <link rel="shortcut icon" href="assets/branding/favicon.ico" />
    <meta name="description" content='<?php echo "$bio"?>'>

    <?php
    if ($_SESSION['try_again'] == 'TRUE')
    {
    echo'
    <script>
        $(document).ready(function(){$("#settingsModal").modal("show");});
    </script>';
    }
    ?>

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


<?php

//--NavBar--//
NavBar();



//--Get All Remaining User Information--//
    $sql = "SELECT location, avatar, featured FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

//--If Nothing is Found, Specify That To User--//
    if(mysqli_num_rows($result) != 1){
        die ('
        
        <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 style="margin-bottom: 20px;">Oh no! This page was not found.</h1>
                <h6 style="margin-bottom: 50px;">Error code: 404</h6>
                <p>Here are some helpful links instead:</p>
                <a href="index.php">Home</a> <br>
                <a href="explore.php">Explore</a> <br>
                <a href="login.php">Login</a>
            </div>
        </div>
        </div>
        
        
        
        ');
    }

//--Set And Save All Remaining User Information--//
    while($row = $result->fetch_assoc()){
        $location = $row['location'];
        $avatar = $row['avatar'];
        $featured = $row['featured'];
    }

//--Check For Admin Login--//
    $errorM = $_SESSION['message'];
    //echo'<div class="container small-margin">
     //       <div class="row profile-page-head">
     //           <div class="alert alert-error">'.$errorM.'</div>
     //       </div>
    //    </div>';
    


    if ($_SESSION['username'] == 'STuuDEOAdmin'){

//--Allow Admin to Feature Account--//
        if(!$featured){
        echo "
        <div class = 'login-page'>
                <div class = 'form'>
                    <form class = 'login-form' action='profile.php?username=$username' method='post' enctype='multipart/form-data' autocomplete='off'>
                    <button>Feature This User!</button>
                    </form>
                </div>
            </div>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                FeatureUser($username);
            }
        }

//--Allow Admin to Unfeature Account--//
        else if($featured){
        echo "
        <div class = 'login-page'>
                <div class = 'form'>
                    <form class = 'login-form' action='profile.php?username=$username' method='post' enctype='multipart/form-data' autocomplete='off'>
                    <button>Remove from Featured</button>
                    </form>
                </div>
            </div>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                UnfeatureUser($username);
            }
        }
    }
    ?>

<!--Display User Picture, Name, and Location-->
    <div class="container small-margin">
        <div class="row profile-page-head">
            <?php echo "
                        <img src='http://res.cloudinary.com/stuudeo/image/upload/f_auto,q_auto,w_600/v1/$avatar' alt='$fullname'>
                        <h1>$fullname</h1>
                <h4>@$username</h4>";
            ?>
            
        </div>
    </div>
    
    <div class="container small-margin">
        <div class="tab">
          <button class="tablinks" onclick="openCity(event, 'Portfolio')">Portfolio</button>
          <button class="tablinks" onclick="openCity(event, 'About')">About</button>
        </div>
        
        <div id="Portfolio" class="tabcontent">
            <!--Featured video-->
            <?php
              DisplayFeaturedVideo($username);
            ?>

           <!--Filter content dropdown-->
           <?php echo "<form class='profile-content-filter-form' method = 'POST'>"?>
               <label for="profile-content-filter">Sort by role:</label>
               <select name="profile-content-filter" id="profile-content-filter">
                   <option value="all">All</option>
                   <option value="director">Director</option>
                   <option value="cinematographer">Cinematographer</option>
                   <option value="producer">Producer</option>
                   <option value="writer">Writer</option>
               </select>
               <input type="submit" value="Filter">
           </form>

           <?php
            $filter = $_POST['profile-content-filter'];
            if ($filter != '')
            echo "<br><p style = 'text-align: center;'> Sorted by ". $filter . "</p>";
           ?>

           
           
           
            <!--All videos-->
            <div class='small-margin' style="padding-bottom: 0;">
                <div class='row user-feed'>
                    <?php
                        if ($filter == 'all' || $filter == '')
                        {
                         DisplayOtherVideos($username);
                        }
                        

                        else if ($filter == 'director')
                        {
                            DisplayDirectedVideos($username);
                        }

                        else if ($filter == 'cinematographer')
                        {
                            DisplayCinemagraphedVideos($username);
                        }

                        else if ($filter == 'producer')
                        {
                            DisplayProducedVideos($username);
                        }

                        else if ($filter == 'writer')
                        {
                            DisplayWrittenVideos($username);
                        }
                      
                    ?>
                </div>
            </div>
        </div>

        <div id="About" class="tabcontent" style="padding: 45px 0;">
            <div class="dropdown d-none" style="margin-bottom: 20px; margin-left: 5px;">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Add profile section
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#AddNewSection">About</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#AddNewSection">Location</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#AddNewSection">Awards</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#AddNewSection">Inspiration</a>
              </div>
            </div>
            
            <div class="about-section-container">
                <div class="profile-about-section profile-intro col-lg-6">
                    <?php 
                        $bio = GetBio($username); 
                        if ($bio != '')
                        {
                            echo "<h5>About This Filmmaker</h5>";
                            echo "<p style='white-space: pre-wrap;'>$bio</p>"; 
                        }

                        else
                        {
                            $firstname = GetFirstName($username);
                            echo"<h5>Proud Stuudeo Creator</h5>";
                            echo "<p style='white-space: pre-wrap;'>Expect more from $firstname soon!</p>";
                        }
                    ?>
                    <div class="social-links">
                        <?php 
                        $insta = getInstagram($username); $twi = getTwitter($username); $lin = getLinkedin($username);
                        if ($insta != ''){
                         echo
                        "<a href='$insta' style='background-color: #E1306C;' target='_blank'>
                            <i class='fab fa-instagram'></i>
                        </a>";}
                        if ($twi != ''){
                        echo
                        "<a href='$twi' style='background-color: #1DA1F2;' target='_blank'>
                            <i class='fab fa-twitter'></i>
                        </a>";}
                        if ($lin != ''){
                        echo
                        "<a href='$lin' style='background-color: #2867B2;' target='_blank'>
                            <i class='fab fa-linkedin'></i>
                        </a>";} ?>
                    </div>
                </div>
                <div class="profile-about-section profile-location col-lg-6 d-none">
                    <h5>Location</h5>
                    <p>Chicago, IL <br> DePaul University</p>
                </div>
                <div class="profile-about-section profile-awards col-lg-6 d-none">
                    <h5>Awards</h5>
                    <p>National Film Award for Best Cinematography <span><a href="project.php?link=https://vimeo.com/375564819&username=Eric">None the Wiser</a></span> <span><a href="project.php?link=https://vimeo.com/374564684&username=Eric">A Lone Star State of Mind</a></span> </p>
                    <p>Dig is a good film <span><a href="project.php?link=https://www.youtube.com/watch?v=uUCbJhEev1o&username=Eric">Internet Grown</a></span></p>
                    <p>Noice film <span><a href="project.php?link=https://www.youtube.com/watch?v=_jXOqgnMYis&username=Eric">College Transitions and Internet Friends</a></span></p>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    if ($_SESSION['login_user'] == $username)
    {
    $num = GetNumVideos($username);
    if ($num == 0)
    {
        unset($_SESSION['message']);
        echo "
            <div class = 'form'>
                <form class = 'login-form' action='EstablishCrew.php'>
                <button>Build Your Portfolio</button>
                </form>
            </div>";
    }
    }

    ?>

    <script>
        function openCity(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }
        
        document.getElementsByClassName("tablinks")[0].click();
    </script>
    
    <!-- Add New Feature Modal -->
    <div class="modal fade" id="AddNewSection" tabindex="-1" role="dialog" aria-labelledby="AddNewSectionTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="NewSectionTitle">New Profile Section</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="">
              <div class="modal-body">
                <div class="label-input-group">
                    <label for="bio">About This Filmmaker:</label>
                    <textarea name="bio" id="bio" rows="4" style="min-height: 50px;" maxlength="500" onkeyup="limitTextCount('bio', 'divcount', 500);" onkeydown="limitTextCount('title', 'divcount', 100);" placeholder="Proud Stuudeo creator."></textarea>
                    <div id="divcount" style = "color: grey; text-align: right;">Max: 500 Characters</div>
                </div>
                <div class="label-input-group">
                    <label for="instagram">Instagram:</label>
                    <?php if($instagram != ''){echo "<input type='instagram' name='instagram' value='$instagram'>";} else{echo "<input type='instagram' name='instagram' placeholder='www.instagram.com/username'>";} ?>
                </div>
                <div class="label-input-group">
                    <label for="twitter">Twitter:</label>
                    <?php if($twitter != ''){echo "<input type='twitter' name='twitter' value='$twitter'>";} else{echo "<input type='twitter' name='twitter' placeholder='www.twitter.com/username'>";} ?>
                </div>
                <div class="label-input-group">
                    <label for="linkedin">LinkedIn:</label>
                    <?php if($linkedin != ''){echo "<input type='linkedin' name='linkedin' value='$linkedin'>";} else{echo "<input type='linkedin' name='linkedin' placeholder='www.linkedin.com/username'>";} ?>
                </div>
              </div>
          </form>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary-og">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
<!--Footer-->
    <?php // include_once('prefooter.php'); ?>
    <?php include_once('footer.php'); ?>

</body>
</html>