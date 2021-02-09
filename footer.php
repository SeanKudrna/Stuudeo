    <?php
    include("vendor/autoload.php");
    include("config-cloud.php");

    $username = GetCurrentUsername();
    $firstname = GetFirstName($username);
    $lastname = GetLastName($username);
    $email = GetEmail($username);
    $avatar = GetAvatar($username);
    $instagram = getInstagram($username);
    $twitter = getTwitter($username);
    $linkedin = getLinkedin($username)
    ?>
    
    <footer >
        <div class="container">
            <div class="row float-right">
                <div class="social-links">
                    <a href="https://www.instagram.com/stuudeo/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <!--
                    <a href="https://www.tiktok.com/@stuudeo" target="_blank">
                        <svg class="icon" viewBox="0 0 1429.4 1670.5" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1429.3,675.9c-13.7,1.3-27.4,2-41.1,2.1c-150.4,0-290.7-75.8-373.2-201.7V1163c0,280.3-227.2,507.6-507.6,507.6
                            S0,1443.4,0,1163s227.2-507.6,507.6-507.6l0,0c10.6,0,21,1,31.4,1.6v250.1c-10.4-1.2-20.7-3.2-31.4-3.2c-143.1,0-259,116-259,259
                            c0,143.1,116,259,259,259c143.1,0,269.5-112.7,269.5-255.8L779.5,0h239.3c22.6,214.6,195.6,382.2,410.8,397.9v278"></path>
                        </svg>
                    </a>
                    -->
                    <a href="https://www.linkedin.com/company/stuudeo/" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
            <div class="row float-left">
                <ul class="no-bullets inline-list footer-linklist">
                    <li><a href="mailto:hello@stuudeo.com" target="_blank">Contact Us</a></li>
                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="terms-of-use.php">Terms of Use</a></li>
                </ul>
            </div>
            <!-- <span class="copyright">&copy; Stuudeo 2020</span> -->
        </div>
    </footer>
<head>
    <script>
        
        function limitTextCount(limitField_id, limitCount_id, limitNum)
    {
        var limitField = document.getElementById(limitField_id);
        var limitCount = document.getElementById(limitCount_id);
        var fieldLEN = limitField.value.length;
    
        if (fieldLEN > limitNum)
        {
            limitField.value = limitField.value.substring(0, limitNum);
        }
        else
        {
            limitCount.innerHTML = (limitNum - fieldLEN);
        }
    }

    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    
    </script>
    </head>
    
    <!--Only Register this code if the user is not a guest or not logged in-->
    <?php
    if ($_SESSION['login_user'] != 'Guest' || $_SESSION['login_user'] != '')
    {
    ?>
    <!-- Render this code only if user is logged in -->
    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Profile Settings</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="settings-form" action="action.php" method = "post" enctype="multipart/form-data">
              <div class="modal-body">
              <?php
                $errorM = $_SESSION['error'];
                echo'<div class="alert alert-error">'.$errorM.'</div>';

                $errorM2 = $_SESSION['message'];
                echo'<div class="alert alert-error">'.$errorM2.'</div>';
              ?>
                <div class="image-upload">
                    <label for="file-input">

                        <?php echo "<img class='text-center' id = 'blah' src = 'http://res.cloudinary.com/stuudeo/image/upload/f_auto,q_auto,w_600/v1/$avatar'>";?>

                        <?php //echo cl_image_tag($avatar); ?>

                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="20" viewBox="0 0 20 17" fill="#fff"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                    </label>
                    <input id="file-input" type="file" name = 'avatar' onchange="readURL(this);" accept="image/jpeg, image/png, image/webp image/jpg" />
                </div>
                
                <!-- First Name -->
                
                <div class="label-input-group" style="width:49%; display: inline-block; margin: 0 5px 0 0;">
                    <label for="Fname">First Name:</label>
                    <?php echo "<input type='text' name='Fname' value= '$firstname'>";?>
                </div>

                <!-- Last Name -->
                <div class="label-input-group" style="width:49%; display: inline-block; margin: 0;">
                    <label for="Lname">Last Name:</label>
                    <?php echo "<input type='text' name='Lname' value= '$lastname'>";?>
                </div>

                <!-- Username -->
                <div class="label-input-group" >
                    <label for="username">Username:</label>
                    <?php echo "<input type='text' name='username' value= '$username'>";?>
                </div>

                <!--
                <div class="label-input-group">
                    <label for="location">Location:</label>
                    <input type="text" name="location" value="$location">
                </div>
                -->

                <!-- Email -->
                <div class="label-input-group">
                    <label for="email">Email:</label>
                    <?php echo "<input type='text' name='email' value= '$email'>";?>
                </div>
                
                <!-- Password -->
                <div class="label-input-group">
                    <label for="password">Change Password:</label>
                    <?php echo "<input type='password' name='password' placeholder= '************'>"; ?>
                </div>

                <div class="label-input-group">
                    <label for="password">Confirm Password:</label>
                    <?php echo "<input type='password' name='confirmpassword' placeholder='************'>"; ?>
                </div>
                
                <div class="label-input-group">
                    <label for="instagram">Instagram:</label>
                    <?php if($instagram != ''){echo "<input type='instagram' name='instagram' value='$instagram'>";} else{echo "<input type='instagram' name='instagram' placeholder='https://www.instagram.com/username'>";} ?>
                </div>
                
                <div class="label-input-group">
                    <label for="twitter">Twitter:</label>
                    <?php if($twitter != ''){echo "<input type='twitter' name='twitter' value='$twitter'>";} else{echo "<input type='twitter' name='twitter' placeholder='https://www.twitter.com/username'>";} ?>
                </div>
                
                <div class="label-input-group">
                    <label for="linkedin">LinkedIn:</label>
                    <?php if($linkedin != ''){echo "<input type='linkedin' name='linkedin' value='$linkedin'>";} else{echo "<input type='linkedin' name='linkedin' placeholder='https://www.linkedin.com/username'>";} ?>
                </div>

                <!-- Bio -->
                <div class="label-input-group">
                    <label for="bio">Bio:</label>
                    <textarea name="bio" id = "bio" rows="4" style="min-height: 50px;" maxlength = "500" onkeyup="limitTextCount('bio', 'divcount', 500);" onkeydown="limitTextCount('title', 'divcount', 100);"><?php echo GetBio(GetCurrentUsername()) ?></textarea>
                    <div id="divcount" style = "color: grey; text-align: right;">Max: 500 Characters</div>
                </div>
                
   
              </div>
          <div class="modal-footer">
            <a href = "action.php"><button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button></a>
            <button type="submit" class="btn btn-primary-og">Save changes</button>
          </div>
          
          </form>
        </div>
      </div>
    </div>
    <?php
    }
    ?>

    <!-- FADE ON SCROLL -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
    
    <!-- BOOTSTRAP REQUIRED RESOURCES -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>