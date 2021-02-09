<?php
//--Include Statments--//
include('functions.php');

//--Start Session--//
session_start();
$mysqli = ConnectDB();

//--Set Vital Data--//
$link = $_GET['link'];
$username = $_GET['username'];
$id = $_GET['id'];
$key = $_GET['key'];
$tag = 1;
$flag = true;

//--Check For Director Upload--//
if (isset($_POST['director'])){
    $director = $_POST['director'];

    if(!userExists_Email($director))
            {
                if ($director != '')
                {
                autoCreate($director);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET director = '$director' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET director = '$director' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$director'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For Producer Upload--//
    if (isset($_POST['producer'])){
        $producer = $_POST['producer'];

        if(!userExists_Email($producer))
            {
                if ($producer != '')
                {
                autoCreate($producer);
                }
            }

//--Update Input For Poster--//
        $sql = "UPDATE links SET producer = '$producer' WHERE link = '$link' AND RoutingNumber = '$id'";

        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET producer = '$producer' WHERE link = '$link' AND tagged = '$tag'"; 
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$producer'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }
//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false; 
            }

//--Acquire Contributer Information From Video--//
if ($flag){
    $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
    $INFOresult = $mysqli->query($INFOsql);
    while($INFOrow = $INFOresult->fetch_assoc()){ 
        $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
    $tag = 1;

//--Insert Video Into Portfolio--//
$INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

 $mysqli->query($INSERTsql);
 }            
  }    
}

//--Check For Editor Upload--//
    if (isset($_POST['editor'])){
        $editor = $_POST['editor'];

        if(!userExists_Email($editor))
            {
                if ($editor != '')
                {
                autoCreate($editor);
                }
            }

//--Update Input For Poster--//
        $sql = "UPDATE links SET editor = '$editor' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET editor = '$editor' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$editor'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false; 
            }

//--Acquire Contributer Information From Video--//
if ($flag){
    $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
    $INFOresult = $mysqli->query($INFOsql);
    while($INFOrow = $INFOresult->fetch_assoc()){ 
        $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
    $tag = 1;

//--Insert Video Into Portfolio--//
$INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

 $mysqli->query($INSERTsql);
 }            
  }    
}

//--Check For Writer Upload--//
    if (isset($_POST['writer'])){
        $writer = $_POST['writer'];

        if(!userExists_Email($writer))
            {
                if ($writer != '')
                {
                autoCreate($writer);
                }
            }

//--Update Input For Poster--//
        $sql = "UPDATE links SET writer = '$writer' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET writer = '$writer' WHERE link = '$link' AND tagged = '$tag'"; 
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$writer'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){
                $flag = false; 
            }

//--Acquire Contributer Information From Video--//
if ($flag){
    $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
    $INFOresult = $mysqli->query($INFOsql);
    while($INFOrow = $INFOresult->fetch_assoc()){ 
        $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
    $tag = 1;

//--Insert Video Into Portfolio--//
$INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

 $mysqli->query($INSERTsql);
 }            
  }    
}

//--Check For Cinematographer Upload--//
    if (isset($_POST['cinematographer'])){
        $cinematographer = $_POST['cinematographer'];

        if(!userExists_Email($cinematographer))
            {
                if ($cinematographer != '')
                {
                autoCreate($cinematographer);
                }
            }

//--Update Input For Poster--//
        $sql = "UPDATE links SET cinematographer = '$cinematographer' WHERE link = '$link' AND RoutingNumber = '$id'";

        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET cinematographer = '$cinematographer' WHERE link = '$link' AND tagged = '$tag'"; 
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$cinematographer'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false; 
            }

//--Acquire Contributer Information From Video--//
if ($flag){
    $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
    $INFOresult = $mysqli->query($INFOsql);
    while($INFOrow = $INFOresult->fetch_assoc()){ 
        $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
    $tag = 1;

//--Insert Video Into Portfolio--//
$INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

 $mysqli->query($INSERTsql);
 }            
  }    
}

