<?php
    session_start();
    include("config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $send_msg = mysqli_real_escape_string($db,$_POST['msg']);
        $conversation_id = mysqli_real_escape_string($db,$_POST['convid']);
        $sender = mysqli_real_escape_string($db,$_POST['sndr']);
        $receiver = mysqli_real_escape_string($db,$_POST['rcvr']);

        //$msg_date = date_create();
        $msg_date = date("Y-m-d h:m:s");
        
        $sql = "INSERT INTO `user_conversation_messages`
        (`conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`, `message_deleted`) 
        VALUES 
        ($conversation_id,'$send_msg','$sender','$receiver','$msg_date',0,0)";
        if(mysqli_query($db,$sql)){
            //
            echo "sent";
        }else{
            $output = "|[System Error]|:. [Send message - ".mysqli_error($db)."]";
            echo $output;
        }
    }else{
        echo "|[System Error]|:. [Send message - Cannot POST]";
    }
?>