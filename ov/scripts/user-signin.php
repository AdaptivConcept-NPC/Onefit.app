<?php
    session_start();
    include("config.php");
    
    //Connection Test==============================================>
        // Check connection
        /*if ($db->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        }
        echo "Connected successfully";*/
    //end of Connection Test============================================>

    $myusername = mysqli_real_escape_string($db,$_GET['username']);
    $mypassword = mysqli_real_escape_string($db,$_GET['password']);
    
    //$sql = "SELECT * FROM `normal_user_accounts` WHERE (user_id = '".$myusername."' OR user_email = '".$myusername."') AND user_password = '".$mypassword."'";
    
    $sql = "SELECT * FROM `users` WHERE (`username` = '$myusername' OR `user_email` = '$myusername') AND `password_hash` = '$mypassword'";
    
    $userDetailsArray = array();
    $foundUser = false;

    if($result = mysqli_query($db,$sql)){
        
        while($row = mysqli_fetch_assoc($result)){
            $foundUser = true;
            $userDetailsArray = $row;
        }

        if($foundUser == true){
            echo json_encode($userDetailsArray);
        }else{
            $output = "|[System Error]|:. [Incorrect username or password. Please check your input and try again.]";
            echo $output;
        }
        
        
    }else{
        $output = "|[System Error]|:. [".mysqli_error($db)."]";
        echo $output;
    }
?>