//--Check For Story By Upload--//
if (isset($_POST['storyby'])){
    $storyby = $_POST['storyby'];

    if(!userExists_Email($storyby))
            {
                if ($storyby != '')
                {
                autoCreate($storyby);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET storyby = '$storyby' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET storyby = '$storyby' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$storyby'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For Production Designer Upload--//
if (isset($_POST['productiondesigner'])){
    $productiondesigner = $_POST['productiondesigner'];

    if(!userExists_Email($productiondesigner))
            {
                if ($productindesigner != '')
                {
                autoCreate($productiondesigner);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET productiondesigner = '$productiondesigner' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET productiondesigner = '$productiondesigner' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$productiondesigner'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For 1st Assistant Director Upload--//
if (isset($_POST['firstad'])){
    $firstad = $_POST['firstad'];

    if(!userExists_Email($firstad))
            {
                if ($firstad != '')
                {
                autoCreate($firstad);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET 1stassistantdirector = '$firstad' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET 1stassistantdirector = '$firstad' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$firstad'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For 2nd Assistant Director Upload--//
if (isset($_POST['secondad'])){
    $secondad = $_POST['secondad'];

    if(!userExists_Email($secondad))
            {
                if ($secondad != '')
                {
                autoCreate($secondad);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET 2ndassistantdirector = '$secondad' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET 2ndassistantdirector = '$secondad' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$secondad'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For 1st Assistant Camera Upload--//
if (isset($_POST['firstac'])){
    $firstac = $_POST['firstac'];

    if(!userExists_Email($firstac))
            {
                if ($firstac != '')
                {
                autoCreate($firstac);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET 1stassistantcamera = '$firstac' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET 1stassistantcamera = '$firstac' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$firstac'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For 2nd Assistant Camera Upload--//
if (isset($_POST['secondac'])){
    $secondac = $_POST['secondac'];

    if(!userExists_Email($secondac))
            {
                if ($secondac != '')
                {
                autoCreate($secondac);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET 2ndassistantcamera = '$secondac' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET 2ndassistantcamera = '$secondac' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$secondac'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For Production Sound Mixer Upload--//
if (isset($_POST['productionsm'])){
    $productionsm = $_POST['productionsm'];

    if(!userExists_Email($productionsm))
            {
                if ($productionsm != '')
                {
                autoCreate($productionsm);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET productionsoundmixer = '$productionsm' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET productionsoundmixer = '$productionsm' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$productionsm'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For Color Grader Upload--//
if (isset($_POST['colorgrader'])){
    $colorgrader = $_POST['colorgrader'];

    if(!userExists_Email($colorgrader))
            {
                if ($colorgrader != '')
                {
                autoCreate($colorgrader);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET colorgrader = '$colorgrader' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET colorgrader = '$colorgrader' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$colorgrader'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }

//--Check For Moral Support Upload--//
if (isset($_POST['moralsupport'])){
    $moralsupport = $_POST['moralsupport'];

    if(!userExists_Email($moralsupport))
            {
                if ($moralsupport != '')
                {
                autoCreate($moralsupport);
                }
            }

//--Update Input For Poster--//
    $sql = "UPDATE links SET moralsupport = '$moralsupport' WHERE link = '$link' AND RoutingNumber = '$id'";
        if($mysqli->query($sql) === true){

//--Update Input For Contributers--//
            $sql = "UPDATE links SET moralsupport = '$moralsupport' WHERE link = '$link' AND tagged = '$tag'";
            $mysqli->query($sql);

            $IDsql = "SELECT id FROM users WHERE email = '$moralsupport'";
            $IDresult = $mysqli->query($IDsql);
            while($IDrow = $IDresult->fetch_assoc()){ 
                $RoutingNumber = $IDrow['id']; 
            }

//--Check To See If Video Already Exists On Contributers Portfolio--//
            $CHECKsql = "SELECT * FROM links where link = '$link' AND RoutingNumber = '$RoutingNumber'";
            $CHECKresult = $mysqli->query($CHECKsql);
            while($CHECKrow = $CHECKresult->fetch_assoc()){ 
                $flag = false;
            }

//--Acquire Contributer Information From Video--//
            if ($flag){
            $INFOsql = "SELECT * FROM links WHERE link = '$link' AND RoutingNumber = '$id'";
            $INFOresult = $mysqli->query($INFOsql);
            while($INFOrow = $INFOresult->fetch_assoc()){ 
                $url = $INFOrow['link']; 
                $director = $INFOrow['director'];
                $editor = $INFOrow['editor'];
                $writer = $INFOrow['writer'];
                $producer = $INFOrow['producer'];
                $cinematographer = $INFOrow['cinematographer'];
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
            $tag = 1;

        //--Insert Video Into Portfolio--//
        $INSERTsql = "INSERT INTO links (link, director, editor, writer, producer, cinematographer, storyby, productiondesigner, 1stassistantdirector, 2ndassistantdirector, 1stassistantcamera, 2ndassistantcamera, productionsoundmixer, colorgrader, moralsupport, RoutingNumber, tagged)"
        ."VALUES ('$url', '$director', '$editor', '$writer', '$producer', '$cinematographer', '$storyby', '$productiondesigner', '$firstad', '$secondad', '$firstac', '$secondac', '$productionsm', '$colorgrader', '$moralsupport', '$RoutingNumber', '$tag')";

         $mysqli->query($INSERTsql);
         }            
          }    
    }
//--Route Back To Project Page--//
    header("location: project.php?link=$link&username=$username");




?>