<?php
    session_start();
    include("./config.php");
    
    //Connection Test==============================================>
        // Check connection
        /*if ($db->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        }*/
        //echo "Connected successfully";
    //end of Connection Test============================================>

    $regusername = mysqli_real_escape_string($db,$_GET['username']);
    $regpassword = mysqli_real_escape_string($db,$_GET['password']);
    $regname = mysqli_real_escape_string($db,$_GET['name']);
    $regsurname = mysqli_real_escape_string($db,$_GET['surname']);
    $regidnumber = mysqli_real_escape_string($db,$_GET['idnumber']);
    $regemail = mysqli_real_escape_string($db,$_GET['email']);
    $regcontact = mysqli_real_escape_string($db,$_GET['contact']);
    $regdob = mysqli_real_escape_string($db,$_GET['dob']);
    $reggender = mysqli_real_escape_string($db,$_GET['gender']);
    $regrace = mysqli_real_escape_string($db,$_GET['race']);
    $regnationality = mysqli_real_escape_string($db,$_GET['nationality']);

//`user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`
    
    $sql = "INSERT INTO `users`
    (`username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`) 
    VALUES 
    ('$regusername','$regpassword','$regname','$regsurname','$regidnumber','$regemail','$regcontact','$regdob','$reggender','$regrace','$regnationality', 0)";
    
    if(mysqli_query($db,$sql)){
        //send out email
        echo "Successful Registration";
        
    }else{
        $output = "|[System Error]|:. [".mysqli_error($db)."]";
        echo $output;
    }
?>