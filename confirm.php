<?php

//--Include Statments--//
include('session.php');
include('functions.php');

if(!isset($_SESSION['login_user']) || $_SESSION['username'] == "guest"){
header("location: login.php"); // Redirecting To Home Page
}

//--Start Session--//
session_start();
$mysqli = ConnectDB();

//Empty Array
$_SESSION['establish_crew'] = [[]];

$tag = 0;
$url = $_SESSION['url'];

if(strpos($url, "&"))
    {
        $url = substr($url, 0, strpos($url, '&'));
        $_SESSION['url'] = $url;
    }

$director = $_GET['director'];
$writer = $_GET['writer'];
$storyby = $_GET['storyby'];
$producer = $_GET['producer'];
$productiondesigner = $_GET['productiondesigner'];
$cinematographer = $_GET['cinematographer'];
$editor = $_GET['editor'];
$firstad = $_GET['firstad'];
$secondad = $_GET['secondad'];
$firstac = $_GET['firstac'];
$secondac = $_GET['secondac'];
$productionsm = $_GET['productionsm'];
$colorgrader = $_GET['colorgrader'];
$moralsupport = $_GET['moralsupport'];

$username = GetCurrentUsername();
$email = GetEmail($username);
            
            //If Linked Contributor Does Not Exist, Create Defualt Account
            //Check Email
            if(!userExists_Email($director))
            {
                if ($director != '')
                {
                autoCreate($director);
                }
            }

            if(!userExists_Email($writer))
            {
                if ($writer != '')
                {
                autoCreate($writer);
                }
            }

            if(!userExists_Email($storyby))
            {
                if ($storyby != '')
                {
                autoCreate($storyby);
                }
            }

            if(!userExists_Email($producer))
            {
                if ($producer != '')
                {
                autoCreate($producer);
                }
            }

            if(!userExists_Email($productiondesigner))
            {
                if ($productiondesigner != '')
                {
                autoCreate($productiondesigner);
                }
            }

            if(!userExists_Email($cinematographer))
            {
                if ($cinematographer != '')
                {
                autoCreate($cinematographer);
                }
            }

            if(!userExists_Email($editor))
            {
                if ($editor != '')
                {
                autoCreate($editor);
                }
            }

            if(!userExists_Email($firstad))
            {
                if ($firstad != '')
                {
                autoCreate($firstad);
                }
            }

            if(!userExists_Email($secondad))
            {
                if ($secondad != '')
                {
                autoCreate($secondad);
                }
            }

            if(!userExists_Email($firstac))
            {
                if ($firstac != '')
                {
                autoCreate($firstac);
                }
            }

            if(!userExists_Email($secondac))
            {
                if ($secondac != '')
                {
                autoCreate($secondac);
                }
            }

            if(!userExists_Email($productionsm))
            {
                if ($productionsm != '')
                {
                autoCreate($productionsm);
                }
            }

            if(!userExists_Email($colorgrader))
            {
                if ($colorgrader != '')
                {
                autoCreate($colorgrader);
                }
            }

            if(!userExists_Email($moralsupport))
            {
                if ($moralsupport != '')
                {
                autoCreate($moralsupport);
                }
            }
            
            //Set Contributor Variable = Corresponding Email if User Entered Username
            //if ($dun){$director = GetEmail($director);}
            //if ($eun){$editor = GetEmail($editor);}
            //if ($wun){$writer = GetEmail($writer);}
            //if ($pun){$producer = GetEmail($producer);}
            //if ($cun){$cinematographer = GetEmail($cinematographer);}




//--Gather Vital Data--//
        $getID = "SELECT id, email FROM users WHERE username = '$username'";
        $IDresult = $mysqli->query($getID);
        while($row = $IDresult->fetch_assoc()){ 
            $RoutingNumber = $row['id'];
            $email = $row['email'];
        }

