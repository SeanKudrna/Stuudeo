<?php

//--Include Statments--//
    include('session.php');
    include('functions.php');

//--Start Session--//
    session_start();
    $mysqli = ConnectDB();

//--Possible Characters--//
    $gen = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

//--Generate Code (1 in 1,037,158,320 Chance of Generating The Same Code Twice)--//
    $one_time_code =  substr(str_shuffle($gen), 0, 8) . '_' . substr(str_shuffle($gen), 0, 6);

//--Log Code in Database--//
    $log_code = "INSERT INTO one_time_codes (code)" 
    . "VALUES ('$one_time_code')";
   

    if($mysqli->query($log_code) === true){
        echo "-Copy the code below and paste into form during registration.-<br><br>";
        echo "Your one time code is: " . $one_time_code. "<br><br>";
        echo "<a href = logout_alg.php?testroute=reg><button>Click Here to Logout And Register</button></a>";
        echo"<br><br><br>NOTE:<br>
        -------------------------------------------------------------------------------<br>
             Once emailing is set up, when a contributer is linked in a video post,<br>
             that contributer will be sent a stylized email informing them they have<br>
             been credited, as well as an invitation to join STuuDEO. The email<br>
             will provide the future user with a link to register, and the one time<br>
             code they will need to activate their account. Until then, this mini form<br>
             allows us to generate codes to use and test / show this process works.<br>
             -------------------------------------------------------------------------------";


    }
?>