//--Add Video--//
        $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
         ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

        if($mysqli->query($sql) === true){
            $tag = 1;

//--Prevent Double Adding of Videos to Contributers Profiles--//
        if ($director != $email){

            //Director ID
            $DirRoutingNumber = GetUserID_Email($director);
            
            
            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$DirRoutingNumber', '$tag')";
            $mysqli->query($sql);
                
        }


        if ($editor != $email && $editor != $director){

            //Editor ID
            $EdiRoutingNumber = GetUserID_Email($editor);
            
            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$EdiRoutingNumber', '$tag')";
         $mysqli->query($sql);
        }

        if ($writer != $email && $writer != $editor && $writer != $director){

            //Writer ID
            $WriRoutingNumber = GetUserID_Email($writer);
            
            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$WriRoutingNumber', '$tag')";
         $mysqli->query($sql);
        }

        if ($producer != $email && $producer != $writer && $producer != $editor && $producer != $director){

            //Producer ID
            $ProRoutingNumber = GetUserID_Email($producer);
            
            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$ProRoutingNumber', '$tag')";
         $mysqli->query($sql);
        }

        if ($cinematographer != $email && $cinematographer != $producer && $cinematographer != $writer && $cinematographer != $editor && $cinematographer != $director){

            //Cinematographer ID
            $CinRoutingNumber = GetUserID_Email($cinematographer);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$CinRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($storyby != $email && $storyby != $cinematographer && $storyby != $producer && $storyby != $writer && $storyby != $editor && $storyby != $director){

            //Cinematographer ID
            $STbyRoutingNumber = GetUserID_Email($storyby);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$STbyRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($productiondesigner != $email && $productiondesigner != $storyby && $productiondesigner != $cinematographer && $productiondesigner != $producer && $productiondesigner != $writer && $productiondesigner != $editor && $productiondesigner != $director){

            //Cinematographer ID
            $PDRoutingNumber = GetUserID_Email($productiondesigner);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$PDRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($firstad != $email && $firstad != $productiondesigner && $firstad != $storyby && $firstad != $cinematographer && $firstad != $producer && $firstad != $writer && $firstad != $editor && $firstad != $director){

            //Cinematographer ID
            $FADRoutingNumber = GetUserID_Email($firstad);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$FADRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($secondad != $email && $secondad != $firstad && $secondad != $productiondesigner && $secondad != $storyby && $secondad != $cinematographer && $secondad != $producer && $secondad != $writer && $secondad != $editor && $secondad != $director){

            //Cinematographer ID
            $SADRoutingNumber = GetUserID_Email($secondad);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$SADRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($firstac != $email && $firstac != $secondad && $firstac != $firstad && $firstac != $productiondesigner && $firstac != $storyby && $firstac != $cinematographer && $firstac != $producer && $firstac != $writer && $firstac != $editor && $firstac != $director){

            //Cinematographer ID
            $FACRoutingNumber = GetUserID_Email($firstac);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$FACRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($secondac != $email && $secondac != $firstac && $secondac != $secondad && $secondac != $firstad && $secondac != $productiondesigner && $secondac != $storyby && $secondac != $cinematographer && $secondac != $producer && $secondac != $writer && $secondac != $editor && $secondac != $director){

            //Cinematographer ID
            $SACRoutingNumber = GetUserID_Email($secondac);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$SACRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($productionsm != $email && $productionsm != $secondac && $productionsm != $firstac && $productionsm != $secondad && $productionsm != $firstad && $productionsm != $productiondesigner && $productionsm != $storyby && $productionsm != $cinematographer && $productionsm != $producer && $productionsm != $writer && $productionsm != $editor && $productionsm != $director){

            //Cinematographer ID
            $PSMRoutingNumber = GetUserID_Email($productionsm);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$PSMRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($colorgrader != $email && $colorgrader != $productionsm && $colorgrader != $secondac && $colorgrader != $firstac && $colorgrader != $secondad && $colorgrader != $firstad && $colorgrader != $productiondesigner && $colorgrader != $storyby && $colorgrader != $cinematographer && $colorgrader != $producer && $colorgrader != $writer && $colorgrader != $editor && $colorgrader != $director){

            //Cinematographer ID
            $CGRoutingNumber = GetUserID_Email($colorgrader);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$CGRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        if ($moralsupport != $email && $moralsupport != $colorgrader && $moralsupport != $productionsm && $moralsupport != $secondac && $moralsupport != $firstac && $moralsupport != $secondad && $moralsupport != $firstad && $moralsupport != $productiondesigner && $moralsupport != $storyby && $moralsupport != $cinematographer && $moralsupport != $producer && $moralsupport != $writer && $moralsupport != $editor && $moralsupport != $director){

            //Cinematographer ID
            $MSRoutingNumber = GetUserID_Email($moralsupport);

            $sql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
            ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$MSRoutingNumber', '$tag')";
            $mysqli->query($sql);

        }

        $sql = "DELETE FROM links WHERE RoutingNumber = 0 AND link = '$url'";
        $mysqli->query($sql);



//--Route To Project Page--//
          header("location: project.php?link=$url&username=$username");
        }
    
?>